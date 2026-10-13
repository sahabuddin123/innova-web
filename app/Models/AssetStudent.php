<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetStudent extends Model
{
    use HasFactory;

    protected $table = 'asset_students';

    protected $fillable = [
        'course_id',
        'full_name',
        'email',
        'address',
        'phone',
        'whatsapp',
        'date_of_birth',
        'educational_qualification',
        'educational_organization',
        'current_status',
        'has_bank_account',
        'nid_file',
        'certificate_file',
        'passport_image',
        'registration_status',
    ];

    protected $casts = [
        'has_bank_account' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(AssetCourse::class, 'course_id');
    }
}
