<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Blog extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'blogs';

    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'heading',
        'summary',
        'details',
        'writerName',
        'postDate',
        'IsActive',
        'featured',
        'image',
        'views'
    ];
    // public function BlogCategory()
    // {
    //     return $this->belongsTo(blogCategoris::class, 'category_id', 'id');
    // }

    public function BlogCategory()
{
    return $this->belongsTo(blogCategoris::class, 'category_id', 'id');
}

}
