<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /**
     * @var string
     */
    protected $table = 'sessions';

    /**
     * @var array
     */
    protected $fillable = [
        'sessionName',
        'IsActive',
        'startdate',
        'enddate'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function SessionInfo()
    {
        return $this->hasMany(Registration::class, 'session_id');
    }
}
