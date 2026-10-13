<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DividendWithdraw extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'shareholder_id', 'amount', 'withdraw_date', 'method', 'receiver_name', 'branch_name', 'account_number', 'status',
        'requested_by', 'requested_at', 'processed_by', 'processed_at', 'remarks', 'attachment', 'pay_by', 'processed_remarks'
    ];

    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');
    }

    public function requester()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'requested_by');
    }

    public function processor()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'processed_by');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
