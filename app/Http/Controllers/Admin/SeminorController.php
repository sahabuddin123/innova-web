<?php

namespace App\Http\Controllers\Admin;

use App\Models\Seminor;
use App\Models\Courses;
use Illuminate\Http\Request;
use App\Contracts\SeminorContract;
use App\Http\Controllers\BaseController; 

class SeminorController extends BaseController
{
    /**
     * @var SeminorContract 
     */
    protected $dataRepository;
    /**
     * CategoryController constructor.
     * @param SeminorContract $dataRepository
     */
    public function __construct(SeminorContract $dataRepository)
    {
        $this->dataRepository = $dataRepository; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->dataRepository->listData('id', 'desc');

        $this->setPageTitle('Seminor', 'List of all Seminor');
        return view('admin.seminor.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->dataRepository->listData('id', 'asc');
        $course = Courses::where('deleted_at', null)->get();
        $this->setPageTitle('Create New Seminor', 'Create Seminor');
        return view('admin.seminor.create', compact('data','course'));
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
            // 'student_id'        =>  'required|max:191',
            // 'msg'               =>  'required',
            'IsActive'          =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->createData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating seminor.', 'error', true, true);
        }
        return $this->responseRedirect('admin.seminor.index', 'seminor added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SuccessStory  $SuccessStory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = $this->dataRepository->findDataById($id);
        $data = $this->dataRepository->listData();
        $course = Courses::where('deleted_at', null)->get();
        $this->setPageTitle('seminor', 'Edit seminor');
        return view('admin.seminor.edit', compact('data', 'targetData','course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SuccessStory  $SuccessStory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            // 'student_id'        =>  'required|max:191',
            // 'msg'               =>  'required',
            'IsActive'          =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->updateData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating seminor.', 'error', true, true);
        }
        return $this->responseRedirect('admin.seminor.index', 'seminor updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SuccessStory  $SuccessStory
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $data = $this->dataRepository->deleteData($id);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting seminor.', 'error', true, true);
        }
        return $this->responseRedirect('admin.seminor.index', 'seminor deleted successfully' ,'success',false, false);
    }
}
