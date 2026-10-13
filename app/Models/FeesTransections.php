<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class FeesTransections extends Model
{
    /**
     * @var string
     */
    protected $table = 'fees_transections';

    /**
     * @var array
     */
    protected $fillable = [
        // 'user_id',
        'student_id',
        'paidamount',
        'paymentType',
        'paiddate',
        'paidremark'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function StudentInfo()
    {
        return $this->hasMany(Students::class, 'id');
    }
    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'id');
    }
    /**
     * @return Php Date function
     */
    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
   
}
