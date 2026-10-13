<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::orderBy('order')->get();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio_bn' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teams', 'public');
        }

        Team::create($data);

        return redirect()->route('admin.teams.index')->with('success', 'টিম সদস্য সফলভাবে যোগ করা হয়েছে!');
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio_bn' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teams', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.teams.index')->with('success', 'টিম সদস্য সফলভাবে আপডেট করা হয়েছে!');
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'টিম সদস্য সফলভাবে মুছে ফেলা হয়েছে!');
    }
}
