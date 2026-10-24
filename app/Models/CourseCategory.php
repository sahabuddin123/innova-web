<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseCategory extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'course_categories';

    /**
     * @var array
     */
    protected $fillable = [
        'CourseCategoris',
        'icon',
        'fontawesome',
        'isFeature',
        'IsActive'
    ];
    public function CourseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Courses::class, 'category_id', 'id');
    }
}
