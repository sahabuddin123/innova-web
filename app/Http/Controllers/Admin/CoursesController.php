<?php

namespace App\Http\Controllers\Admin;

use App\Models\Courses;
use App\Models\CourseCategory;
use App\Models\Teachers;
use App\Contracts\CoursesContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController; 

class CoursesController extends BaseController
{
    /**
     * @var CoursesContract 
     */
    protected $courseRepository;
    /**
     * CategoryController constructor.
     * @param CoursesContract $categoryRepository
     */
    public function __construct(CoursesContract $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    
        $courses = Courses::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Courses', 'List of all courses');
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = $this->courseRepository->listCourses('id', 'asc');
        $courseCategoris = CourseCategory::where('deleted_at',null)->orderBy('id','asc')->get();
        $Instructor = Teachers::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Create New Courses', 'Create Courses');
        return view('admin.courses.create', compact('courses', 'courseCategoris', 'Instructor'));
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
            'name'      =>  'required|max:191',
            'coursefee' =>  'required',
            'image'     =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $courses = $this->courseRepository->createCourse($params);

        if (!$courses) {
            return $this->responseRedirectBack('Error occurred while creating courses.', 'error', true, true);
        }
        return $this->responseRedirect('admin.courses.index', 'Courses added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetCourses = $this->courseRepository->findCourseById($id);
        $courses = $this->courseRepository->listCourses();

        $this->setPageTitle('Courses', 'View Courses : '.$targetCourses->name);
        return view('admin.courses.show', compact('courses', 'targetCourses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetCourses = $this->courseRepository->findCourseById($id);
        $courses = $this->courseRepository->listCourses();
        $Instructor = Teachers::where('deleted_at',null)->orderBy('id','asc')->get();
        $courseCategoris = CourseCategory::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Courses', 'Edit Courses : '.$targetCourses->name);
        return view('admin.courses.edit', compact('courses', 'targetCourses', 'courseCategoris', 'Instructor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required|max:191',
            'coursefee' =>  'required',
            'courseduration' =>  'required',
            'image'     =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $courses = $this->courseRepository->updateCourse($params);

        if (!$courses) {
            return $this->responseRedirectBack('Error occurred while updating courses.', 'error', true, true);
        }
        return $this->responseRedirect('admin.courses.index', 'Courses updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        
        $date = date('y-m-d h:i:s');
        $data = Courses::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Courses.', 'error', true, true);
        }
        return $this->responseRedirect('admin.courses.index', 'Courses deleted successfully', 'success', false, false);
    }
}
