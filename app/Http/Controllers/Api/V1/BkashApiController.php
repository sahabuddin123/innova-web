<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ExecuteBkashPaymentRequest;
use App\Http\Requests\Api\V1\InitiateBkashPaymentRequest;
use App\Models\Admin;
use App\Models\FeesTransections;
use App\Models\Students;
use App\Models\User;
use App\Services\BkashService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class BkashApiController
 *
 * REST API controller managing bKash checkout payment initiation,
 * server-side verification callbacks, idempotent recording, and reconciliation.
 *
 * @package App\Http\Controllers\Api\V1
 */
class BkashApiController extends ApiController
{
    /**
     * @var BkashService
     */
    protected $bkashService;

    /**
     * BkashApiController constructor.
     *
     * @param BkashService $bkashService
     */
    public function __construct(BkashService $bkashService)
    {
        $this->bkashService = $bkashService;
    }

    /**
     * Initiate a bKash checkout session for tuition fee payment.
     * Accessible by authenticated Students (for themselves) or Admins (for any student).
     *
     * @param InitiateBkashPaymentRequest $request
     * @return JsonResponse
     */
    public function createPayment(InitiateBkashPaymentRequest $request): JsonResponse
    {
        $currentUser = $request->user();
        $student = null;

        if ($currentUser instanceof User) {
            $student = Students::where('user_id', $currentUser->id)
                ->whereNull('deleted_at')
                ->first();

            if (!$student) {
                return $this->error('No active student profile linked to your user account', 404);
            }
        } elseif ($currentUser instanceof Admin) {
            if (!$request->filled('student_id')) {
                return $this->error('Student ID is required when initiating payment as administrator', 422);
            }
            $student = Students::whereNull('deleted_at')->find($request->student_id);
            if (!$student) {
                return $this->error('Student record not found', 404);
            }
        } else {
            return $this->error('Unauthenticated.', 401);
        }

        // Validate amount against outstanding balance
        $totalPaid = (float) FeesTransections::where('student_id', $student->id)
            ->where('paymentType', 1)
            ->where('status', 0)
            ->sum('paidamount');

        $netPayable = (float) ($student->balance ?? 0);
        $dueAmount  = max(0, $netPayable - $totalPaid);
        $amount     = (float) $request->amount;

        if ($dueAmount > 0 && $amount > $dueAmount) {
            return $this->error("Payment amount ({$amount} BDT) cannot exceed outstanding course fee balance of {$dueAmount} BDT", 422);
        }

        try {
            $response = $this->bkashService->createPayment($amount);
            $paymentId = $response['paymentID'] ?? null;

            if ($paymentId) {
                // Securely bind payment intent on the server to prevent cross-account hijacking
                Cache::put('bkash_intent_' . $paymentId, [
                    'payment_id'      => $paymentId,
                    'student_id'      => (int) $student->id,
                    'user_id'         => $student->user_id ? (int) $student->user_id : null,
                    'initiator_id'    => (int) $currentUser->id,
                    'initiator_type'  => get_class($currentUser),
                    'expected_amount' => (string) $amount,
                    'payment_type'    => (int) ($request->payment_type ?? 1),
                    'created_at'      => now()->toIso8601String(),
                ], now()->addMinutes(30));
            }

            return $this->success([
                'paymentID'             => $paymentId,
                'createTime'            => $response['createTime'] ?? null,
                'orgLogo'               => $response['orgLogo'] ?? null,
                'orgName'               => $response['orgName'] ?? null,
                'transactionStatus'     => $response['transactionStatus'] ?? 'Initiated',
                'amount'                => (string) $amount,
                'currency'              => 'BDT',
                'intent'                => 'sale',
                'merchantInvoiceNumber' => $response['merchantInvoiceNumber'] ?? null,
                'bkashURL'              => $response['bkashURL'] ?? null,
                'student_id'            => $student->id,
            ], 'bKash checkout session created successfully', 201);
        } catch (Exception $e) {
            Log::error('bKash createPayment failure: ' . $e->getMessage());
            return $this->error('Failed to initiate bKash checkout: ' . $e->getMessage(), 502);
        }
    }

    /**
     * Server-side callback / execution endpoint.
     * Verifies payment authenticity directly with bKash servers, enforces idempotency,
     * validates payment intent binding, and records the payment without double-counting.
     *
     * @param ExecuteBkashPaymentRequest $request
     * @return JsonResponse
     */
    public function callback(ExecuteBkashPaymentRequest $request): JsonResponse
    {
        $currentUser = $request->user();
        $student = null;

        if ($currentUser instanceof User) {
            $student = Students::where('user_id', $currentUser->id)
                ->whereNull('deleted_at')
                ->first();

            if (!$student) {
                return $this->error('No active student profile linked to your user account', 404);
            }
        } elseif ($currentUser instanceof Admin) {
            if ($request->filled('student_id')) {
                $student = Students::whereNull('deleted_at')->find($request->student_id);
            }
        } else {
            return $this->error('Unauthenticated.', 401);
        }

        $paymentId = $request->payment_id;

        // Fast-path idempotency check: was this paymentID already successfully captured?
        $existing = FeesTransections::where('paymentID', $paymentId)->first();
        if ($existing) {
            // Protect financial privacy: a student cannot view another student's replayed payment
            if ($currentUser instanceof User && (int) $existing->student_id !== (int) $student->id) {
                return $this->error('Forbidden: You can only view your own payment transactions', 403);
            }

            return $this->success([
                'transaction'   => $existing->fresh(['student']),
                'is_duplicate'  => true,
                'message'       => 'Payment was already verified and recorded.',
            ], 'Payment already processed', 200);
        }

        // Validate payment session intent binding
        $intent = Cache::get('bkash_intent_' . $paymentId);
        if (!$intent) {
            return $this->error('Payment session not found, expired, or was not initiated by this system.', 422);
        }

        // Enforce anti-hijacking: students can only execute payments initiated for their own student record
        if ($currentUser instanceof User && (int) $intent['student_id'] !== (int) $student->id) {
            return $this->error('Forbidden: This payment session belongs to a different student account', 403);
        }

        // If admin specifies student_id, ensure it matches the intent
        if ($currentUser instanceof Admin && $student && (int) $student->id !== (int) $intent['student_id']) {
            return $this->error('Validation error: Provided student_id does not match the payment session intent', 422);
        }

        $lockKey = 'bkash_payment_exec_' . $paymentId;
        $lock = Cache::lock($lockKey, 15);

        if (!$lock->get()) {
            // Concurrency contention: wait briefly for sibling request to finish
            sleep(1);
            $existing = FeesTransections::where('paymentID', $paymentId)->first();
            if ($existing) {
                return $this->success([
                    'transaction'  => $existing->fresh(['student']),
                    'is_duplicate' => true,
                ], 'Payment already processed by concurrent request', 200);
            }
            return $this->error('Concurrent payment processing in progress. Please retry in a few moments.', 409);
        }

        try {
            // Verify payment directly with bKash servers
            $result = $this->bkashService->executePayment($paymentId);

            if (empty($result) || !is_array($result)) {
                return $this->error('Gateway verification failed: Empty response from bKash', 502);
            }

            if (isset($result['errorCode']) && $result['errorCode'] !== '0000') {
                $err = $result['errorMessage'] ?? 'Payment execution declined by gateway';
                return $this->error('bKash execution error: ' . $err, 422, $result);
            }

            $trxStatus = strtolower($result['transactionStatus'] ?? '');
            if ($trxStatus !== 'completed') {
                return $this->error("Payment status '{$trxStatus}' is not completed. Funds were not captured.", 422, $result);
            }

            $trxId = $result['trxID'] ?? null;
            if (empty($trxId)) {
                return $this->error('Payment gateway verification succeeded but no transaction ID (trxID) was returned', 502);
            }

            // Verify gateway amount matches initiated expected amount
            $capturedAmount = (float) ($result['amount'] ?? 0);
            $expectedAmount = (float) $intent['expected_amount'];
            if (abs($capturedAmount - $expectedAmount) > 0.01) {
                return $this->error("Payment verification failed: Gateway captured amount ({$capturedAmount}) does not match initiated amount ({$expectedAmount})", 422);
            }

            // Secondary deduplication on trxID
            $existingTrx = FeesTransections::where('trxID', $trxId)->first();
            if ($existingTrx) {
                return $this->success([
                    'transaction'  => $existingTrx->fresh(['student']),
                    'is_duplicate' => true,
                ], 'Payment with this transaction ID was already recorded', 200);
            }

            $paidAmount = number_format($capturedAmount, 2, '.', '');

            // Persist verified transaction bound to intent's student_id
            $transaction = DB::transaction(function () use ($intent, $paidAmount, $trxId, $paymentId) {
                return FeesTransections::create([
                    'student_id'  => $intent['student_id'],
                    'user_id'     => $intent['user_id'],
                    'paidamount'  => $paidAmount,
                    'paymentType' => $intent['payment_type'] ?? 1,
                    'paiddate'    => Carbon::now()->format('Y-m-d'),
                    'paidremark'  => 'Pay by Bkash',
                    'channel'     => 2, // 2 = bKash
                    'status'      => 1, // 1 = Pending admin approval (legacy business rule)
                    'trxID'       => $trxId,
                    'paymentID'   => $paymentId,
                ]);
            });

            // Clean up the intent from cache once successfully captured
            Cache::forget('bkash_intent_' . $paymentId);

            return $this->success([
                'transaction'  => $transaction->fresh(['student']),
                'gateway_data' => [
                    'trxID'             => $trxId,
                    'paymentID'         => $paymentId,
                    'amount'            => $paidAmount,
                    'transactionStatus' => $result['transactionStatus'],
                ],
                'is_duplicate' => false,
            ], 'bKash payment verified and recorded successfully', 201);
        } catch (Exception $e) {
            Log::error('bKash callback error: ' . $e->getMessage());
            return $this->error('Payment verification failed: ' . $e->getMessage(), 502);
        } finally {
            $lock->release();
        }
    }

    /**
     * Query gateway status for a specific paymentID and reconcile with local database.
     * Accessible exclusively by Admins with fees-log or fees-list permission.
     *
     * @param Request $request
     * @param string $paymentID
     * @return JsonResponse
     */
    public function query(Request $request, string $paymentID): JsonResponse
    {
        $currentUser = $request->user();
        if (!($currentUser instanceof Admin) || (!$currentUser->can('fees-list') && !$currentUser->can('fees-log'))) {
            return $this->error('Forbidden: Insufficient permissions to reconcile payments', 403);
        }

        try {
            $gatewayData = $this->bkashService->queryPayment($paymentID);
            $localRecord = FeesTransections::with('student:id,sname,phone')
                ->where('paymentID', $paymentID)
                ->first();

            $isReconciled = false;
            if ($localRecord && !empty($gatewayData['amount'])) {
                $isReconciled = (float) $localRecord->paidamount === (float) $gatewayData['amount'];
            }

            return $this->success([
                'paymentID'     => $paymentID,
                'gateway_data'  => $gatewayData,
                'local_record'  => $localRecord,
                'is_recorded'   => $localRecord !== null,
                'is_reconciled' => $isReconciled,
            ], 'Payment reconciliation query completed');
        } catch (Exception $e) {
            return $this->error('Failed to query payment gateway: ' . $e->getMessage(), 502);
        }
    }

    /**
     * Search transaction on bKash gateway by trxID and reconcile with local database.
     * Accessible exclusively by Admins with fees-log or fees-list permission.
     *
     * @param Request $request
     * @param string $trxID
     * @return JsonResponse
     */
    public function search(Request $request, string $trxID): JsonResponse
    {
        $currentUser = $request->user();
        if (!($currentUser instanceof Admin) || (!$currentUser->can('fees-list') && !$currentUser->can('fees-log'))) {
            return $this->error('Forbidden: Insufficient permissions to search gateway transactions', 403);
        }

        try {
            $gatewayData = $this->bkashService->searchTransaction($trxID);
            $localRecord = FeesTransections::with('student:id,sname,phone')
                ->where('trxID', $trxID)
                ->first();

            $isReconciled = false;
            if ($localRecord && !empty($gatewayData['amount'])) {
                $isReconciled = (float) $localRecord->paidamount === (float) $gatewayData['amount'];
            }

            return $this->success([
                'trxID'         => $trxID,
                'gateway_data'  => $gatewayData,
                'local_record'  => $localRecord,
                'is_recorded'   => $localRecord !== null,
                'is_reconciled' => $isReconciled,
            ], 'Transaction search query completed');
        } catch (Exception $e) {
            return $this->error('Failed to search gateway transaction: ' . $e->getMessage(), 502);
        }
    }
}
