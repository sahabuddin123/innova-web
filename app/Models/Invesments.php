<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Invesments extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'invesments';
    /**
     * @var array
     */
    protected $fillable = [
        'shareholder_id',  
        'amount', 
        'recevedBy', 
        'recevedDate', 
        'paidremark',
        'image',
        'isActive'
    ]; 

    /**
     * @var string
     */
    protected $dates = ['deleted_at'];
    /**
     * Get the comments for the blog post.
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ShareHolderInfo()
    {
        return $this->hasMany(Shareholder::class, 'id', 'shareholder_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shareholder()
    {
        return $this->belongsTo(Shareholder::class, 'shareholder_id');
    }
}
