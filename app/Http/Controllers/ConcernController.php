<?php

namespace App\Http\Controllers;

use App\Models\Concern;
use Illuminate\Http\Request;

class ConcernController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('Concerns', 'All Concerns');
        $concerns = Concern::latest()->paginate(10);
        return view('admin.concerns.index', compact('concerns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Concerns', 'Create Concern');
        return view('admin.concerns.create');
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
        $concern = Concern::create($params);

        if (!$concern) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.concerns.index')->with('success', 'Concern created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $concern = Concern::findOrFail($id);
        $this->setPageTitle('Concerns', 'View Concern');
        return view('admin.concerns.show', compact('concern'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $concern = Concern::findOrFail($id);
        $this->setPageTitle('Concerns', 'Edit Concern');
        return view('admin.concerns.edit', compact('concern'));
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
        $concern = Concern::findOrFail($id);
        $result = $concern->update($params);

        if (!$result) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.concerns.index')->with('success', 'Concern updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $concern = Concern::findOrFail($id);
        $result = $concern->delete();

        if (!$result) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.concerns.index')->with('success', 'Concern deleted successfully.');
    }
}