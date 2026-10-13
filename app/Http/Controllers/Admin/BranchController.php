<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Http\Controllers\BaseController;

class BranchController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Branchs', 'List of all Branch');
        return view('admin.branchs.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Create New Branch', 'Create Branch');
        return view('admin.branchs.create', compact('data'));
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
            'bname'  =>  'required',
            'startdate'  =>  'required',
            'btype'  =>  'required',
            'IsActive' =>  'required'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $data = new Branch($collection->all());
        $data->save();

        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating brachs.', 'error', true, true);
        } else {
            return $this->responseRedirect('admin.branch.index', 'Branch added successfully', 'success', false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $Branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = Branch::find($id);
        $data = Branch::where('deleted_at', null)->get();
        $this->setPageTitle('Branchs', 'Edit Branchs : ' . $targetData->bname);
        return view('admin.branchs.edit', compact('data', 'targetData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $params)
    {
        $this->validate($params, [
            'bname'  =>  'required',
            'startdate'  =>  'required',
            'btype'  =>  'required',
            'IsActive' =>  'required',
        ]);
        $data = Branch::find($params['id']);
        $collection = collect($params)->except('_token');
        $data->update($collection->all());
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Branch.', 'error', true, true);
        }
        return $this->responseRedirect('admin.branch.index', 'Branch updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $Branch
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $data = Branch::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Branch.', 'error', true, true);
        }
        return $this->responseRedirect('admin.expcategoris.index', 'Branch deleted successfully', 'success', false, false);
    }
}
