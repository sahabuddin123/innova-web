<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Branch extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'branches';

    /**
     * @var array
     */
    protected $fillable = [
        'bname',
        'baddress',
        'startdate',
        'btype',
        'IsActive'
    ];

    /**
     * Incomes associated with this branch.
     */
    public function incomes()
    {
        return $this->hasMany(Income::class, 'branch_id');
    }

    /**
     * Expenses associated with this branch.
     */
    public function expenses()
    {
        return $this->hasMany(Expanse::class, 'branch_id');
    }

    /**
     * Income categories defined for this branch.
     */
    public function incomeCategories()
    {
        return $this->hasMany(IncomeCategoris::class, 'branch_id');
    }

    /**
     * Expense categories defined for this branch.
     */
    public function expenseCategories()
    {
        return $this->hasMany(ExpanseCategoris::class, 'branch_id');
    }
}
