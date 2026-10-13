<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class blogCategoris extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'blog_categoris';

    /**
     * @var array
     */
    protected $fillable = [
        'categoryName',
        'icon',
        'IsActive'
    ];
    public function BlogCategory()
    {
        return $this->belongsTo(blogCategoris::class, 'category_id', 'id');
    }
}
