<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankLoan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shareholder_id',
        'bank_name',
        'loan_amount',
        'interest_rate',
        'loan_term_months',
        'loan_date',
        'maturity_date',
        'installment_count',
        'savings_amount',
        'status',
        'remarks',
        'created_by'
    ];

    protected $dates = ['deleted_at', 'loan_date', 'maturity_date'];

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'created_by');
    }

    public function emiInstallments()
    {
        return $this->hasMany(EmiInstallment::class, 'bank_loan_id');
    }

    public function paidInstallments()
    {
        return $this->emiInstallments()->where('status', 'paid');
    }

    public function pendingInstallments()
    {
        return $this->emiInstallments()->where('status', 'pending');
    }

    public function totalEmiPaid()
    {
        return $this->paidInstallments()->sum('emi_amount');
    }

    public function totalSavings()
    {
        // Sum of savings from EMI payments
        $emiSavings = $this->paidInstallments()->sum('savings_amount');
        // Add initial loan savings amount
        $loanSavings = $this->savings_amount ?? 0;
        return $emiSavings + $loanSavings;
    }

    /**
     * Get monthly savings from EMI payments only
     */
    public function getMonthlyEmiSavings()
    {
        return $this->paidInstallments()->sum('savings_amount');
    }

    /**
     * Get loan's initial savings amount
     */
    public function getMonthlySavingsAmount()
    {
        return $this->savings_amount;
    }

    /**
     * Calculate total interest on the loan
     * Interest = (Loan Amount * Interest Rate * Loan Term in years) / 100
     */
    public function calculateTotalInterest()
    {
        $loanYears = $this->loan_term_months / 12;
        return ($this->loan_amount * $this->interest_rate * $loanYears) / 100;
    }

    /**
     * Calculate remaining EMI amount with interest
     * Remaining = Loan Amount + Total Interest - EMI Paid
     */
    public function remainingEmi()
    {
        $totalInterest = $this->calculateTotalInterest();
        $totalLoanWithInterest = $this->loan_amount + $totalInterest;
        return $totalLoanWithInterest - $this->totalEmiPaid();
    }
}
