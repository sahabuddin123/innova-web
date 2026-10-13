<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Slider extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'sliders';

    /**
     * @var array
     */
    protected $fillable = [
        'subTitle','title','details','btnTxt','btnLink','btnTxtTwo','btnLinkwo','enrolStdTxt','sucesStdId','offerTxt','oferTxtContent','suprtText','suprtTextContent','IsActive','image'
    ];
    /**
     * @var string
     */
    protected $dates = ['deleted_at'];

    // 
}
