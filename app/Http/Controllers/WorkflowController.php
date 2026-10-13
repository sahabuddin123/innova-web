<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('Workflows', 'All Workflows');
        $workflows = Workflow::latest()->paginate(10);
        return view('admin.workflows.index', compact('workflows'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('Workflows', 'Create Workflow');
        return view('admin.workflows.create');
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
            'step' => 'required|integer|min:1',
            'icon' => 'nullable|max:191',
        ]);

        $params = $request->except('_token');
        $workflow = Workflow::create($params);

        if (!$workflow) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.workflows.index')->with('success', 'Workflow created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $workflow = Workflow::findOrFail($id);
        $this->setPageTitle('Workflows', 'View Workflow');
        return view('admin.workflows.show', compact('workflow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workflow = Workflow::findOrFail($id);
        $this->setPageTitle('Workflows', 'Edit Workflow');
        return view('admin.workflows.edit', compact('workflow'));
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
            'step' => 'required|integer|min:1',
            'icon' => 'nullable|max:191',
        ]);

        $params = $request->except('_token');
        $workflow = Workflow::findOrFail($id);
        $result = $workflow->update($params);

        if (!$result) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.workflows.index')->with('success', 'Workflow updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $workflow = Workflow::findOrFail($id);
        $result = $workflow->delete();

        if (!$result) {
            return $this->responseJson(false, 200, 'Something went wrong. Please try again.');
        }

        return redirect()->route('admin.workflows.index')->with('success', 'Workflow deleted successfully.');
    }
}