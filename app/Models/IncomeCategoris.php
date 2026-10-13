<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeCategoris extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'income_categoris';

    /**
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'categoris',
        'IsActive'
    ];
    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategoris::class, 'categoris', 'id');
    }
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function getCategoryAttribute()
    {
        return $this->attributes['categoris']; // Access the actual column value
    }

    public function inCategoris()
    {
        return $this->belongsTo(IncomeCategoris::class, 'categoris_id', 'id'); // Replace 'categoris_id' with the actual foreign key column in your Expense table
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
