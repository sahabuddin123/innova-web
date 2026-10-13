<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
   /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'phone',
        'email',
        'courseId',
        'msg',
        'isActive'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function CourseInfo()
    {
        return $this->hasMany(Courses::class, 'courseId');
    }
}
