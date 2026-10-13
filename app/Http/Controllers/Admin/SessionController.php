<?php

namespace App\Http\Controllers\Admin;

use App\Models\Session;
use App\Contracts\SessionContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;

class SessionController extends BaseController
{
 
    /**
     * @var SessionContract
     */
    protected $sessionRepository;
    /**
     * CategoryController constructor.
     * @param SessionContract $sessionRepository
     */
    public function __construct(SessionContract $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $sessions = $this->sessionRepository->listSessions();
        $sessions = DB::table('sessions')->where('deleted_at', null)->get();

        $this->setPageTitle('Sessions', 'List of all Sessions');
        return view('admin.session.index', compact('sessions'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sessions = $this->sessionRepository->listSessions('id', 'asc');
        
        $this->setPageTitle('Create New Sessions', 'Create Sessions');
        return view('admin.session.create', compact('sessions'));
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
            'sessionName'      =>  'required|max:191',
            'IsActive' =>  'required'
        ]);

        $params = $request->except('_token');

        $sessions = $this->sessionRepository->createSessions($params);

        if (!$sessions) {
            return $this->responseRedirectBack('Error occurred while creating Session.', 'error', true, true);
        }
        return $this->responseRedirect('admin.session.index', 'Session added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetsessions = $this->sessionRepository->findSessionsById($id);
        $sessions = $this->sessionRepository->listSessions();

        $this->setPageTitle('Sessions', 'View Sessions : '.$targetsessions->sessionName);
        return view('admin.session.show', compact('sessions', 'targetsessions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetsessions = $this->sessionRepository->findSessionsById($id);
        $sessions = $this->sessionRepository->listSessions();

        $this->setPageTitle('Sessions', 'Edit Sessions : '.$targetsessions->sessionName);
        return view('admin.session.edit', compact('sessions', 'targetsessions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'sessionName'      =>  'required|max:191',
            'IsActive' =>  'required'
        ]);

        $params = $request->except('_token');

        $sessions = $this->sessionRepository->updateSessions($params);

        if (!$sessions) {
            return $this->responseRedirectBack('Error occurred while updating Sessions.', 'error', true, true);
        }
        return $this->responseRedirect('admin.session.index', 'Sessions updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('y-m-d h:i:s');
        $session = DB::table('sessions')->where('id', $id)->update(['deleted_at' => $date]);
        
        if (!$session) {
            return $this->responseRedirectBack('Error occurred while deleting Sessions.', 'error', true, true);
        }
        return $this->responseRedirect('admin.session.index', 'Sessions deleted successfully' ,'success',false, false);
    }
}
