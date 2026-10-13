<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Seminor;
use App\Models\SeminorRegistration;

class SeminorRegistrationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SeminorRegistration::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $seminor = Seminor::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Seminor Registration', 'List of all Students');
        return view('admin.seminorreg.index', compact('data', 'seminor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = SeminorRegistration::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $seminor = Seminor::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Create New Registration', 'Create Registration');
        return view('admin.seminorreg.create', compact('data', 'seminor'));
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
            'username'  =>  'required',
            'IsActive' =>  'required'
        ]);

        $params = $request->except('_token');
        $collection = collect($params);
        $data = new SeminorRegistration($collection->all());
        $data->save();

        // dd($data);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while creating Registraton.', 'error', true, true);
        } else {
            return $this->responseRedirect('admin.seminorreg.index', 'Registraton added successfully', 'success', false, false);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SeminorRegistration  $incomeCategoris
     * @return \Illuminate\Http\Response
     */
    public function show(SeminorRegistration $incomeCategoris)
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
        $targetData = SeminorRegistration::find($id);
        $data = SeminorRegistration::where('deleted_at', null)->get();
        $seminor = Seminor::where('deleted_at', null)->orderBy('id', 'asc')->get();
        $this->setPageTitle('Seminor Registration', 'Edit Seminor Registration : ' . $targetData->username);
        return view('admin.seminorreg.edit', compact('data', 'targetData', 'seminor'));
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
           'username'  =>  'required',
            'IsActive' =>  'required'
        ]);
        $data = SeminorRegistration::find($params['id']);
        $collection = collect($params)->except('_token');
        $data->update($collection->all());
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while updating Seminor Registration.', 'error', true, true);
        }
        return $this->responseRedirect('admin.seminorreg.index', 'Seminor Registration updated successfully', 'success', false, false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SeminorRegistration  $IncomeCategoris
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $date = date('y-m-d h:i:s');
        $data = SeminorRegistration::where('id', $id)->update(['deleted_at' => $date]);
        if (!$data) {
            return $this->responseRedirectBack('Error occurred while deleting Seminor Registration.', 'error', true, true);
        }
        return $this->responseRedirect('admin.seminorreg.index', 'Seminor Registration deleted successfully', 'success', false, false);
    }
}
