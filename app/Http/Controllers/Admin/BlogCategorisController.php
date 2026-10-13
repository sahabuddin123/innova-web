<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\blogCategoris;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use App\Http\Controllers\BaseController;

class BlogCategorisController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = blogCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Blog Categoris', 'List of all Blog Categoris');
        return view('admin.blogcatg.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = blogCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Create New Blog Categoris', 'Create Blog Categoris');
        return view('admin.blogcatg.create', compact('data'));
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
            'categoryName' =>  'required',
            'icon' => 'mimes:jpeg,jpg,png,gif,svg|max:1024'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $icon = null;
        if ($collection->has('icon') && ($params['icon'] instanceof  UploadedFile)) {
            $icon = $this->uploadOne($params['icon'], 'blogctg');
        }
        if($collection->has('icon2') && $params['icon2'] !=null){
            $img = $params['icon2'];
            $path = 'public/blogctg/';
            $paths = 'blogctg/';
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
        $data = new blogCategoris($merge->all());
        $data->save();
        
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Blog Catgory.', 'error', true, true);
        }
        else{
            return $this->responseRedirect('admin.blogcatg.index', 'Course Blog added successfully' ,'success',false, false);
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
        $targetData = blogCategoris::find($id);
        $data = blogCategoris::where('deleted_at',null)->get();
        $this->setPageTitle('Blog Category', 'Edit Blog Category : '.$targetData->CourseCategoris);
        return view('admin.blogcatg.edit', compact('data', 'targetData'));
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
            'categoryName' =>  'required',
            'icon' => 'mimes:jpeg,jpg,png,gif,svg|max:1024'
        ]);

        $data = blogCategoris::find($params['id']);
        $collection = collect($params)->except('_token');
        if ($collection->has('icon') && ($params['icon'] instanceof  UploadedFile)) {
            if ($data->icon != null) {
                $this->deleteOne($data->image);
            }
            $icon = $this->uploadOne($params['icon'], 'blogctg');
        }
        else if($collection->has('icon2') && $params['icon2'] !=null){
            // unlink($params['oldimage']);
            $this->deleteOne($data->image);
            $img = $params['icon2'];
            $path = 'public/blogctg/';
            $paths = 'blogctg/';
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
            return $this->responseRedirectBack('Error occurred while updating Blog Categoy.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blogcatg.index', 'Blog Category Updated Successfully' ,'success',false, false);
    
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
        $data = blogCategoris::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Blog Category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.blogcatg.index', 'Blog Category deleted successfully' ,'success',false, false);
    
    }
}
