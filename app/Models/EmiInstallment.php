<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmiInstallment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'bank_loan_id',
        'shareholder_id',
        'emi_amount',
        'savings_amount',
        'payment_date',
        'payment_method',
        'paid_by',
        'received_by',
        'paid_at',
        'status',
        'remarks'
    ];

    protected $dates = ['deleted_at', 'payment_date', 'paid_at'];

    public function bankLoan()
    {
        return $this->belongsTo(BankLoan::class, 'bank_loan_id');
    }

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');
    }

    public function paidByUser()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'paid_by');
    }

    public function receivedByUser()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'received_by');
    }
}
