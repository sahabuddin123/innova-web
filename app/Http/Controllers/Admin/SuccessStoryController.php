<?php

namespace App\Http\Controllers\Admin;

use App\Models\SuccessStory;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Contracts\SuccessStoryContract;
use App\Http\Controllers\BaseController; 

class SuccessStoryController extends BaseController
{
    /**
     * @var SuccessStoryContract 
     */
    protected $dataRepository;
    /**
     * CategoryController constructor.
     * @param SuccessStoryContract $dataRepository
     */
    public function __construct(SuccessStoryContract $dataRepository)
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

        $this->setPageTitle('Success Story', 'List of all Success');
        return view('admin.story.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->dataRepository->listData('id', 'asc');
        $student = Students::where('deleted_at', null)->get();
        $this->setPageTitle('Create New Story', 'Create Success');
        return view('admin.story.create', compact('data','student'));
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
            'student_id'        =>  'required|max:191',
            'msg'               =>  'required',
            'IsActive'          =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->createData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Story.', 'error', true, true);
        }
        return $this->responseRedirect('admin.story.index', 'Story added successfully' ,'success',false, false);
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
        $student = Students::where('deleted_at', null)->get();
        $this->setPageTitle('Story', 'Edit Success Story');
        return view('admin.story.edit', compact('data', 'targetData','student'));
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
            'student_id'        =>  'required|max:191',
            'msg'               =>  'required',
            'IsActive'          =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->updateData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Story.', 'error', true, true);
        }
        return $this->responseRedirect('admin.story.index', 'Success Story updated successfully' ,'success',false, false);
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
            return $this->responseRedirectBack('Error occurred while deleting Story.', 'error', true, true);
        }
        return $this->responseRedirect('admin.story.index', 'Story deleted successfully' ,'success',false, false);
    }
} 
