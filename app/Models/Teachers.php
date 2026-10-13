<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Teachers extends Model
{
    /**
     * @var string
     */
    protected $table = 'teachers';

    /**
     * @var array
     */
    protected $fillable = [ 
        'stuffid', 
        'name', 
        'fname', 
        'mname',
        'gender',
        'dob',
        'bloodgroup', 
        'religion',
        'maritalStatus',
        'phone',
        'email',
        'nid',
        'education',
        'subject',
        'designation',
        'department',
        'salary',
        'contactType',
        'shift',
        'exprience',
        'joiningdate',
        'link1',
        'link2',
        'link3',
        'link4',
        'address',
        'image',
        'ComCourse',
        'nStd',
        'rating',
        'review',
        'isTeacher',
        'IsFeatured',
        'IsActive',
        'bio'

    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function StudentsCourses()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function StudentsBatchs()
    {
        return $this->belongsTo(Batchs::class, 'batch_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function FeesTransaction()
    {
        return $this->belongsTo(FeesTransections::class, 'student_id');
    }
    
    /**
     * Get the user that owns the Students
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    // 
}
