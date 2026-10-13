<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    /**
     * @var string
     */
    protected $table = 'courses';

    /**
     * @var array
     */
    protected $fillable = [
        'category_id',
        'shortTitle', 
        'name', 
        'coursefee', 
        'courseduration',
        'lacture',
        'totalmoduls',
        'totalproject',
        'description', 
        'overview', 
        'curriculum', 
        'software', 
        'trainee', 
        'jobPlacement', 
        'jobPosition', 
        'IsActive',
        'featured',
        'IsCourse',
        'image',
        'video',
        'courseFor',
        'Instructor',
        'Rating',
        'TotalReview',
        'Discount',
        'views'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function StudentInfo()
    {
        return $this->hasMany(Students::class, 'course_id');
    }
    public function CourseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id', 'id');
    }

    // Alias for StudentInfo to allow $course->students() calls
    public function students()
    {
        return $this->StudentInfo();
    }

}
