<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreShareholderRequest;
use App\Http\Requests\Api\V1\UpdateShareholderRequest;
use App\Models\BankLoan;
use App\Models\DividendWithdraw;
use App\Models\Invesments;
use App\Models\InvestmentWithdraw;
use App\Models\Shareholder;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Class ShareholderApiController
 *
 * Handles administrative REST APIs for shareholder profiles, investment summaries,
 * and chronological running-balance capital ledger statements.
 *
 * @package App\Http\Controllers\Api\V1
 */
class ShareholderApiController extends ApiController
{
    /**
     * List all shareholders with calculated capital investment and balance totals.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $query = Shareholder::query();

        if ($request->has('isActive') && $request->isActive !== null && $request->isActive !== '') {
            $query->where('isActive', (int) $request->isActive);
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', $search)
                  ->orWhere('designation', 'LIKE', $search)
                  ->orWhere('email', 'LIKE', $search)
                  ->orWhere('phone', 'LIKE', $search);
            });
        }

        $perPage = (int) $request->input('per_page', 15);
        $shareholders = $query->orderBy('id', 'asc')->paginate($perPage);

        // Attach financial metrics to each shareholder in the paginated set
        $shareholders->getCollection()->transform(function ($sh) {
            $financials = $this->computeShareholderFinancials($sh->id);
            $sh->total_investment = $financials['total_investment'];
            $sh->total_withdrawn = $financials['total_withdrawn'];
            $sh->outstanding_balance = $financials['outstanding_balance'];
            $sh->investment_count = $financials['investment_count'];
            return $sh;
        });

        return $this->success($shareholders, 'Shareholders retrieved successfully');
    }

    /**
     * Store a newly created shareholder in storage.
     *
     * @param StoreShareholderRequest $request
     * @return JsonResponse
     */
    public function store(StoreShareholderRequest $request): JsonResponse
    {
        $data = $request->validated();
        $shareholder = Shareholder::create($data);

        $financials = $this->computeShareholderFinancials($shareholder->id);
        $shareholder->total_investment = $financials['total_investment'];
        $shareholder->total_withdrawn = $financials['total_withdrawn'];
        $shareholder->outstanding_balance = $financials['outstanding_balance'];

        return $this->success($shareholder, 'Shareholder created successfully', 201);
    }

    /**
     * Display the specified shareholder profile and investment history.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $shareholder = Shareholder::find($id);

        if (!$shareholder) {
            return $this->error('Shareholder not found', 404);
        }

        $financials = $this->computeShareholderFinancials($shareholder->id);
        $shareholder->total_investment = $financials['total_investment'];
        $shareholder->total_withdrawn = $financials['total_withdrawn'];
        $shareholder->outstanding_balance = $financials['outstanding_balance'];
        $shareholder->investment_count = $financials['investment_count'];

        // Eager load active investment records
        $investments = Invesments::where('shareholder_id', $id)
            ->orderBy('recevedDate', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $shareholder->investments = $investments;

        return $this->success($shareholder, 'Shareholder details retrieved successfully');
    }

    /**
     * Update the specified shareholder in storage.
     *
     * @param UpdateShareholderRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateShareholderRequest $request, int $id): JsonResponse
    {
        $shareholder = Shareholder::find($id);

        if (!$shareholder) {
            return $this->error('Shareholder not found', 404);
        }

        $shareholder->update($request->validated());

        $financials = $this->computeShareholderFinancials($shareholder->id);
        $shareholder->total_investment = $financials['total_investment'];
        $shareholder->total_withdrawn = $financials['total_withdrawn'];
        $shareholder->outstanding_balance = $financials['outstanding_balance'];

        return $this->success($shareholder, 'Shareholder updated successfully');
    }

    /**
     * Remove the specified shareholder from storage if no dependent financial records exist.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $shareholder = Shareholder::find($id);

        if (!$shareholder) {
            return $this->error('Shareholder not found', 404);
        }

        // Safeguard 1: Dependent capital investments
        if (Invesments::where('shareholder_id', $id)->exists()) {
            return $this->error('Cannot delete shareholder: Active or historical capital investments are associated with this shareholder.', 422);
        }

        // Safeguard 2: Dependent bank loans
        if (class_exists(BankLoan::class) && Schema::hasTable('bank_loans') && BankLoan::where('shareholder_id', $id)->exists()) {
            return $this->error('Cannot delete shareholder: Bank loans are associated with this shareholder.', 422);
        }

        // Safeguard 3: Dependent capital withdrawals
        if (class_exists(InvestmentWithdraw::class) && Schema::hasTable('investment_withdraws') && InvestmentWithdraw::where('shareholder_id', $id)->exists()) {
            return $this->error('Cannot delete shareholder: Capital withdrawal records are associated with this shareholder.', 422);
        }

        // Safeguard 4: Dependent dividend withdrawals
        if (class_exists(DividendWithdraw::class) && Schema::hasTable('dividend_withdraws') && DividendWithdraw::where('shareholder_id', $id)->exists()) {
            return $this->error('Cannot delete shareholder: Dividend withdrawal records are associated with this shareholder.', 422);
        }

        $shareholder->delete();

        return $this->success(null, 'Shareholder deleted successfully');
    }

    /**
     * Generate chronological capital ledger statement with running balance.
     *
     * Preserves legacy InvesmentsController@statement business logic while adding
     * deterministic tie-breaker sorting and comma-sanitized monetary calculations.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function statement(Request $request, int $id): JsonResponse
    {
        $shareholder = Shareholder::find($id);

        if (!$shareholder) {
            return $this->error('Shareholder not found', 404);
        }

        // 1. Deposits: Active capital investments
        $deposits = Invesments::where('shareholder_id', $id)
            ->where('isActive', 1)
            ->get()
            ->map(function ($inv) {
                $clean = str_replace(',', '', (string) $inv->amount);
                $amtStr = is_numeric($clean) ? bcadd($clean, '0', 2) : '0.00';
                $formattedDate = $inv->recevedDate ? Carbon::parse($inv->recevedDate)->format('Y-m-d') : '';
                return [
                    'id'          => $inv->id,
                    'ref_type'    => 'investment',
                    'type'        => 'Deposit',
                    'date'        => $formattedDate,
                    'description' => 'Investment Deposit' . ($inv->paidremark ? ' - ' . $inv->paidremark : ''),
                    'receved_by'  => $inv->recevedBy ?? '',
                    'debit'       => (float) $amtStr,
                    'credit'      => 0.0,
                    '_debit_str'  => $amtStr,
                    '_credit_str' => '0.00',
                ];
            });

        // 2. Withdrawals: Approved capital withdrawals (canonical 'approved' or legacy '1')
        $withdrawals = collect();
        if (class_exists(InvestmentWithdraw::class) && Schema::hasTable('investment_withdraws')) {
            $withdrawals = InvestmentWithdraw::where('shareholder_id', $id)
                ->whereIn('status', ['approved', '1'])
                ->get()
                ->map(function ($w) {
                    $clean = str_replace(',', '', (string) $w->amount);
                    $amtStr = is_numeric($clean) ? bcadd($clean, '0', 2) : '0.00';
                    $dateStr = $w->withdraw_date ?? $w->requested_at;
                    $formattedDate = $dateStr ? Carbon::parse($dateStr)->format('Y-m-d') : '';
                    return [
                        'id'          => $w->id,
                        'ref_type'    => 'withdrawal',
                        'type'        => 'Withdrawal',
                        'date'        => $formattedDate,
                        'description' => 'Investment Withdrawal' . ($w->receiver_name ? ' - ' . $w->receiver_name : ''),
                        'receved_by'  => $w->receiver_name ?? '',
                        'debit'       => 0.0,
                        'credit'      => (float) $amtStr,
                        '_debit_str'  => '0.00',
                        '_credit_str' => $amtStr,
                    ];
                });
        }

        // 3. Deterministic chronological sort:
        //    Primary: Date ascending
        //    Secondary: Deposits before withdrawals
        //    Tertiary: ID ascending
        $transactions = $deposits->concat($withdrawals)->sort(function ($a, $b) {
            if ($a['date'] !== $b['date']) {
                return strcmp($a['date'], $b['date']);
            }
            if ($a['type'] !== $b['type']) {
                return $a['type'] === 'Deposit' ? -1 : 1;
            }
            return $a['id'] <=> $b['id'];
        })->values();

        // 4. Calculate running balances using decimal-safe BCMath
        $runningBalanceStr = '0.00';
        $totalInvestmentStr = '0.00';
        $totalWithdrawnStr = '0.00';

        $ledger = [];
        foreach ($transactions as $t) {
            $netChange = bcsub($t['_debit_str'], $t['_credit_str'], 2);
            $runningBalanceStr = bcadd($runningBalanceStr, $netChange, 2);
            $totalInvestmentStr = bcadd($totalInvestmentStr, $t['_debit_str'], 2);
            $totalWithdrawnStr = bcadd($totalWithdrawnStr, $t['_credit_str'], 2);

            $t['balance'] = (float) $runningBalanceStr;
            unset($t['_debit_str'], $t['_credit_str']);
            $ledger[] = $t;
        }

        return $this->success([
            'shareholder' => [
                'id'          => $shareholder->id,
                'name'        => $shareholder->name,
                'designation' => $shareholder->designation,
                'phone'       => $shareholder->phone,
                'email'       => $shareholder->email,
                'shareType'   => $shareholder->shareType,
                'isActive'    => $shareholder->isActive,
            ],
            'summary'     => [
                'total_investment'  => (float) $totalInvestmentStr,
                'total_withdrawn'   => (float) $totalWithdrawnStr,
                'current_balance'   => (float) $runningBalanceStr,
                'transaction_count' => count($ledger),
            ],
            'transactions' => $ledger,
        ], 'Shareholder investment statement generated successfully');
    }

    /**
     * Compute financial aggregates for a shareholder using decimal-safe BCMath.
     *
     * @param int $shareholderId
     * @return array
     */
    protected function computeShareholderFinancials(int $shareholderId): array
    {
        $investments = Invesments::where('shareholder_id', $shareholderId)
            ->where('isActive', 1)
            ->get();

        $totalInvestmentStr = '0.00';
        foreach ($investments as $inv) {
            $clean = str_replace(',', '', (string) $inv->amount);
            if (is_numeric($clean)) {
                $totalInvestmentStr = bcadd($totalInvestmentStr, $clean, 2);
            }
        }

        $totalWithdrawnStr = '0.00';
        if (class_exists(InvestmentWithdraw::class) && Schema::hasTable('investment_withdraws')) {
            $withdrawals = InvestmentWithdraw::where('shareholder_id', $shareholderId)
                ->whereIn('status', ['approved', '1'])
                ->get();

            foreach ($withdrawals as $w) {
                $clean = str_replace(',', '', (string) $w->amount);
                if (is_numeric($clean)) {
                    $totalWithdrawnStr = bcadd($totalWithdrawnStr, $clean, 2);
                }
            }
        }

        $outstandingBalanceStr = bcsub($totalInvestmentStr, $totalWithdrawnStr, 2);

        return [
            'total_investment'    => (float) $totalInvestmentStr,
            'total_withdrawn'     => (float) $totalWithdrawnStr,
            'outstanding_balance' => (float) $outstandingBalanceStr,
            'investment_count'    => $investments->count(),
        ];
    }
}
