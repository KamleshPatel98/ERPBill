<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Gst;
use Illuminate\Http\Request;

class GstController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $records = Gst::when($request->name !== null, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->orderBy('rate')
            ->paginate(getSetting('page_limit'));
        return view('panel.masters.gsts.index', compact('records'));
    }

    /**
     * Store GST
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30|unique:gsts,name',
            'rate' => 'required|numeric|min:0|max:100',
            'is_active' => 'required|in:1,0',
        ]);

        Gst::create($validated);
        return back()->with('success', 'GST created successfully.');
    }

    /**
     * Update GST
     */
    public function update(Request $request, Gst $gst)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30|unique:gsts,name,' . $gst->id,
            'rate' => 'required|numeric|min:0|max:100',
            'is_active' => 'required|in:1,0',
        ]);

        $gst->update($validated);
        return back()->with('success', 'GST updated successfully.');
    }

    /**
     * Delete GST
     */
    public function destroy(Gst $gst)
    {
        $gst->delete();
        return back()->with('success', 'GST deleted successfully.');
    }
}