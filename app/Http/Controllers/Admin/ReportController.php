<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expanse;
use Carbon\Carbon;
use App\Models\ExpanseCategoris;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Income;
use App\Models\IncomeCategoris;
use Illuminate\Http\UploadedFile;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Support\Facades\DB;

class ReportController extends BaseController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expindex()
    {
        $data = Expanse::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $categoris = ExpanseCategoris::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $branch = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Report', 'Expance Report');
        return view('admin.report.expindex', compact('data', 'categoris', 'branch'));
    }
 public function getReport(Request $request)
{
    try {
        [$startDateString, $endDateString] = explode(' - ', $request->date);
        $startDate = Carbon::createFromFormat('m/d/Y', $startDateString)->startOfDay();
        $endDate = Carbon::createFromFormat('m/d/Y', $endDateString)->endOfDay();

        $branch_id = $request->branch_id;

        $query = Expanse::select(
                'expanses.id',
                'expanses.title',
                DB::raw('REPLACE(expanses.amount, ",", "") AS amount_without_commas'),
                'ec.categoris as category_name',
                DB::raw('SUM(REPLACE(expanses.amount, ",", "")) as total_amount')
            )
            ->from('expanses AS expanses')
            ->join('expanse_categoris AS ec', 'expanses.categoris_id', '=', 'ec.id')
            ->whereBetween('expanses.invoiceDate', [$startDate, $endDate])
            ->whereNull('expanses.deleted_at');

        $branch_name = 'All Branches';

        if (!empty($branch_id)) {
            $query->where('expanses.branch_id', $branch_id);
            $branch = Branch::find($branch_id);
            $branch_name = $branch ? $branch->bname : 'Unknown';
        }

        $result = $query->groupBy('ec.categoris')->get();

        return view('admin.report.expectg', [
            'result' => $result,
            'branch_name' => $branch_name,
            'start_date' => $startDate->format('F j, Y'),
            'end_date' => $endDate->format('F j, Y'),
        ]);

    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}
 public function incindex()
{
    $data = Income::where('deleted_at', null)->orderBy('id', 'asc')->get();
    $categoris = IncomeCategoris::where('deleted_at', null)->orderBy('id', 'asc')->get();
    $branch = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
    $this->setPageTitle('Report', 'Income Report');
    return view('admin.report.incindex', compact('data', 'categoris', 'branch'));
}

public function getIncomeReport(Request $request)
{
    try {
        [$startDateString, $endDateString] = explode(' - ', $request->date);
        $startDate = Carbon::createFromFormat('m/d/Y', $startDateString)->startOfDay();
        $endDate = Carbon::createFromFormat('m/d/Y', $endDateString)->endOfDay();

        $branch_id = $request->branch_id;

        $query = Income::select(
                'incomes.id',
                'incomes.title',
                DB::raw('REPLACE(incomes.amount, ",", "") AS amount_without_commas'),
                'ic.categoris as category_name',
                DB::raw('SUM(REPLACE(incomes.amount, ",", "")) as total_amount')
            )
            ->from('incomes AS incomes')
            ->join('income_categoris AS ic', 'incomes.categoris_id', '=', 'ic.id')
            ->whereBetween('incomes.invoiceDate', [$startDate, $endDate])
            ->whereNull('incomes.deleted_at');

        $branch_name = 'All Branches';

        if (!empty($branch_id)) {
            $query->where('incomes.branch_id', $branch_id);
            $branch = Branch::find($branch_id);
            $branch_name = $branch ? $branch->bname : 'Unknown';
        }

        $result = $query->groupBy('ic.categoris')->get();

        return view('admin.report.incomectg', [
            'result' => $result,
            'branch_name' => $branch_name,
            'start_date' => $startDate->format('F j, Y'),
            'end_date' => $endDate->format('F j, Y'),
        ]);

    } catch (\Exception $e) {
        return $e->getMessage();
    }
}
  
  
public function generateReportMonthly(Request $request)
{
    [$year, $month] = explode('-', $request->month);
    $branch_id = $request->branch_id;

    // get current month expance
    $expenses = Expanse::whereYear('invoiceDate', $year)
        ->whereMonth('invoiceDate', $month)->where('branch_id', $branch_id)
        ->get();

    // get previous month expance
    $previousMonth = $month - 1;
    $previousMonthExpance = Expanse::whereYear('invoiceDate', $year)
        ->whereMonth('invoiceDate', $previousMonth)->where('branch_id', $branch_id)
        ->get();

    // get Current month incomes
    $incomes = Income::whereYear('invoiceDate', $year)
        ->whereMonth('invoiceDate', $month)->where('branch_id', $branch_id)
        ->get();

    // get previous month incomes
    $previousMonthIncomes = Income::whereYear('invoiceDate', $year)
        ->whereMonth('invoiceDate', $previousMonth)->where('branch_id', $branch_id)
        ->get();

    // expance categories
    $categories = ExpanseCategoris::where('branch_id', $branch_id)->where('deleted_at', null)->orderBy('id', 'asc')->get();
    // income categories
    $incCategoris = IncomeCategoris::where('branch_id', $branch_id)->where('deleted_at', null)->orderBy('id', 'asc')->get();
    // branch
    $branch = Branch::where('id', $branch_id)->where('deleted_at', null)->first();

    // current Month income report
    $incomeData = [];
    // Current Month Income Loops
    foreach ($incCategoris as $category) {
        $incomeData[$category->id]['category_name'] = $category->categoris ?? 'Unknown';
        $incomeData[$category->id]['total_expense'] = 0;
    }
    foreach ($incomes as $expense) {
        if (isset($expense->categoris_id)) { // Check if 'categoris_id' exists
            $amountWithoutCommas = str_replace(',', '', $expense->amount);
            if (!isset($incomeData[$expense->categoris_id]['total_expense'])) {
                $incomeData[$expense->categoris_id]['total_expense'] = 0;
            }
            $incomeData[$expense->categoris_id]['total_expense'] += $amountWithoutCommas;
        }
    }

    // Previous Month income report
    $previousIncomeData = [];
    // Previous Month income Loops
    foreach ($incCategoris as $precategory) {
        $previousIncomeData[$precategory->id]['category_name'] = $precategory->categoris ?? 'Unknown';
        $previousIncomeData[$precategory->id]['total_expense'] = 0;
    }
    foreach ($previousMonthIncomes as $preincome) {
        if (isset($preincome->categoris_id)) { // Check if 'categoris_id' exists
            $amountWithoutCommas = str_replace(',', '', $preincome->amount);
            if (!isset($previousIncomeData[$preincome->categoris_id]['total_expense'])) {
                $previousIncomeData[$preincome->categoris_id]['total_expense'] = 0;
            }
            $previousIncomeData[$preincome->categoris_id]['total_expense'] += $amountWithoutCommas;
        }
    }

    // current Month expance report
    $reportData = [];
    // Current month Expance Loop
    foreach ($categories as $category) {
        $reportData[$category->id]['category_name'] = $category->categoris ?? 'Unknown';
        $reportData[$category->id]['total_expense'] = 0;
    }
    foreach ($expenses as $expense) {
        if (isset($expense->categoris_id)) { // Check if 'categoris_id' exists
            $amountWithoutCommas = str_replace(',', '', $expense->amount);
            if (!isset($reportData[$expense->categoris_id]['total_expense'])) {
                $reportData[$expense->categoris_id]['total_expense'] = 0;
            }
            $reportData[$expense->categoris_id]['total_expense'] += $amountWithoutCommas;
        }
    }

    // Previous Month expance report
    $previousExpanceData = [];
    // Previous Month Expance Loop
    foreach ($categories as $Expcategory) {
        $previousExpanceData[$Expcategory->id]['category_name'] = $Expcategory->categoris ?? 'Unknown';
        $previousExpanceData[$Expcategory->id]['total_expense'] = 0;
    }
    foreach ($previousMonthExpance as $preexpense) {
        if (isset($preexpense->categoris_id)) { // Check if 'categoris_id' exists
            $amountWithoutCommas = str_replace(',', '', $preexpense->amount);
            if (!isset($previousExpanceData[$preexpense->categoris_id]['total_expense'])) {
                $previousExpanceData[$preexpense->categoris_id]['total_expense'] = 0;
            }
            $previousExpanceData[$preexpense->categoris_id]['total_expense'] += $amountWithoutCommas;
        }
    }

    // Set Branch Start year and month 
    $startYear = 2020;
    $startMonth = 1;

    // Set Total Income and Expance Variable
    $totalIncomes = 0;
    $totalExpenses = 0;

    // Loop for all Year and Months
    for ($currentYear = $startYear; $currentYear <= $year; $currentYear++) {
        $endMonth = ($currentYear == $year) ? $month - 1 : 12;
        for ($currentMonth = $startMonth; $currentMonth <= $endMonth; $currentMonth++) {
            // Calculation Code for income and expance
            $incomes = Income::whereYear('invoiceDate', $currentYear)
                ->whereMonth('invoiceDate', $currentMonth)
                ->where('branch_id', $branch_id)
                ->get();

            $expenses = Expanse::whereYear('invoiceDate', $currentYear)
                ->whereMonth('invoiceDate', $currentMonth)
                ->where('branch_id', $branch_id)
                ->get();

            // Summation for income and expance
            foreach ($incomes as $income) {
                $totalIncomes += $income->amount;
            }
            foreach ($expenses as $expense) {
                $totalExpenses += $expense->amount;
            }
        }
        $startMonth = 1;
    }

    return view('admin.report.monthlyExpance', compact('reportData', 'incomeData', 'previousIncomeData', 'previousExpanceData', 'totalIncomes', 'totalExpenses', 'year', 'month', 'branch'));
}

/**
 * Get expense details for a specific category by date
 */
public function getCategoryDetails(Request $request, $categoryId, $branchId = null)
{
    $monthInput = $request->get('month', date('Y-m'));
    $yearInput = $request->get('year', date('Y'));
    
    // Extract month and year from format like "2025-01" or just "01"
    if (strpos($monthInput, '-') !== false) {
        $parts = explode('-', $monthInput);
        if (count($parts) == 2) {
            $yearInput = $parts[0];
            $monthInput = $parts[1];
        }
    }
    
    $month = intval($monthInput);
    $year = intval($yearInput);
    
    // Get expenses for the specific category in the given month
    $expenses = Expanse::where('categoris_id', $categoryId)
        ->whereMonth('invoiceDate', $month)
        ->whereYear('invoiceDate', $year)
        ->where('deleted_at', null)
        ->orderBy('invoiceDate', 'asc')
        ->get();
    
    // Get category name
    $category = ExpanseCategoris::find($categoryId);
    
    // Resolve branch id: prefer path param, fallback to request query 'branch_id'
    $branch = null;
    $resolvedBranchId = $branchId ?? $request->get('branch_id') ?? $request->get('branch');
    if ($resolvedBranchId) {
        $branch = \App\Models\Branch::find($resolvedBranchId);
    }
    
    // Calculate total and process expenses
    $totalExpense = 0;
    $processedExpenses = [];
    
    foreach ($expenses as $expense) {
        $amountWithoutCommas = str_replace(',', '', $expense->amount);
        $totalExpense += $amountWithoutCommas;
        
        // Process each expense with formatted date and amount
        $date = new \DateTime($expense->invoiceDate);
        $expenseData = [
            'id' => $expense->id,
            'invoiceDate' => $expense->invoiceDate,
            'day' => $date->format('d'),
            'month' => $date->format('m'),
            'description' => $expense->description ?? $expense->title ?? '-',
            'amount' => (float)$amountWithoutCommas,
            'amountFormatted' => number_format((float)$amountWithoutCommas, 2)
        ];
        $processedExpenses[] = $expenseData;
    }
    
    $totalFormatted = number_format($totalExpense, 2);
    
    // Month names in Bangla
    $banglaMonths = [
        1 => 'জানুয়ারী', 2 => 'ফেব্রুয়ারী', 3 => 'মার্চ', 4 => 'এপ্রিল',
        5 => 'মে', 6 => 'জুন', 7 => 'জুলাই', 8 => 'আগস্ট',
        9 => 'সেপ্টেম্বর', 10 => 'অক্টোবর', 11 => 'নভেম্বর', 12 => 'ডিসেম্বর'
    ];
    
    $monthName = $banglaMonths[$month] ?? 'Unknown';
    // If a serial value is passed from the listing page (as query param), use it
    $serialFromRequest = $request->get('serial');
    $serialNo = $serialFromRequest ? (string) intval($serialFromRequest) : (string)$categoryId; // prefer serial from listing, fallback to category ID
    // Use Branch model fields `bname` and `baddress`
    $branchName = $branch ? $branch->bname : ''; // Default branch name
    $branchAddress = $branch ? $branch->baddress : '';
    
    $this->setPageTitle('Expense Details', $category ? $category->categoris : 'Unknown Category');

    // Prepare total in words (Bangla) with poisha
    $numberToBangla = new \lemonpatwari\BanglaNumber\NumberToBangla();
    $amountFloat = floatval($totalExpense);
    $taka = floor($amountFloat);
    $poisha = round(($amountFloat - $taka) * 100);
    $takaText = $numberToBangla->bnWord($taka);
    $poishaText = $poisha > 0 ? $numberToBangla->bnNum($poisha) . ' পয়সা' : 'শূন্য পয়সা';
    $totalInWords = $takaText . ' টাকা ' . $poishaText . ' মাত্র';

    return view('admin.report.categoryDetails', compact('processedExpenses', 'category', 'totalExpense', 'totalFormatted', 'month', 'year', 'monthName', 'serialNo', 'branchName', 'branchAddress', 'totalInWords'));
}

public function getIncomeCategoryDetails(Request $request, $categoryId, $branchId = null)
{
    $monthInput = $request->get('month', date('Y-m'));
    $yearInput = $request->get('year', date('Y'));

    // Extract month and year from format like "2025-01" or just "01"
    if (strpos($monthInput, '-') !== false) {
        $parts = explode('-', $monthInput);
        if (count($parts) == 2) {
            $yearInput = $parts[0];
            $monthInput = $parts[1];
        }
    }

    $month = intval($monthInput);
    $year = intval($yearInput);

    // Get incomes for the specific category in the given month, filter by branch if provided
    $query = Income::where('categoris_id', $categoryId)
        ->whereMonth('invoiceDate', $month)
        ->whereYear('invoiceDate', $year)
        ->where('deleted_at', null)
        ->orderBy('invoiceDate', 'asc');

    if ($branchId) {
        $query->where('branch_id', $branchId);
    }

    $incomes = $query->get();

    // Get category name
    $category = IncomeCategoris::find($categoryId);

    // Resolve branch id: prefer path param, fallback to request query 'branch_id'
    $branch = null;
    $resolvedBranchId = $branchId ?? $request->get('branch_id') ?? $request->get('branch');
    if ($resolvedBranchId) {
        $branch = \App\Models\Branch::find($resolvedBranchId);
    }
    // Calculate total and process incomes
    $totalIncome = 0;
    $processedIncomes = [];

    foreach ($incomes as $income) {
        $amountWithoutCommas = str_replace(',', '', $income->amount);
        $totalIncome += $amountWithoutCommas;

        // Process each income with formatted date and amount
        $date = new \DateTime($income->invoiceDate);
        $incomeData = [
            'id' => $income->id,
            'invoiceDate' => $income->invoiceDate,
            'day' => $date->format('d'),
            'month' => $date->format('m'),
            'description' => $income->description ?? $income->title ?? '-',
            'amount' => (float)$amountWithoutCommas,
            'amountFormatted' => number_format((float)$amountWithoutCommas, 2)
        ];
        $processedIncomes[] = $incomeData;
    }

    $totalFormatted = number_format($totalIncome, 2);

    // Month names in Bangla (kept same as expense view)
    $banglaMonths = [
        1 => 'জানুয়ারী', 2 => 'ফেব্রুয়ারী', 3 => 'মার্চ', 4 => 'এপ্রিল',
        5 => 'মে', 6 => 'জুন', 7 => 'জুলাই', 8 => 'আগস্ট',
        9 => 'সেপ্টেম্বর', 10 => 'অক্টোবর', 11 => 'নভেম্বর', 12 => 'ডিসেম্বর'
    ];

    $monthName = $banglaMonths[$month] ?? 'Unknown';

    // Serial from request preferred
    $serialFromRequest = $request->get('serial');
    $serialNo = $serialFromRequest ? (string) intval($serialFromRequest) : (string)$categoryId;
    
    // Branch fields
    $branchName = $branch ? $branch->bname : '';
    $branchAddress = $branch ? $branch->baddress : '';

    $this->setPageTitle('Income Details', $category ? $category->categoris : 'Unknown Category');

    // Prepare total in words (Bangla) with poisha
    $numberToBangla = new \lemonpatwari\BanglaNumber\NumberToBangla();
    $amountFloat = floatval($totalIncome);
    $taka = floor($amountFloat);
    $poisha = round(($amountFloat - $taka) * 100);
    $takaText = $numberToBangla->bnWord($taka);
    $poishaText = $poisha > 0 ? $numberToBangla->bnNum($poisha) . ' পয়সা' : 'শূন্য পয়সা';
    $totalInWords = $takaText . ' টাকা ' . $poishaText . ' মাত্র';

    return view('admin.report.incomeCategoryDetails', compact('processedIncomes', 'category', 'totalIncome', 'totalFormatted', 'month', 'year', 'monthName', 'serialNo', 'branchName', 'branchAddress', 'totalInWords'));
}

}
