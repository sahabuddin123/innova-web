<?php

namespace App\Http\Controllers\Admin;

use App\Models\Registration;
use App\Models\Session;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Contracts\RegistrationContract;
use App\Http\Controllers\BaseController; 
use DB;

class RegistrationController extends BaseController
{
    
    /**
     * @var RegistrationContract
     */
    protected $registrationRepository;
    
    /**
     * RegistrationContract constructor.
     * @param RegistrationContract $registrationRepository
     */
    public function __construct(RegistrationContract $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registration = Registration::where('deleted_at', null)->get();

        $this->setPageTitle('Registrations', 'List of all Registrations');
        return view('admin.registration.index', compact('registration'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $registration = $this->registrationRepository->listRegistrations('id', 'asc');
        $session = Session::where('deleted_at', null)->get();
        $students = Students::where('deleted_at', null)->where('id', $id)->first();
        
        $this->setPageTitle('Create New Registration', 'Create Registration for <b class="text-success">'.$students->sname."</b>");
        return view('admin.registration.create', compact('registration','session','students'));
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
            'student_id'    =>  'required',
            'session_id'    =>  'required',
            'ExamName'      =>  'required',
            'ExamBoard'     =>  'required',
            'ExamSession'   =>  'required',
            'ExamRoll'      =>  'required',
            'PassYear'      =>  'required',
            'balance'       =>  'required',
            'IsActive'      =>  'required',
            'regDate'       =>  'required',
        ]);

        $params = $request->except('_token');

        $registration = $this->registrationRepository->createRegistrations($params);

        if (!$registration) {
            return $this->responseRedirectBack('Error occurred while creating Registrations.', 'error', true, true);
        }
        $students = Students::where('id', $request->student_id)->update(['IsRegister' => 2]);
        
        return $this->responseRedirect('admin.registration.index', 'Registrations added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetRegistration = $this->registrationRepository->findRegistrationsById($id);
        $registration = $this->registrationRepository->listRegistrations();
        $this->setPageTitle('Registrations', 'View Registrations : '.$targetRegistration->StudentsInfo->sname);
        return view('admin.registration.show', compact('registration', 'targetRegistration'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetRegistration = $this->registrationRepository->findRegistrationsById($id);
        $registration = $this->registrationRepository->listRegistrations();
        $session = Session::where('deleted_at', null)->get();

        $this->setPageTitle('Registration', 'Edit Registration : '.$targetRegistration->StudentsInfo->sname);
        return view('admin.registration.edit', compact('registration', 'targetRegistration', 'session'));
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
            'ExamName'      =>  'required',
            'ExamBoard'     =>  'required',
            'ExamSession'   =>  'required',
            'ExamRoll'      =>  'required',
            'PassYear'      =>  'required',
            'balance'       =>  'required',
            'IsActive'      =>  'required',
            'regDate'       =>  'required',
        ]);

        $params = $request->except('_token');

        $registration = $this->registrationRepository->updateRegistrations($params);

        if (!$registration) {
            return $this->responseRedirectBack('Error occurred while updating Registration.', 'error', true, true);
        }
        return $this->responseRedirect('admin.registration.index', 'Registration updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $data)
    {
        // date_default_timezone_set('Asia/Dhaka');
        // $date = date('y-m-d h:i:s');
        // $studentDel = Students::where('id', $data->student_id)->update(['IsActive' => 1]);
        $students = Students::where('id', $data->student_id)->update(['IsRegister' => 1]);

        $registration = $this->registrationRepository->deleteRegistrations($data->id);

        // if (!$courses) {
        //     return $this->responseRedirectBack('Error occurred while deleting Courses.', 'error', true, true);
        // }
        // return $this->responseRedirect('admin.courses.index', 'Courses deleted successfully' ,'success',false, false);
        
        if (!$registration) {
            return $this->responseRedirectBack('Error occurred while deleting Registration.', 'error', true, true);
        }
        return $this->responseRedirect('admin.registration.index', 'Registration deleted successfully' ,'success',false, false);
    }
}
