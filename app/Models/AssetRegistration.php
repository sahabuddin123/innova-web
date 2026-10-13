<?php

namespace App\Models;

use App\Models\AssetRegistrationFeedback;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'course',
        'full_name',
        'father_name',
        'mother_name',
        'mobile',
        'whatsapp',
        'call_type',
        'email',
        'religion',
        'gender',
        'dob',
        'nid',
        'employment_status',
        'address',
        'education',
        'board',
        'subject',
        'passing_year',
        'photo',
        'registration_status',
    ];

    public function feedbacks()
    {
        return $this->hasMany(AssetRegistrationFeedback::class, 'asset_registration_id')->orderBy('feedback_step');
    }
}
