<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetRegistrationFeedback extends Model
{
    use HasFactory;

    protected $table = 'asset_registration_feedbacks';

    protected $fillable = [
        'asset_registration_id',
        'feedback_step',
        'feedback',
    ];

    public function registration()
    {
        return $this->belongsTo(AssetRegistration::class, 'asset_registration_id');
    }
}
