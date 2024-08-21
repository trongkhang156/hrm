<?php

// app/Http/Controllers/WorktypeController.php

namespace App\Http\Controllers;

use App\Models\Worktype;
use Illuminate\Http\Request;

class WorktypeController extends Controller
{
    public function index()
    {
        $worktypes = Worktype::where('is_delete', false)->get();
        return view('admin.worktypes.index', compact('worktypes'));
    }

    public function create()
    {
        $parents = Worktype::where('is_delete', false)->get();
        return view('admin.worktypes.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:N,P',
            'max' => 'required|integer',
            'parent_id' => 'nullable|exists:worktypes,id',
        ]);

        Worktype::create($request->all());
        return redirect()->route('worktypes.index')->with('success', 'Worktype created successfully.');
    }

    public function edit(Worktype $worktype)
    {
        $parents = Worktype::where('is_delete', false)->get();
        return view('admin.worktypes.edit', compact('worktype', 'parents'));
    }

    public function update(Request $request, Worktype $worktype)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:N,P',
            'max' => 'required|integer',
            'parent_id' => 'nullable|exists:worktypes,id',
        ]);

        $worktype->update($request->all());
        return redirect()->route('worktypes.index')->with('success', 'Worktype updated successfully.');
    }

    public function destroy(Worktype $worktype)
    {
        $worktype->update(['is_delete' => true]);
        return redirect()->route('worktypes.index')->with('success', 'Worktype deleted successfully.');
    }
}

