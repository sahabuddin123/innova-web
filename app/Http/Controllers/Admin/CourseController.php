<?php

namespace App\Http\Controllers\Admin;

use App\Models\AssetCourse;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends BaseController
{
    public function index()
    {
        $courses = AssetCourse::orderBy('id', 'desc')->paginate(25);
        $this->setPageTitle('Asset Courses', 'Manage ASSET training courses');
        return view('admin.asset-training.courses.index', compact('courses'));
    }

    public function create()
    {
        $this->setPageTitle('Create Asset Course', 'Add a new ASSET course');
        return view('admin.asset-training.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:asset_courses,slug',
            'short_description' => 'required|string|max:500',
            'level' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:191',
            'button_color' => 'nullable|string|max:50',
            'course_outline' => 'nullable|file|mimes:pdf,doc,docx,txt,png,jpg,jpeg|max:20480',
            'status' => 'required|in:0,1',
        ]);

        $payload = $request->only(['name', 'slug', 'short_description', 'level', 'icon', 'button_color', 'status']);
        $payload['slug'] = $payload['slug'] ?: Str::slug($payload['name']);
        $payload['button_color'] = $payload['button_color'] ?: '#071875';

        if ($request->hasFile('course_outline')) {
            $payload['course_outline'] = $request->file('course_outline')->store('asset_course_outlines', 'public');
        }

        if (AssetCourse::where('slug', $payload['slug'])->exists()) {
            return redirect()->back()->withErrors(['slug' => 'Slug already in use'])->withInput();
        }

        AssetCourse::create($payload);

        return $this->responseRedirect('admin.asset-training.courses.index', 'Course created successfully', 'success', false, false);
    }

    public function edit($id)
    {
        $course = AssetCourse::findOrFail($id);
        $this->setPageTitle('Edit Asset Course', 'Update ASSET course');
        return view('admin.asset-training.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = AssetCourse::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:asset_courses,slug,' . $course->id,
            'short_description' => 'required|string|max:500',
            'level' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:191',
            'button_color' => 'nullable|string|max:50',
            'course_outline' => 'nullable|file|mimes:pdf,doc,docx,txt,png,jpg,jpeg|max:20480',
            'status' => 'required|in:0,1',
        ]);

        $payload = $request->only(['name', 'slug', 'short_description', 'level', 'icon', 'button_color', 'status']);
        $payload['slug'] = $payload['slug'] ?: Str::slug($payload['name']);
        $payload['button_color'] = $payload['button_color'] ?: '#071875';

        if ($request->hasFile('course_outline')) {
            if ($course->course_outline) {
                Storage::disk('public')->delete($course->course_outline);
            }
            $payload['course_outline'] = $request->file('course_outline')->store('asset_course_outlines', 'public');
        }

        if (AssetCourse::where('slug', $payload['slug'])->where('id', '!=', $course->id)->exists()) {
            return redirect()->back()->withErrors(['slug' => 'Slug already in use'])->withInput();
        }

        $course->update($payload);
        return $this->responseRedirect('admin.asset-training.courses.index', 'Course updated successfully', 'success', false, false);
    }

    public function delete($id)
    {
        $course = AssetCourse::findOrFail($id);
        $course->delete();
        return $this->responseRedirect('admin.asset-training.courses.index', 'Course deleted successfully', 'success', false, false);
    }
}
