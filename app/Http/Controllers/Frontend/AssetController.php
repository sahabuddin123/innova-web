<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetCourse;
use App\Models\AssetRegistration;
use Intervention\Image\Facades\Image;

class AssetController extends Controller
{
    public function index()
    {
        $assetCourses = AssetCourse::where('status', true)->get();
        return view('frontend.v2.asset.index', compact('assetCourses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course'              => 'required',
            'full_name'           => 'required|string|max:255',
            'father_name'         => 'required|string|max:255',
            'mother_name'         => 'required|string|max:255',
            'mobile'              => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'whatsapp'            => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'call_type'           => 'nullable|in:1st call,2nd call,3rd call,4th call,5th call',
            'email'               => 'required|email',
            'religion'            => 'required',
            'gender'              => 'required',
            'dob'                 => 'required|date',
            'nid'                 => 'required',
            'employment_status'   => 'required',
            'address'             => 'required',
            'education'           => 'required',
            'board'               => 'required',
            'subject'             => 'required',
            'passing_year'        => 'required',
            'photo'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $savePath = public_path('uploads/asset/' . $photoName);

            if (!file_exists(dirname($savePath))) {
                mkdir(dirname($savePath), 0755, true);
            }

            Image::make($photo)
                ->fit(300, 300)
                ->save($savePath);
        }

        try {
            AssetRegistration::create([
                'course'              => $request->course,
                'full_name'           => $request->full_name,
                'father_name'         => $request->father_name,
                'mother_name'         => $request->mother_name,
                'mobile'              => $request->mobile,
                'whatsapp'            => $request->whatsapp,
                'call_type'           => $request->call_type,
                'email'               => $request->email,
                'religion'            => $request->religion,
                'gender'              => $request->gender,
                'dob'                 => $request->dob,
                'nid'                 => $request->nid,
                'employment_status'   => $request->employment_status,
                'address'             => $request->address,
                'education'           => $request->education,
                'board'               => $request->board,
                'subject'             => $request->subject,
                'passing_year'        => $request->passing_year,
                'photo'               => $photoName,
                'registration_status' => 'Pending',
            ]);
        } catch (\Exception $exception) {
            return back()->with('error', 'Registration failed. Please try again.');
        }

        return back()->with('success', 'Registration submitted successfully.');
    }
}
