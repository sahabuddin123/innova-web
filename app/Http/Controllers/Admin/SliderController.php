<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Contracts\SliderContract;
use App\Http\Controllers\BaseController; 

class SliderController extends BaseController
{
    /**
     * @var SliderContract 
     */
    protected $dataRepository;
    /**
     * CategoryController constructor.
     * @param SliderContract $dataRepository
     */
    public function __construct(SliderContract $dataRepository)
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

        $this->setPageTitle('Slider', 'List of all Slider');
        return view('admin.slider.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->dataRepository->listData('id', 'asc');

        $this->setPageTitle('Create New Slider', 'Create Slider');
        return view('admin.slider.create', compact('data'));
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
            'title'      =>  'required|max:400',
            'details' =>  'required',
            'btnTxt' =>  'required',
            'btnLink' =>  'required',
            'image'     =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->createData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Slider.', 'error', true, true);
        }
        return $this->responseRedirect('admin.slider.index', 'Slider added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $targetCourses = $this->dataRepository->findCourseById($id);
        // $courses = $this->dataRepository->listCourses();

        // $this->setPageTitle('Courses', 'View Courses : '.$targetCourses->name);
        // return view('admin.courses.show', compact('courses', 'targetCourses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $Slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = $this->dataRepository->findDataById($id);
        $data = $this->dataRepository->listData();
        $this->setPageTitle('Slider', 'Edit Slider');
        return view('admin.slider.edit', compact('data', 'targetData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $Slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'title'      =>  'required|max:400',
            'details' =>  'required',
            'btnTxt' =>  'required',
            'btnLink' =>  'required',
            'image'     =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $data = $this->dataRepository->updateData($params);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Slider.', 'error', true, true);
        }
        return $this->responseRedirect('admin.slider.index', 'Slider updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $data = $this->dataRepository->deleteData($id);

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Slider.', 'error', true, true);
        }
        return $this->responseRedirect('admin.slider.index', 'Slider deleted successfully' ,'success',false, false);
    }
} 
