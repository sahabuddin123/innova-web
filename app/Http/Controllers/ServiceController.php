<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('Services', 'All Services');
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Services', 'Create Service');
        return view('admin.services.create');
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
            'title' => 'required|max:191',
            'description' => 'nullable',
            'icon' => 'nullable|max:191',
        ]);

        $params = $request->except('_token');
        $service = Service::create($params);

        if (!$service) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::findOrFail($id);
        $this->setPageTitle('Services', 'View Service');
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $this->setPageTitle('Services', 'Edit Service');
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            'description' => 'nullable',
            'icon' => 'nullable|max:191',
        ]);

        $params = $request->except('_token');
        $service = Service::findOrFail($id);
        $result = $service->update($params);

        if (!$result) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $result = $service->delete();

        if (!$result) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }
}