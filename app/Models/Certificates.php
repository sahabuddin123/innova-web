<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    /**
     * @var string
     */
    protected $table = 'certificates';

    /**
     * @var array
     */
    protected $fillable = [
        'student_id',
        'session_id',
        'regNo',
        'cno',
        'pDate',
        'recevier',
        'cimage',
        'dimage',
        'Result',
        'dDate',
        'IsActive',
    ];
    /**
     * Get all of the comments for the Students
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function StudentsInfo(): HasMany
    // {
    //     return $this->hasMany(Students::class, 'id', 'student_id');
    // }


    /**
     * Get the comments for the blog post.
     */
    public function StudentsInfo()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function StudentsSessions()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function FeesTransaction()
    {
        return $this->belongsTo(FeesTransections::class, 'student_id');
    }
}
