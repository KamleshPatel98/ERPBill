<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Listing
     */
    public function index(Request $request)
    {
        $records = State::when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->orderBy('name')
            ->paginate(getSetting('page_limit'));
        return view('panel.masters.states.index', compact('records'));
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:states,name',
            'code' => 'required|string|max:10|unique:states,code',
            'is_active' => 'required|in:1,0',
        ]);

        State::create($validated);
        return back()->with('success', 'State created successfully.');
    }

    /**
     * Update
     */
    public function update(Request $request, State $state)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:states,name,' . $state->id,
            'code' => 'required|string|max:10|unique:states,code,' . $state->id,
            'is_active' => 'required|in:1,0',
        ]);

        $state->update($validated);
        return back()->with('success', 'State updated successfully.');
    }

    /**
     * Delete
     */
    public function destroy(State $state)
    {
        $state->delete();
        return back()->with('success', 'State deleted successfully.');
    }
}