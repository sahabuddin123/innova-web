<?php

namespace App\Http\Controllers;

use App\Models\Concern;
use Illuminate\Http\Request;

class FrontendConcernController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concerns = Concern::where('status', 1)->latest()->get();
        return view('frontend.modules.concerns', compact('concerns'));
    }
}