<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admission;
use App\Models\Courses;
use App\Contracts\AdmissionContact;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use DB;
class AdmissionController extends BaseController
{
    /**
     * @var AdmissionContact
     */
    protected $admissionRepository;
    /**
     * CategoryController constructor.
     * @param AdmissionContact $categoryRepository
     */
    public function __construct(AdmissionContact $admissionRepository)
    {
        $this->admissionRepository = $admissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $admission = Admission::get();
        $admission = $this->admissionRepository->list();
        // dd($admission);
        $courseName = Courses::where('id', $admission->first()->courseId)->first();
        $this->setPageTitle('Admission', 'List of all online Admission');
        return view('admin.admission.index', compact('admission','courseName'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invesments  $invesments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $target = $this->admissionRepository->findById($id);
        $courseName = Courses::where('deleted_at', null)->get();
        // dd($shareHolder->name);
        $this->setPageTitle('Online Admission', 'Edit Online Admission');
        return view('admin.admission.edit', compact('target','courseName'));
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invesments  $invesments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'username'  =>  'required',
            'courseId' =>  'required',
            'courseType' =>  'required',
            'isActive' =>  'required'
        ]);
       
        $params = $request->except('_token');

        $admission = $this->admissionRepository->updateData($params);

        if (!$admission) {
            return $this->responseRedirectBack('Error occurred while updating Admission.', 'error', true, true);
        }
        return $this->responseRedirect('admin.admission.index', 'Admission updated successfully' ,'success',false, false);
    }

}
