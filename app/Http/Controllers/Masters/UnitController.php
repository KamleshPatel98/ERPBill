<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $records = Unit::when($request->search !== null, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('short_name', 'like', '%' . $request->search . '%');
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->paginate(getSetting('page_limit'));

        return view('panel.masters.units.index', compact('records'));
    }

    /**
     * Store new unit
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
            'short_name' => 'required|string|max:20|unique:units,short_name',
            'is_active' => 'required|in:1,0',
        ]);

        Unit::create($validated);
        return back()->with('success', 'Unit created successfully.');
    }

    /**
     * Update unit
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $unit->id,
            'short_name' => 'required|string|max:20|unique:units,short_name,' . $unit->id,
            'is_active' => 'required|in:1,0',
        ]);

        $unit->update($validated);
        return back()->with('success', 'Unit updated successfully.');
    }

    /**
     * Delete unit
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return back()->with('success', 'Unit deleted successfully.');
    }
}