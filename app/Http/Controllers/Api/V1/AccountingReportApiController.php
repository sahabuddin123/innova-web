<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Branch;
use App\Models\Expanse;
use App\Models\ExpanseCategoris;
use App\Models\FeesTransections;
use App\Models\Income;
use App\Models\IncomeCategoris;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class AccountingReportApiController
 *
 * REST API controller providing institutional accounting summaries,
 * daily cash reconciliation, and category-level reporting.
 *
 * @package App\Http\Controllers\Api\V1
 */
class AccountingReportApiController extends ApiController
{
    /**
     * Daily cash summary and reconciliation across income, fees, and expenses.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function dailySummary(Request $request): JsonResponse
    {
        $date = $request->input('date', date('Y-m-d'));
        $branchId = $request->filled('branch_id') ? (int) $request->branch_id : null;

        // 1. Incomes for the date
        $incomeQuery = Income::query()
            ->with(['inCategoris:id,categoris', 'branches:id,bname'])
            ->whereDate('invoiceDate', $date);

        if ($branchId) {
            $incomeQuery->where('branch_id', $branchId);
        }

        $incomeRecords = $incomeQuery->get();
        $totalIncome = 0.0;
        foreach ($incomeRecords as $item) {
            $amt = (float) str_replace(',', '', (string) $item->amount);
            $totalIncome += $amt;
        }

        // 2. Expenses for the date
        $expenseQuery = Expanse::query()
            ->with(['exCategoris:id,categoris', 'branches:id,bname'])
            ->whereDate('invoiceDate', $date);

        if ($branchId) {
            $expenseQuery->where('branch_id', $branchId);
        }

        $expenseRecords = $expenseQuery->get();
        $totalExpense = 0.0;
        foreach ($expenseRecords as $item) {
            $amt = (float) str_replace(',', '', (string) $item->amount);
            $totalExpense += $amt;
        }

        // 3. Student Fees collected on the date (status = 0 / approved)
        $feesQuery = FeesTransections::query()
            ->with(['student:id,sname,phone,branch_id', 'user:id,name'])
            ->whereDate('paiddate', $date)
            ->where('status', 0);

        if ($branchId) {
            $feesQuery->whereHas('student', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $feesRecords = $feesQuery->get();
        $totalFees = 0.0;
        foreach ($feesRecords as $item) {
            $amt = (float) str_replace(',', '', (string) $item->paidamount);
            $totalFees += $amt;
        }

        $totalRevenue = $totalIncome + $totalFees;
        $netCashFlow = $totalRevenue - $totalExpense;

        $branchName = 'All Branches';
        if ($branchId) {
            $branch = Branch::find($branchId);
            $branchName = $branch ? $branch->bname : 'Unknown';
        }

        return $this->success([
            'date'                 => $date,
            'branch_id'            => $branchId,
            'branch_name'          => $branchName,
            'summary'              => [
                'total_income'         => round($totalIncome, 2),
                'total_fees_collected' => round($totalFees, 2),
                'total_revenue'        => round($totalRevenue, 2),
                'total_expense'        => round($totalExpense, 2),
                'net_cash_flow'        => round($netCashFlow, 2),
            ],
            'income_items'         => $incomeRecords,
            'fee_items'            => $feesRecords,
            'expense_items'        => $expenseRecords,
        ], 'Daily cash summary generated successfully');
    }

    /**
     * Expense report grouped by category for a date range.
     * Preserves legacy ReportController@getReport calculation logic.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function expenseByCategory(Request $request): JsonResponse
    {
        [$startDate, $endDate] = $this->resolveDateRange($request);
        $branchId = $request->filled('branch_id') ? (int) $request->branch_id : null;

        $categories = ExpanseCategoris::query()
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        $expenses = Expanse::query()
            ->whereBetween('invoiceDate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        $categoryTotals = [];
        foreach ($categories as $cat) {
            $categoryTotals[$cat->id] = [
                'category_id'   => $cat->id,
                'category_name' => $cat->categoris,
                'total_amount'  => 0.0,
                'item_count'    => 0,
            ];
        }

        $overallTotal = 0.0;
        foreach ($expenses as $item) {
            $catId = $item->categoris_id;
            $amt = (float) str_replace(',', '', (string) $item->amount);
            $overallTotal += $amt;

            if (!isset($categoryTotals[$catId])) {
                $categoryTotals[$catId] = [
                    'category_id'   => $catId,
                    'category_name' => 'Uncategorized',
                    'total_amount'  => 0.0,
                    'item_count'    => 0,
                ];
            }

            $categoryTotals[$catId]['total_amount'] += $amt;
            $categoryTotals[$catId]['item_count'] += 1;
        }

        $branchName = 'All Branches';
        if ($branchId) {
            $branch = Branch::find($branchId);
            $branchName = $branch ? $branch->bname : 'Unknown';
        }

        return $this->success([
            'start_date'     => $startDate->format('Y-m-d'),
            'end_date'       => $endDate->format('Y-m-d'),
            'branch_id'      => $branchId,
            'branch_name'    => $branchName,
            'overall_total'  => round($overallTotal, 2),
            'categories'     => array_values($categoryTotals),
        ], 'Expense category report generated successfully');
    }

    /**
     * Income report grouped by category for a date range.
     * Preserves legacy ReportController@getIncomeReport calculation logic.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function incomeByCategory(Request $request): JsonResponse
    {
        [$startDate, $endDate] = $this->resolveDateRange($request);
        $branchId = $request->filled('branch_id') ? (int) $request->branch_id : null;

        $categories = IncomeCategoris::query()
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        $incomes = Income::query()
            ->whereBetween('invoiceDate', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        $categoryTotals = [];
        foreach ($categories as $cat) {
            $categoryTotals[$cat->id] = [
                'category_id'   => $cat->id,
                'category_name' => $cat->categoris,
                'total_amount'  => 0.0,
                'item_count'    => 0,
            ];
        }

        $overallTotal = 0.0;
        foreach ($incomes as $item) {
            $catId = $item->categoris_id;
            $amt = (float) str_replace(',', '', (string) $item->amount);
            $overallTotal += $amt;

            if (!isset($categoryTotals[$catId])) {
                $categoryTotals[$catId] = [
                    'category_id'   => $catId,
                    'category_name' => 'Uncategorized',
                    'total_amount'  => 0.0,
                    'item_count'    => 0,
                ];
            }

            $categoryTotals[$catId]['total_amount'] += $amt;
            $categoryTotals[$catId]['item_count'] += 1;
        }

        $branchName = 'All Branches';
        if ($branchId) {
            $branch = Branch::find($branchId);
            $branchName = $branch ? $branch->bname : 'Unknown';
        }

        return $this->success([
            'start_date'     => $startDate->format('Y-m-d'),
            'end_date'       => $endDate->format('Y-m-d'),
            'branch_id'      => $branchId,
            'branch_name'    => $branchName,
            'overall_total'  => round($overallTotal, 2),
            'categories'     => array_values($categoryTotals),
        ], 'Income category report generated successfully');
    }

    /**
     * Monthly comparison and cumulative reconciliation summary.
     * Preserves legacy ReportController@generateReportMonthly logic.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function monthlySummary(Request $request): JsonResponse
    {
        $year = (int) $request->input('year', date('Y'));
        $month = (int) $request->input('month', date('m'));
        $branchId = $request->filled('branch_id') ? (int) $request->branch_id : null;

        $previousMonth = $month === 1 ? 12 : $month - 1;
        $previousYear = $month === 1 ? $year - 1 : $year;

        // Current month & previous month expenses
        $expenses = Expanse::query()
            ->whereYear('invoiceDate', $year)
            ->whereMonth('invoiceDate', $month)
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        $previousExpenses = Expanse::query()
            ->whereYear('invoiceDate', $previousYear)
            ->whereMonth('invoiceDate', $previousMonth)
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        // Current month & previous month incomes
        $incomes = Income::query()
            ->whereYear('invoiceDate', $year)
            ->whereMonth('invoiceDate', $month)
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        $previousIncomes = Income::query()
            ->whereYear('invoiceDate', $previousYear)
            ->whereMonth('invoiceDate', $previousMonth)
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        // Calculate sums
        $currentMonthExpenseTotal = 0.0;
        foreach ($expenses as $e) {
            $currentMonthExpenseTotal += (float) str_replace(',', '', (string) $e->amount);
        }

        $previousMonthExpenseTotal = 0.0;
        foreach ($previousExpenses as $pe) {
            $previousMonthExpenseTotal += (float) str_replace(',', '', (string) $pe->amount);
        }

        $currentMonthIncomeTotal = 0.0;
        foreach ($incomes as $i) {
            $currentMonthIncomeTotal += (float) str_replace(',', '', (string) $i->amount);
        }

        $previousMonthIncomeTotal = 0.0;
        foreach ($previousIncomes as $pi) {
            $previousMonthIncomeTotal += (float) str_replace(',', '', (string) $pi->amount);
        }

        // Cumulative totals (from startYear = 2020 to selected year/month, preserving legacy algorithm)
        $cumulativeIncomeTotal = 0.0;
        $cumulativeExpenseTotal = 0.0;

        $allPastIncomes = Income::query()
            ->whereDate('invoiceDate', '<=', Carbon::create($year, $month)->endOfMonth()->format('Y-m-d'))
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        foreach ($allPastIncomes as $ai) {
            $cumulativeIncomeTotal += (float) str_replace(',', '', (string) $ai->amount);
        }

        $allPastExpenses = Expanse::query()
            ->whereDate('invoiceDate', '<=', Carbon::create($year, $month)->endOfMonth()->format('Y-m-d'))
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->get();

        foreach ($allPastExpenses as $ae) {
            $cumulativeExpenseTotal += (float) str_replace(',', '', (string) $ae->amount);
        }

        $branchName = 'All Branches';
        if ($branchId) {
            $branch = Branch::find($branchId);
            $branchName = $branch ? $branch->bname : 'Unknown';
        }

        return $this->success([
            'year'                         => $year,
            'month'                        => $month,
            'branch_id'                    => $branchId,
            'branch_name'                  => $branchName,
            'current_month'                => [
                'income'  => round($currentMonthIncomeTotal, 2),
                'expense' => round($currentMonthExpenseTotal, 2),
                'net'     => round($currentMonthIncomeTotal - $currentMonthExpenseTotal, 2),
            ],
            'previous_month'               => [
                'year'    => $previousYear,
                'month'   => $previousMonth,
                'income'  => round($previousMonthIncomeTotal, 2),
                'expense' => round($previousMonthExpenseTotal, 2),
                'net'     => round($previousMonthIncomeTotal - $previousMonthExpenseTotal, 2),
            ],
            'cumulative_totals'            => [
                'total_incomes'  => round($cumulativeIncomeTotal, 2),
                'total_expenses' => round($cumulativeExpenseTotal, 2),
                'net_balance'    => round($cumulativeIncomeTotal - $cumulativeExpenseTotal, 2),
            ],
        ], 'Monthly accounting summary generated successfully');
    }

    /**
     * Line-item breakdown details for a specific income or expense category.
     * Preserves legacy ReportController@getCategoryDetails and getIncomeCategoryDetails.
     *
     * @param Request $request
     * @param string $type 'income' or 'expense'
     * @param int $categoryId
     * @return JsonResponse
     */
    public function categoryDetails(Request $request, string $type, int $categoryId): JsonResponse
    {
        $year = (int) $request->input('year', date('Y'));
        $month = (int) $request->input('month', date('m'));
        $branchId = $request->filled('branch_id') ? (int) $request->branch_id : null;

        if ($type === 'expense') {
            if ($request->user() && !$request->user()->can('expanse-list')) {
                return $this->error('Forbidden: Insufficient permissions to view expense category details', 403);
            }

            $category = ExpanseCategoris::find($categoryId);
            if (!$category) {
                return $this->error('Expense category not found', 404);
            }

            $items = Expanse::query()
                ->where('categoris_id', $categoryId)
                ->whereYear('invoiceDate', $year)
                ->whereMonth('invoiceDate', $month)
                ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->orderBy('invoiceDate', 'asc')
                ->get();
        } elseif ($type === 'income') {
            $category = IncomeCategoris::find($categoryId);
            if (!$category) {
                return $this->error('Income category not found', 404);
            }

            $items = Income::query()
                ->where('categoris_id', $categoryId)
                ->whereYear('invoiceDate', $year)
                ->whereMonth('invoiceDate', $month)
                ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
                ->orderBy('invoiceDate', 'asc')
                ->get();
        } else {
            return $this->error('Invalid category type. Must be "income" or "expense"', 400);
        }

        $total = 0.0;
        $processedItems = [];
        foreach ($items as $item) {
            $amt = (float) str_replace(',', '', (string) $item->amount);
            $total += $amt;
            $processedItems[] = [
                'id'          => $item->id,
                'invoiceDate' => $item->invoiceDate,
                'invoiceID'   => $item->invoiceID,
                'title'       => $item->title,
                'seller'      => $item->seller,
                'recever'     => $item->recever,
                'description' => $item->description,
                'amount'      => round($amt, 2),
            ];
        }

        return $this->success([
            'type'          => $type,
            'category_id'   => $categoryId,
            'category_name' => $category->categoris,
            'year'          => $year,
            'month'         => $month,
            'branch_id'     => $branchId,
            'total_amount'  => round($total, 2),
            'item_count'    => count($processedItems),
            'items'         => $processedItems,
        ], 'Category details retrieved successfully');
    }

    /**
     * Helper to resolve start and end dates from multiple formats.
     * Supports ?start_date=Y-m-d&end_date=Y-m-d or legacy ?date=m/d/Y - m/d/Y.
     *
     * @param Request $request
     * @return array [Carbon $startDate, Carbon $endDate]
     */
    protected function resolveDateRange(Request $request): array
    {
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            return [$startDate, $endDate];
        }

        if ($request->filled('date') && str_contains($request->date, ' - ')) {
            [$startStr, $endStr] = explode(' - ', $request->date);
            try {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($startStr))->startOfDay();
                $endDate = Carbon::createFromFormat('m/d/Y', trim($endStr))->endOfDay();
                return [$startDate, $endDate];
            } catch (\Exception $e) {
                // Fallback to general parsing
                $startDate = Carbon::parse(trim($startStr))->startOfDay();
                $endDate = Carbon::parse(trim($endStr))->endOfDay();
                return [$startDate, $endDate];
            }
        }

        // Default: current month
        return [
            Carbon::now()->startOfMonth()->startOfDay(),
            Carbon::now()->endOfMonth()->endOfDay(),
        ];
    }
}
