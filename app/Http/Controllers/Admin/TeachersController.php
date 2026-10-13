<?php

namespace App\Http\Controllers\Admin;
use App\Models\Teachers;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class TeachersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stuff = Teachers::where('deleted_at',null)->get();
        
        $this->setPageTitle('Stuff', 'List of all Stuff');
        return view('admin.stuff.index', compact('stuff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stuff = Teachers::where('deleted_at',null)->orderBy('id','asc')->get();
    
        $this->setPageTitle('Create New Stuff', 'Create Stuff');
        return view('admin.stuff.create', compact('stuff'));
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
            'stuffid'  =>  'required',
            'name' =>  'required',
            'fname' =>  'required',
            'mname' =>  'required',
            'religion' =>  'required',
            'maritalStatus' =>  'required',
            'phone' =>  'required',
            'education' =>  'required',
            'designation' =>  'required',
            'department' =>  'required',
            'salary' =>  'required',
            'contactType' =>  'required',
            'joiningdate' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1024'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $image = null;
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            $image = $this->uploadOne($params['image'], 'stuff');
        }
        if($collection->has('image2') && $params['image2'] !=null){
            $img = $params['image2'];
            $path = 'public/stuff/';
            $paths = 'stuff/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $image = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        }
        $merge = $collection->merge(compact('image'));
        $stuff = new Teachers($merge->all());
        $stuff->save();
        
        if (!$stuff) {
            return $this->responseRedirectBack('Error occurred while creating Stuff.', 'error', true, true);
        }
        else{
            return $this->responseRedirect('admin.stuff.index', 'Stuff added successfully' ,'success',false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teachers  $teachers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $targetStudents = Teachers::find($id);
        $teachers = Teachers::where('deleted_at',null)->orderBy('id','desc')->get();
        $this->setPageTitle('Stuff', 'View Stuff : '.$targetStudents->name);
        return view('admin.stuff.show', compact('teachers', 'targetStudents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teachers  $teachers
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetStuff = Teachers::find($id);
        $stuff = Teachers::where('deleted_at',null)->get();
        $this->setPageTitle('Stuff', 'Edit Stuff : '.$targetStuff->name);
        return view('admin.stuff.edit', compact('stuff', 'targetStuff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teachers  $teachers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $params)
    {
        $this->validate($params, [
            'stuffid'  =>  'required',
            'name' =>  'required',
            'fname' =>  'required',
            'mname' =>  'required',
            'religion' =>  'required',
            'maritalStatus' =>  'required',
            'phone' =>  'required',
            'education' =>  'required',
            'designation' =>  'required',
            'department' =>  'required',
            'salary' =>  'required',
            'contactType' =>  'required',
            'joiningdate' =>  'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1024'
        ]);
        $stuff = Teachers::find($params['id']);
        $collection = collect($params)->except('_token');
        if ($collection->has('image') && ($params['image'] instanceof  UploadedFile)) {
            if ($stuff->image != null) {
                $this->deleteOne($stuff->image);
            }
            $image = $this->uploadOne($params['image'], 'stuff');
        }
        else if($collection->has('image2') && $params['image2'] !=null){
            // unlink($params['oldimage']);
            $this->deleteOne($stuff->image);
            $img = $params['image2'];
            $path = 'public/stuff/';
            $paths = 'stuff/';
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = uniqid() . '.png';
            $imagepth = $path . $fileName;
            $image = $paths . $fileName;
            Storage::put($imagepth, $image_base64);
        }
        else{
            $image = $params['oldimage'];
        }
        $merge = $collection->merge(compact('image'));
        $stuff->update($merge->all());
        if (!$stuff) {
            return $this->responseRedirectBack('Error occurred while updating Stuff.', 'error', true, true);
        }
        return $this->responseRedirect('admin.stuff.index', 'Stuff updated successfully' ,'success',false, false);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teachers  $teachers
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $stuff = Teachers::where('id', $id)->update(['deleted_at' => $date]);
        if (!$stuff) {
            return $this->responseRedirectBack('Error occurred while deleting Stuff.', 'error', true, true);
        }
        return $this->responseRedirect('admin.stuff.index', 'Stuff deleted successfully' ,'success',false, false);
    }
}
