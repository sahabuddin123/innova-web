<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'incomes';
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'branch_id',
        'categoris_id',
        'bookNO',
        'invoiceID',
        'invoiceDate',
        'title',
        'seller',
        'recever',
        'description',
        'amount',
        'createDate',
        'IsActive',
        'image',
        'deleted_at'
    ];

    /**
     * @var string
     */
    // protected $dates = ['deleted_at'];
    /**
     * Get the comments for the blog post.
     */
    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategoris::class, 'categoris_id', 'id');
    }

    public function inCategoris()
    {
        return $this->belongsTo(IncomeCategoris::class, 'categoris_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
