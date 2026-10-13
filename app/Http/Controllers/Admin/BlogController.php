<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\blogCategoris;
// use App\Models\Teachers;
use App\Contracts\BlogContract;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController; 

class BlogController extends BaseController
{
        /**
     * @var BlogContract 
     */
    protected $blogRepository;
    /**
     * CategoryController constructor.
     * @param BlogContract $blogRepository
     */
    public function __construct(BlogContract $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = $this->blogRepository->listCourses('id', 'desc');

        $this->setPageTitle('Blogs', 'List of all Blogs');
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogs = $this->blogRepository->listCourses('id', 'asc');
        $blogsCategoris = blogCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        // $Instructor = Teachers::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Create New Blog', 'Create Blog');
        return view('admin.blogs.create', compact('blogs', 'blogsCategoris'));
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
            'category_id'       =>  'required|max:191',
            'heading'           =>  'required|max:191',
            'summary'           =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $courses = $this->blogRepository->createCourse($params);

        if (!$courses) {
            return $this->responseRedirectBack('Error occurred while creating Blogs.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blogs.index', 'Blogs added successfully' ,'success',false, false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetBlogs = $this->blogRepository->findCourseById($id);
        $blogs = $this->blogRepository->listCourses();

        $this->setPageTitle('Blogs', 'View Blog : '.$targetBlogs->heading);
        return view('admin.blogs.show', compact('targetBlogs', 'blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetBlogs = $this->blogRepository->findCourseById($id);
        $blogs = $this->blogRepository->listCourses();
        // $Instructor = Teachers::where('deleted_at',null)->orderBy('id','asc')->get();
        // $courseCategoris = CourseCategory::where('deleted_at',null)->orderBy('id','asc')->get();
        $blogsCategoris = blogCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Blogs', 'Edit Blogs : '.$targetBlogs->heading);
        return view('admin.blogs.edit', compact('targetBlogs', 'blogs', 'blogsCategoris'));
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
            'category_id'       =>  'required|max:191',
            'heading'           =>  'required|max:191',
            'summary'           =>  'required',
            'image'             =>  'mimes:jpg,jpeg,png|max:2000'
        ]);

        $params = $request->except('_token');

        $courses = $this->blogRepository->updateCourse($params);

        if (!$courses) {
            return $this->responseRedirectBack('Error occurred while updating Blogs.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blogs.index', 'Blogs updated successfully' ,'success',false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Courses  $courses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $courses = $this->blogRepository->deleteCourse($id);

        if (!$courses) {
            return $this->responseRedirectBack('Error occurred while deleting Blogs.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blogs.index', 'Blogs deleted successfully' ,'success',false, false);
    }
}
