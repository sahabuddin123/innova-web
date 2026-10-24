<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreInvestmentRequest;
use App\Http\Requests\Api\V1\UpdateInvestmentRequest;
use App\Models\Invesments;
use App\Models\InvestmentWithdraw;
use App\Models\Shareholder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Class InvestmentApiController
 *
 * Handles administrative REST APIs for capital investments, vouchers, and balance safeguards.
 *
 * @package App\Http\Controllers\Api\V1
 */
class InvestmentApiController extends ApiController
{
    /**
     * Display a listing of capital investment records with optional filters.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Invesments::query()->with('shareholder:id,name,phone,email,designation');

        if ($request->filled('shareholder_id')) {
            $query->where('shareholder_id', (int) $request->shareholder_id);
        }

        if ($request->has('isActive') && $request->isActive !== null && $request->isActive !== '') {
            $query->where('isActive', (int) $request->isActive);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('recevedDate', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('recevedDate', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('recevedBy', 'LIKE', $search)
                  ->orWhere('paidremark', 'LIKE', $search)
                  ->orWhereHas('shareholder', function ($sq) use ($search) {
                      $sq->where('name', 'LIKE', $search);
                  });
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $investments = $query->orderBy('recevedDate', 'desc')
                             ->orderBy('id', 'desc')
                             ->paginate($perPage);

        // Normalize amount presentation for all records using BCMath
        $investments->getCollection()->transform(function ($inv) {
            $clean = str_replace(',', '', (string) $inv->amount);
            $inv->numeric_amount = is_numeric($clean) ? (float) bcadd($clean, '0', 2) : 0.0;
            return $inv;
        });

        return $this->success($investments, 'Investment records retrieved successfully');
    }

    /**
     * Store a newly created capital investment record in storage.
     *
     * @param StoreInvestmentRequest $request
     * @return JsonResponse
     */
    public function store(StoreInvestmentRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Ensure amount is stored as clean decimal-safe representation
        $cleanAmount = str_replace(',', '', (string) $data['amount']);
        $normalizedAmount = is_numeric($cleanAmount) ? bcadd($cleanAmount, '0', 2) : '0.00';
        $data['amount'] = $normalizedAmount;

        $investment = Invesments::create($data);
        $investment->load('shareholder:id,name,phone,email,designation');
        $investment->numeric_amount = (float) $normalizedAmount;

        return $this->success($investment, 'Investment record created successfully', 201);
    }

    /**
     * Display the specified capital investment record.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $investment = Invesments::with('shareholder:id,name,phone,email,designation')->find($id);

        if (!$investment) {
            return $this->error('Investment record not found', 404);
        }

        $clean = str_replace(',', '', (string) $investment->amount);
        $investment->numeric_amount = is_numeric($clean) ? (float) bcadd($clean, '0', 2) : 0.0;

        return $this->success($investment, 'Investment details retrieved successfully');
    }

    /**
     * Update the specified capital investment record in storage.
     *
     * @param UpdateInvestmentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateInvestmentRequest $request, int $id): JsonResponse
    {
        $investment = Invesments::find($id);

        if (!$investment) {
            return $this->error('Investment record not found', 404);
        }

        $data = $request->validated();

        if (isset($data['amount'])) {
            $cleanAmount = str_replace(',', '', (string) $data['amount']);
            $data['amount'] = is_numeric($cleanAmount) ? bcadd($cleanAmount, '0', 2) : '0.00';
        }

        // Decimal-Safe Capital Balance Safeguard: Prevent updates that reduce active investments below approved withdrawals
        $originalShareholderId = (int) $investment->shareholder_id;
        $origClean = str_replace(',', '', (string) $investment->amount);
        $originalAmount = ($investment->isActive == 1 && is_numeric($origClean)) ? bcadd($origClean, '0', 2) : '0.00';

        $targetShareholderId = isset($data['shareholder_id']) ? (int) $data['shareholder_id'] : $originalShareholderId;
        $targetIsActive = isset($data['isActive']) ? (int) $data['isActive'] : (int) $investment->isActive;
        $targetAmtClean = isset($data['amount']) ? str_replace(',', '', (string) $data['amount']) : $origClean;
        $targetAmount = is_numeric($targetAmtClean) ? bcadd($targetAmtClean, '0', 2) : '0.00';
        $newActiveAmount = ($targetIsActive == 1) ? $targetAmount : '0.00';

        // Check if this update affects the original shareholder's active balance
        if ($investment->isActive == 1 || $targetIsActive == 1) {
            $allActive = Invesments::where('shareholder_id', $originalShareholderId)
                ->where('isActive', 1)
                ->get();

            $totalActive = '0.00';
            foreach ($allActive as $inv) {
                $amt = str_replace(',', '', (string) $inv->amount);
                if (is_numeric($amt)) {
                    $totalActive = bcadd($totalActive, $amt, 2);
                }
            }

            $totalWithdrawn = '0.00';
            if (class_exists(InvestmentWithdraw::class) && Schema::hasTable('investment_withdraws')) {
                $withdrawals = InvestmentWithdraw::where('shareholder_id', $originalShareholderId)
                    ->whereIn('status', ['approved', '1'])
                    ->get();

                foreach ($withdrawals as $w) {
                    $wAmt = str_replace(',', '', (string) $w->amount);
                    if (is_numeric($wAmt)) {
                        $totalWithdrawn = bcadd($totalWithdrawn, $wAmt, 2);
                    }
                }
            }

            if ($targetShareholderId === $originalShareholderId) {
                $projectedActive = bcadd(bcsub($totalActive, $originalAmount, 2), $newActiveAmount, 2);
            } else {
                $projectedActive = bcsub($totalActive, $originalAmount, 2);
            }
            $projectedBalance = bcsub($projectedActive, $totalWithdrawn, 2);

            if (bccomp($projectedBalance, '0.00', 2) < 0) {
                return $this->error('Cannot update investment: Shareholder outstanding balance would become negative (' . (float) $projectedBalance . ') due to existing approved withdrawals.', 422);
            }
        }

        $investment->update($data);
        $investment->load('shareholder:id,name,phone,email,designation');
        $clean = str_replace(',', '', (string) $investment->amount);
        $investment->numeric_amount = is_numeric($clean) ? (float) bcadd($clean, '0', 2) : 0.0;

        return $this->success($investment, 'Investment record updated successfully');
    }

    /**
     * Remove the specified capital investment record with outstanding balance safeguards.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $investment = Invesments::find($id);

        if (!$investment) {
            return $this->error('Investment record not found', 404);
        }

        // Safeguard: Check if deleting this active investment would cause shareholder's
        // outstanding balance to become negative due to existing approved withdrawals
        if ($investment->isActive == 1) {
            $shareholderId = $investment->shareholder_id;
            $invClean = str_replace(',', '', (string) $investment->amount);
            $investmentAmount = is_numeric($invClean) ? bcadd($invClean, '0', 2) : '0.00';

            $allActiveInvestments = Invesments::where('shareholder_id', $shareholderId)
                ->where('isActive', 1)
                ->get();

            $totalActive = '0.00';
            foreach ($allActiveInvestments as $inv) {
                $amt = str_replace(',', '', (string) $inv->amount);
                if (is_numeric($amt)) {
                    $totalActive = bcadd($totalActive, $amt, 2);
                }
            }

            $totalWithdrawn = '0.00';
            if (class_exists(InvestmentWithdraw::class) && Schema::hasTable('investment_withdraws')) {
                $withdrawals = InvestmentWithdraw::where('shareholder_id', $shareholderId)
                    ->whereIn('status', ['approved', '1'])
                    ->get();

                foreach ($withdrawals as $w) {
                    $wAmt = str_replace(',', '', (string) $w->amount);
                    if (is_numeric($wAmt)) {
                        $totalWithdrawn = bcadd($totalWithdrawn, $wAmt, 2);
                    }
                }
            }

            $projectedBalance = bcsub(bcsub($totalActive, $investmentAmount, 2), $totalWithdrawn, 2);

            if (bccomp($projectedBalance, '0.00', 2) < 0) {
                return $this->error('Cannot delete investment: Shareholder outstanding balance would become negative (' . (float) $projectedBalance . ') due to existing approved withdrawals.', 422);
            }
        }

        $investment->delete();

        return $this->success(null, 'Investment record deleted successfully');
    }
}
