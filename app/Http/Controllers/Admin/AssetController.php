<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class AssetController extends BaseController
{
    public function index()
    {
        $assets = collect([]);
        $this->setPageTitle('Assets', 'Manage asset projects');
        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        $this->setPageTitle('Create Asset', 'Add a new asset project');
        return view('admin.assets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'level' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sort_order' => 'nullable|integer',
            'IsActive' => 'required|in:0,1',
        ]);

        return $this->responseRedirect('admin.assets.index', 'Asset project saved successfully', 'success', false, false);
    }

    public function edit($id)
    {
        $asset = (object) [
            'id' => $id,
            'title' => 'Sample Asset',
            'level' => 'Beginner',
            'short_description' => 'Sample asset description.',
            'button_text' => 'Learn More',
            'button_url' => '#',
            'image' => null,
            'sort_order' => 0,
            'IsActive' => 1,
        ];

        $this->setPageTitle('Edit Asset', 'Update asset project');
        return view('admin.assets.edit', compact('asset'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'title' => 'required|string|max:191',
            'level' => 'nullable|string|max:100',
            'short_description' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'sort_order' => 'nullable|integer',
            'IsActive' => 'required|in:0,1',
        ]);

        return $this->responseRedirect('admin.assets.index', 'Asset project updated successfully', 'success', false, false);
    }

    public function delete($id)
    {
        return $this->responseRedirect('admin.assets.index', 'Asset project deleted successfully', 'success', false, false);
    }
}
