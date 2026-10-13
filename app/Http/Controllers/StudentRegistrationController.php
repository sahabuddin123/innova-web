<?php

namespace App\Http\Controllers;

use App\Models\AssetCourse;
use App\Models\AssetStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class StudentRegistrationController extends Controller
{
    public function create()
    {
        $courses = AssetCourse::where('status', 1)->orderBy('name')->get();
        return view('frontend.v2.asset-training.register', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:asset_courses,id',
            'full_name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:asset_students,email',
            'address' => 'required|string|max:1000',
            'phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'whatsapp' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'date_of_birth' => 'required|date',
            'educational_qualification' => 'required|string|max:191',
            'educational_organization' => 'required|string|max:191',
            'current_status' => 'required|string|in:Student,Job Holder,Freelancer,Unemployed,Businessman,Other',
            'has_bank_account' => 'required|in:0,1',
            'nid_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'passport_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
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
            'has_bank_account'
        ]);

        foreach (['nid_file', 'certificate_file', 'passport_image'] as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('asset_students', $filename, 'public');
                $data[$field] = $path;
            }
        }

        $data['registration_status'] = 'Pending';

        AssetStudent::create($data);

        return redirect()->route('asset-training.register')->with('success', 'Your registration has been received. We will contact you soon.');
    }
}
