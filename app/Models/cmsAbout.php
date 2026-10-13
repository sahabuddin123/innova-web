<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class cmsAbout extends Model
{
    use SoftDeletes;
    /**
     * @var string
     */
    protected $table = 'cms_abouts';

    /**
     * @var array
     */
    protected $fillable = [
        'shortTitle',
        'LongTitle',
        'shortdetail',
        'info1',
        'info2',
        'info3',
        'btnTxt',
        'btnLink',
        'Reviews',
        'Rating',
        'stdId',
        'bgimg1',
        'bgimg2',
        'video',
        'successTraing',
        'completeCourse',
        'satisfaction',
        'stdComunity',
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
