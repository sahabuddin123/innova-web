<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * @var string
     */
    protected $table = 'branches';

    /**
     * @var array
     */
    protected $fillable = [
        'bname',
        'baddress',
        'startdate',
        'btype',
        'IsActive'
    ];
    
}
