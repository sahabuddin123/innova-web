<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;

    protected $table = 'assets';

    protected $fillable = [
        'title',
        'level',
        'short_description',
        'button_text',
        'button_url',
        'image',
        'sort_order',
        'IsActive'
    ];
}
