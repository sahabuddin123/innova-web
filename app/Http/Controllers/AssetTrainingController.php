<?php

namespace App\Http\Controllers;

use App\Models\AssetCourse;
use Illuminate\Http\Request;

class AssetTrainingController extends Controller
{
    public function index()
    {
        $courses = AssetCourse::where('status', 1)->orderBy('name')->get();
        return view('frontend.v2.asset-training.index', compact('courses'));
    }
}
