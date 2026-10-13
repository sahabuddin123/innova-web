<?php

namespace App\Http\Controllers\Admin;

use App\Models\BankLoan;
use App\Models\EmiInstallment;
use App\Models\Shareholder;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Carbon\Carbon;

class BankLoanController extends BaseController
{
    public function index()
    {
        $loans = BankLoan::with('shareholder')->orderBy('id', 'desc')->get();
        $this->setPageTitle('Bank Loans', 'List of bank loans');
        return view('admin.bank_loan.index', compact('loans'));
    }

    public function create(Request $request)
    {
        $shareholders = Shareholder::orderBy('name')->get();
        $this->setPageTitle('Bank Loan', 'Create new loan');
        return view('admin.bank_loan.create', compact('shareholders'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'shareholder_id' => 'required',
            'bank_name' => 'required',
            'loan_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric',
            'loan_term_months' => 'required|integer',
            'loan_date' => 'required|date',
            'maturity_date' => 'required|date',
            'installment_count' => 'required|integer'
        ]);

        $data = $request->only([
            'shareholder_id', 'bank_name', 'loan_amount', 'interest_rate',
            'loan_term_months', 'loan_date', 'maturity_date', 'installment_count',
            'savings_amount', 'remarks'
        ]);
        $data['created_by'] = auth()->id() ?? null;
        $data['status'] = 'active';

        $loan = BankLoan::create($data);

        if (!$loan) {
            return $this->responseRedirectBack('Error occurred while creating loan.', 'error', true, true);
        }

        return $this->responseRedirect('admin.bank.loan.index', 'Bank loan created successfully', 'success', false, false);
    }

    public function show($id)
    {
        $loan = BankLoan::with('shareholder', 'emiInstallments')->findOrFail($id);
        $this->setPageTitle('Bank Loan', 'View loan details');
        return view('admin.bank_loan.show', compact('loan'));
    }

    public function edit($id)
    {
        $loan = BankLoan::findOrFail($id);
        $shareholders = Shareholder::orderBy('name')->get();
        $this->setPageTitle('Bank Loan', 'Edit loan');
        return view('admin.bank_loan.edit', compact('loan', 'shareholders'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'bank_name' => 'required',
            'loan_amount' => 'required|numeric',
            'interest_rate' => 'required|numeric'
        ]);

        $loan = BankLoan::findOrFail($id);
        $updateData = $request->only([
            'shareholder_id', 'bank_name', 'loan_amount', 'interest_rate', 'loan_term_months',
            'loan_date', 'maturity_date', 'installment_count', 'savings_amount',
            'status', 'remarks'
        ]);

        $loan->update($updateData);

        return $this->responseRedirect('admin.bank.loan.index', 'Bank loan updated successfully', 'success', false, false);
    }

    public function destroy($id)
    {
        $loan = BankLoan::findOrFail($id);
        $deleted = $loan->delete();

        if (!$deleted) {
            return $this->responseRedirectBack('Error occurred while deleting loan.', 'error', true, true);
        }
        return $this->responseRedirect('admin.bank.loan.index', 'Bank loan deleted successfully', 'success', false, false);
    }

    /**
     * Bank Loan Statement - shows EMI schedule and payment history
     */
    public function statement($id)
    {
        $loan = BankLoan::with(['shareholder', 'emiInstallments'])->findOrFail($id);
        $this->setPageTitle('Loan Statement', 'Bank Loan EMI Statement - ' . $loan->bank_name);

        // Calculate statistics
        $totalPaid = $loan->totalEmiPaid();
        $totalSavings = $loan->totalSavings();
        $remainingEmi = $loan->remainingEmi();
        $paidInstallments = $loan->paidInstallments()->count();
        $pendingInstallments = $loan->pendingInstallments()->count();
        $totalInterest = $loan->calculateTotalInterest();
        $monthlySavings = $loan->getMonthlySavingsAmount();
        $emiSavings = $loan->getMonthlyEmiSavings();

        return view('admin.bank_loan.statement', compact(
            'loan', 'totalPaid', 'totalSavings', 'remainingEmi',
            'paidInstallments', 'pendingInstallments', 'totalInterest', 'monthlySavings', 'emiSavings'
        ));
    }

    /**
     * EMI Statement - shows EMI payment details with interest calculations
     */
    public function emiStatement($id)
    {
        $loan = BankLoan::with(['shareholder', 'emiInstallments'])->findOrFail($id);
        $this->setPageTitle('EMI Statement', 'Bank Loan EMI Statement - ' . $loan->bank_name);

        // Calculate statistics
        $totalPaid = $loan->totalEmiPaid();
        $totalSavings = $loan->totalSavings();
        $remainingEmi = $loan->remainingEmi();
        $paidInstallments = $loan->paidInstallments()->count();
        $pendingInstallments = $loan->pendingInstallments()->count();
        $totalInterest = $loan->calculateTotalInterest();
        $monthlySavings = $loan->getMonthlySavingsAmount();
        $emiSavings = $loan->getMonthlyEmiSavings();

        return view('admin.bank_loan.emi_statement', compact(
            'loan', 'totalPaid', 'totalSavings', 'remainingEmi',
            'paidInstallments', 'pendingInstallments', 'totalInterest', 'monthlySavings', 'emiSavings'
        ));
    }

    /**
     * Savings Statement - shows savings collection details
     */
    public function savingsStatement($id)
    {
        $loan = BankLoan::with(['shareholder', 'emiInstallments'])->findOrFail($id);
        $this->setPageTitle('Savings Statement', 'Savings Collection Statement - ' . $loan->bank_name);

        // Calculate statistics
        $totalPaid = $loan->totalEmiPaid();
        $totalSavings = $loan->totalSavings();
        $remainingEmi = $loan->remainingEmi();
        $paidInstallments = $loan->paidInstallments()->count();
        $pendingInstallments = $loan->pendingInstallments()->count();
        $totalInterest = $loan->calculateTotalInterest();
        $monthlySavings = $loan->getMonthlySavingsAmount();
        $emiSavings = $loan->getMonthlyEmiSavings();

        return view('admin.bank_loan.savings_statement', compact(
            'loan', 'totalPaid', 'totalSavings', 'remainingEmi',
            'paidInstallments', 'pendingInstallments', 'totalInterest', 'monthlySavings', 'emiSavings'
        ));
    }
}
