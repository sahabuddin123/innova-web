<?php

namespace App\Http\Controllers\Admin;

use App\Models\cmsAbout;
use Illuminate\Http\Request;
use App\Contracts\cmsAboutContact;
use App\Http\Controllers\BaseController;
use DB;

class CmsAboutController extends BaseController
{
     /**
     * @var cmsAboutContact
     */
    protected $certificateRepository;

    /**
     * cmsAboutContact constructor.
     * @param cmsAboutContact $certificateRepository
     */
    public function __construct(cmsAboutContact $certificateRepository)
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
        $data = cmsAbout::where('deleted_at', null)->get();
        $this->setPageTitle('CMS About', 'List of all CMS Acout');
        return view('admin.cmsAbout.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->certificateRepository->listCertificate('id', 'asc');
        $this->setPageTitle('Create New CMS About', 'Create CMS for About');
        return view('admin.cmsAbout.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'IsActive'      =>  'required',
        ]);

        $params = $request->except('_token');

        $certificate = $this->certificateRepository->createCertificate($params);

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while creating CMS About.', 'error', true, true);
        }
        // $students = Students::where('id', $request->student_id)->update(['IsRegister' => 2]);

        return $this->responseRedirect('admin.cmsabout.index', 'CMS About added successfully', 'success', false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificates  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = $this->certificateRepository->findCertificateById($id);
        $data = $this->certificateRepository->listCertificate();
        // $session = Session::where('deleted_at', null)->get();

        $this->setPageTitle('CMS About', 'Edit CMS About : ');
        return view('admin.cmsAbout.edit', compact('data', 'targetData'));
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
            'IsActive'      =>  'required'
        ]);

        $params = $request->except('_token');

        $certificate = $this->certificateRepository->updateCertificate($params);

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while updating CMS About.', 'error', true, true);
        }
        return $this->responseRedirect('admin.cmsabout.index', 'CMS About updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cmsAbout  $certificate
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $data)
    {
        $certificate = $this->certificateRepository->deleteCertificate($data->id);

        if (!$certificate) {
            return $this->responseRedirectBack('Error occurred while deleting CMS About.', 'error', true, true);
        }
        return $this->responseRedirect('admin.cmsabout.index', ' CMS About deleted successfully', 'success', false, false);
    }
}
