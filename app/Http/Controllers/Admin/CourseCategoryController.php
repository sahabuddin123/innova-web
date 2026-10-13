<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use App\Http\Controllers\BaseController;

class CourseCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CourseCategory::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Course Categoris', 'List of all Course Categoris');
        return view('admin.coursecatg.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = CourseCategory::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Create New Course Categoris', 'Create Course Categoris');
        return view('admin.coursecatg.create', compact('data'));
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
            'CourseCategoris' =>  'required',
            'icon' => 'required|mimes:jpeg,jpg,png,gif,svg|max:1024'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $icon = null;
        if ($collection->has('icon') && ($params['icon'] instanceof  UploadedFile)) {
            $icon = $this->uploadOne($params['icon'], 'course');
        }
        if($collection->has('icon2') && $params['icon2'] !=null){
            $img = $params['icon2'];
            $path = 'public/course/';
            $paths = 'course/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("icon/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $icon = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        }
        $merge = $collection->merge(compact('icon'));
        $data = new CourseCategory($merge->all());
        $data->save();
        
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Course Catgory.', 'error', true, true);
        }
        else{
            return $this->responseRedirect('admin.coursecatg.index', 'Course Category added successfully' ,'success',false, false);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expanse  $expanse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = CourseCategory::find($id);
        $data = CourseCategory::where('deleted_at',null)->get();
        $this->setPageTitle('Course Category', 'Edit Coyrse Category : '.$targetData->CourseCategoris);
        return view('admin.coursecatg.edit', compact('data', 'targetData'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expanse  $expanse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $params)
    {
        $this->validate($params, [
            'CourseCategoris' =>  'required',
            'icon' => 'mimes:jpeg,jpg,png,gif,svg|max:1024'
        ]);

        $data = CourseCategory::find($params['id']);
        $collection = collect($params)->except('_token');
        if ($collection->has('icon') && ($params['icon'] instanceof  UploadedFile)) {
            if ($data->icon != null) {
                $this->deleteOne($data->image);
            }
            $icon = $this->uploadOne($params['icon'], 'course');
        }
        else if($collection->has('icon2') && $params['icon2'] !=null){
            // unlink($params['oldimage']);
            $this->deleteOne($data->image);
            $img = $params['icon2'];
            $path = 'public/course/';
            $paths = 'course/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("icon/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $icon = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        }
        else{
            $icon = $params['oldicon'];
        }
        $merge = $collection->merge(compact('icon'));
        $data->update($merge->all());
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Course Categoy.', 'error', true, true);
        }
        return $this->responseRedirect('admin.coursecatg.index', 'Course Category Updated Successfully' ,'success',false, false);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expanse  $expanse
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $data = CourseCategory::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Course Category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.coursecatg.index', 'Course Category deleted successfully' ,'success',false, false);
    
    }

}
