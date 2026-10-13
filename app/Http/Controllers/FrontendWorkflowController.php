<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use Illuminate\Http\Request;

class FrontendWorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workflows = Workflow::where('status', 1)->orderBy('step')->get();
        return view('frontend.modules.workflow', compact('workflows'));
    }
}