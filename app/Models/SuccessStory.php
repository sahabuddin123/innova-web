<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SuccessStory extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'success_stories';

    /**
     * @var array
     */
    protected $fillable = [
        'student_id','msg','video','IsActive','image'
    ];
    /**
     * @var string
     */
    protected $dates = ['deleted_at'];

     /**
     * Get the comments for the blog post.
     */
    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id','id');
    }
} 
