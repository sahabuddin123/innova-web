<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    /**
     * @var string
     */
    protected $table = 'admissions';

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'phone',
        'email',
        'courseId',
        'courseType',
        'isActive'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function CourseInfo()
    {
        return $this->hasMany(Courses::class, 'id','courseId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Courses::class, 'courseId', 'id');
    }
}
