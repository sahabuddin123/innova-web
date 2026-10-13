<?php

namespace App\Models;

use App\Models\AssetRegistration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetCourse extends Model
{
    use HasFactory;

    protected $table = 'asset_courses';

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'level',
        'icon',
        'button_color',
        'course_outline',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Relationship with AssetRegistration
    public function registrations()
    {
        return $this->hasMany(AssetRegistration::class, 'course', 'name');
    }
}
