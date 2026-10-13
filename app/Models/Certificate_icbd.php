<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate_icbd extends Model
{
    use SoftDeletes;

    protected $table = 'certificates_icbd';

    protected $fillable = [
        'student_id',
        'batch_id',
        'course_id',
        'certificate_no',
        'theory_hours',
        'practical_hours',
        'intern_hours',
        'result',
        'issue_date',
        'certificate_receiver',
        'delivery_date',
        'is_active',
        'cimage',
        'dimage',
    ];

    protected $dates = [
        'issue_date',
        'delivery_date',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    // -------------------
    // Relationships
    // -------------------
    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function batch()
    {
        return $this->belongsTo(Branch::class, 'batch_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id');
    }

    

    // -------------------
    // Auto Certificate No.
    // -------------------
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Get last certificate
            $last = Certificate_icbd::orderBy('id', 'desc')->first();

            if ($last) {
                // Extract numeric part from certificate_no (ICBD0001 -> 1)
                $lastNumber = (int) preg_replace('/[^0-9]/', '', $last->certificate_no);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // Format new certificate_no => ICBD0001, ICBD0002, ...
            $model->certificate_no = 'ICBD' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
