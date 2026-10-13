<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Branch;
use App\Models\IncomeCategoris;


class IncomeCategorisController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = IncomeCategoris::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $branch = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Income Categoris', 'List of all Income Categoris');
        return view('admin.inccategoris.index', compact('data', 'branch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = IncomeCategoris::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $branch = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Create New Income Categoris', 'Create Categoris');
        return view('admin.inccategoris.create', compact('data', 'branch'));
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
        $data = new IncomeCategoris($collection->all());
        $data->save();

        // dd($data);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating categoris.', 'error', true, true);
        } else {
            return $this->responseRedirect('admin.inccategoris.index', 'Categoris added successfully', 'success', false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IncomeCategoris  $incomeCategoris
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeCategoris $incomeCategoris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IncomeCategoris  $IncomeCategoris
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $targetData = IncomeCategoris::find($id);
        $data = IncomeCategoris::where('deleted_at', null)->get();
        $branch = Branch::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Income Categoris', 'Edit Income Categoris : ' . $targetData->categoris);
        return view('admin.inccategoris.edit', compact('data', 'targetData', 'branch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IncomeCategoris  $IncomeCategoris
     * @return \Illuminate\Http\Response
     */
    public function update(Request $params)
    {
        $this->validate($params, [
            'categoris'  =>  'required',
            'IsActive' =>  'required',
        ]);
        $data = IncomeCategoris::find($params['id']);
        $collection = collect($params)->except('_token');
        $data->update($collection->all());
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Categoris.', 'error', true, true);
        }
        return $this->responseRedirect('admin.inccategoris.index', 'Income Categoris updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IncomeCategoris  $IncomeCategoris
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $data = IncomeCategoris::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Categoris.', 'error', true, true);
        }
        return $this->responseRedirect('admin.inccategoris.index', 'Income Categoris deleted successfully', 'success', false, false);
    }
}
