<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpanseCategoris extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'expanse_categoris';

    /**
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'categoris',
        'IsActive'
    ];
    public function expanseCategory()
    {
        return $this->belongsTo(ExpanseCategoris::class, 'categoris', 'id');
    }
    public function expenses()
    {
        return $this->hasMany(Expanse::class);
    }

    public function getCategoryAttribute()
    {
        return $this->attributes['categoris']; // Access the actual column value
    }

    public function exCategoris()
    {
        return $this->belongsTo(ExpanseCategoris::class, 'categoris_id', 'id'); // Replace 'categoris_id' with the actual foreign key column in your Expense table
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function branches()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
}
