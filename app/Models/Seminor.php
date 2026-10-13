<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Seminor extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'seminors';

    /**
     * @var array
     */
    protected $fillable = [
        'course_id',
        'title',
        'address',
        'time',
        'date',
        'type',
        'IsActive',
        'image'
    ];
    public function Courses()
    {
        return $this->belongsTo(Courses::class, 'category_id', 'id');
    }
    public function Seminors()
    {
        return $this->hasMany(Seminor::class, 'seminor_id', 'id');
    }
}
