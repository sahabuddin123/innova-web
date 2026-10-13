<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Models\ExpanseCategoris;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

class ExpanseCategorisController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ExpanseCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $branch = Branch::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Expanse Categoris', 'List of all Expanse Categoris');
        return view('admin.expcategoris.index', compact('data','branch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ExpanseCategoris::where('deleted_at',null)->orderBy('id','asc')->get();
        $branch = Branch::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Create New Expanse Categoris', 'Create Categoris');
        return view('admin.expcategoris.create', compact('data','branch'));
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
            'categoris'  =>  'required',
            'IsActive' =>  'required'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $data = new ExpanseCategoris($collection->all());
        $data->save();

        // dd($data);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating categoris.', 'error', true, true);
        }
        else{
            return $this->responseRedirect('admin.expcategoris.index', 'Categoris added successfully' ,'success',false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExpanseCategoris  $expanseCategoris
     * @return \Illuminate\Http\Response
     */
    public function show(ExpanseCategoris $expanseCategoris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExpanseCategoris  $expanseCategoris
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {  
        $targetData = ExpanseCategoris::find($id);
        $data = ExpanseCategoris::where('deleted_at',null)->get();
        $branch = Branch::where('deleted_at',null)->orderBy('id','asc')->get();
        $this->setPageTitle('Expanse Categoris', 'Edit Expanse Categoris : '.$targetData->categoris);
        return view('admin.expcategoris.edit', compact('data', 'targetData', 'branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpanseCategoris  $expanseCategoris
     * @return \Illuminate\Http\Response
     */
    public function update(Request $params)
    {
        $this->validate($params, [
            'categoris'  =>  'required',
            'IsActive' =>  'required',
        ]);
        $data = ExpanseCategoris::find($params['id']);
        $collection = collect($params)->except('_token');
        $data->update($collection->all());
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Categoris.', 'error', true, true);
        }
        return $this->responseRedirect('admin.expcategoris.index', 'Expanse Categoris updated successfully' ,'success',false, false);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExpanseCategoris  $expanseCategoris
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $data = ExpanseCategoris::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Categoris.', 'error', true, true);
        }
        return $this->responseRedirect('admin.expcategoris.index', 'Expanse Categoris deleted successfully' ,'success',false, false);
    
    }
}
