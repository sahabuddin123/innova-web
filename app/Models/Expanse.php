<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Expanse extends Model
{
  use SoftDeletes;
  /**
   * @var string
   */
  protected $table = 'expanses';
  /**
   * @var array
   */
  protected $fillable = [
    'user_id',
    'branch_id',
    'categoris_id',
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
  public function expanseCategory()
  {
    return $this->belongsTo(ExpanseCategoris::class, 'categoris_id', 'id');
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

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
