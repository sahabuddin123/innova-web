<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'galleries';
    /**
     * @var array
     */
    protected $fillable = ['title', 'image', 'type', 'IsActive'];
}
