<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certificates;
use App\Models\Session;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Contracts\CertificateContact;
use App\Http\Controllers\BaseController;
use DB;

class CertificateController extends BaseController
{

    /**
     * @var CertificateContact
     */
    protected $certificateRepository;

    /**
     * CertificateContact constructor.
     * @param CertificateContact $certificateRepository
     */
    public function __construct(CertificateContact $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificate = Certificates::where('deleted_at', null)->get();

        $this->setPageTitle('Certificates', 'List of all Certificates');
        return view('admin.certificate.index', compact('certificate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $certificate = $this->certificateRepository->listCertificate('id', 'asc');
        $session = Session::where('deleted_at', null)->get();
        $students = Students::where('deleted_at', null)->where('id', $id)->first();

        $this->setPageTitle('Create New Certificate', 'Create Certificate for <b class="text-success">' . $students->sname . "</b>");
        return view('admin.certificate.create', compact('certificate', 'session', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *    'student_id',
     *    'session_id',
     *    'regNo',
     *    'cno',
     *    'pDate',
     *    'recevier',
     *    'cimage',
     *    'dimage',
     *    'Result',
     *    'dDate',
     *    'IsActive',
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'student_id'    =>  'required',
            'session_id'    =>  'required',
            'regNo'         =>  'required',
            'IsActive'      =>  'required',
        ]);

        $params = $request->except('_token');

        $certificate = $this->certificateRepository->createCertificate($params);

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while creating Certificate.', 'error', true, true);
        }
        $students = Students::where('id', $request->student_id)->update(['IsRegister' => 2]);

        return $this->responseRedirect('admin.certificate.index', 'Certificate added successfully', 'success', false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificates  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $target = $this->certificateRepository->findCertificateById($id);
        $certificate = $this->certificateRepository->listCertificate();
        $this->setPageTitle('Certificate', 'View Certificate : ' . $target->StudentsInfo->sname);
        return view('admin.certificate.show', compact('certificate', 'target'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $target = $this->certificateRepository->findCertificateById($id);
        $certificate = $this->certificateRepository->listCertificate();
        $session = Session::where('deleted_at', null)->get();

        $this->setPageTitle('Certificate', 'Edit Certificate : ' . $target->StudentsInfo->sname);
        return view('admin.certificate.edit', compact('certificate', 'target', 'session'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'student_id'    =>  'required',
            'session_id'    =>  'required',
            'regNo'         =>  'required',
            'IsActive'      =>  'required'
        ]);

        $params = $request->except('_token');

        $certificate = $this->certificateRepository->updateCertificate($params);

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while updating Certificate.', 'error', true, true);
        }
        return $this->responseRedirect('admin.certificate.index', 'Certificate updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $data)
    {
        // date_default_timezone_set('Asia/Dhaka');
        // $date = date('y-m-d h:i:s');
        // $studentDel = Students::where('id', $data->student_id)->update(['IsActive' => 1]);
        $students = Students::where('id', $data->student_id)->update(['IsRegister' => 1]);

        $certificate = $this->certificateRepository->deleteCertificate($data->id);

        // if (!$courses) {
        //     return $this->responseRedirectBack('Error occurred while deleting Courses.', 'error', true, true);
        // }
        // return $this->responseRedirect('admin.courses.index', 'Courses deleted successfully' ,'success',false, false);

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while deleting Certificate.', 'error', true, true);
        }
        return $this->responseRedirect('admin.certificate.index', 'Certificate deleted successfully', 'success', false, false);
    }
}
