<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certificate_icbd;
use App\Models\Students;
use App\Models\Batchs;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

class CertificateICBDController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificates = Certificate_icbd::whereNull('deleted_at')->get();

        $this->setPageTitle('Certificates (ICBD)', 'List of all ICBD Certificates');
        return view('admin.certificate_icbd.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($studentId)
    {
        $students   = Students::whereNull('deleted_at')->where('id', $studentId)->first();
        $batches    = Batchs::whereNull('deleted_at')->get();
        $courses    = Courses::whereNull('deleted_at')->get();

        $this->setPageTitle('Create Certificate (ICBD)', 'Create Certificate for <b class="text-success">' . $students->sname . "</b>");
        return view('admin.certificate_icbd.create', compact('students', 'batches', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'student_id'    => 'required',
            'batch_id'      => 'required',
            'course_id'     => 'required',
            'is_active'     => 'required',
        ]);

        $params = $request->except('_token');

        $certificate = Certificate_icbd::create($params);

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while creating certificate.', 'error', true, true);
        }

        Students::where('id', $request->student_id)->update(['IsRegister' => 2]);

        return $this->responseRedirect('admin.certificate_icbd.index', 'Certificate added successfully', 'success', false, false);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $certificate = Certificate_icbd::with(['student', 'batch', 'course'])->findOrFail($id);

        $this->setPageTitle('Certificate (ICBD)', 'View Certificate : ' . $certificate->student->sname);
        return view('admin.certificate_icbd.show', compact('certificate'));
    }
    public function print($id)
    {
        $certificate = Certificate_icbd::with(['student', 'batch', 'course'])->findOrFail($id);

        $this->setPageTitle('Certificate (ICBD)', 'Print Certificate : ' . $certificate->student->sname);
        return view('admin.certificate_icbd.print', compact('certificate'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $target   = Certificate_icbd::findOrFail($id);
        $students = Students::whereNull('deleted_at')->where('id',$target->student->id)->first();
        $batches  = Batchs::whereNull('deleted_at')->get();
        $courses  = Courses::whereNull('deleted_at')->get();

        $this->setPageTitle('Certificate (ICBD)', 'Edit Certificate : ' . $target->student->sname);
        return view('admin.certificate_icbd.edit', compact('target', 'students', 'batches', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'student_id'    => 'required',
            'batch_id'      => 'required',
            'course_id'     => 'required',
            'is_active'     => 'required'
        ]);

        $certificate = Certificate_icbd::findOrFail($request->id);
        $certificate->update($request->except('_token', '_method'));

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while updating certificate.', 'error', true, true);
        }

        return $this->responseRedirect('admin.certificate_icbd.index', 'Certificate updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        Students::where('id', $request->student_id)->update(['IsRegister' => 1]);

        $certificate = Certificate_icbd::findOrFail($request->id);
        $certificate->delete();

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while deleting certificate.', 'error', true, true);
        }

        return $this->responseRedirect('admin.certificate_icbd.index', 'Certificate deleted successfully', 'success', false, false);
    }
}
