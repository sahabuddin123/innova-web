<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SeminorRegistration extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'seminor_registrations';

    /**
     * @var array
     */
    protected $fillable = [
        'seminor_id',
        'username',
        'phone',
        'email',
        'profession',
        'address',
        'isCall',
        'isAttand',
        'isConvance',
        'IsActive',
    ];
    public function Courses()
    {
        return $this->belongsTo(Courses::class, 'category_id', 'id');
    }
    public function Seminors()
    {
        return $this->belongsTo(Seminor::class, 'seminor_id', 'id');
    }
}
