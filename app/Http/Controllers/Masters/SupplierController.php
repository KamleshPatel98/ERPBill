<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\State;
use App\Models\Masters\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Supplier::when($request->search !== null, function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('mobile', 'like', '%' . $request->search . '%');
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->orderBy('id', 'desc')
            ->paginate(getSetting('page_limit'));
        return view('panel.masters.suppliers.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::where('is_active', 1)->select('id', 'name')->get();
        return view('panel.masters.suppliers.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:70',
            'mobile'    => 'required|digits:10|unique:suppliers,mobile',
            'email'     => 'nullable|email|max:70',
            'gst_no'    => 'nullable|string|max:30|unique:suppliers,gst_no',
            'address'   => 'required|string|max:255',
            'city'      => 'nullable|string|max:100',
            'state_id'  => 'nullable|exists:states,id',
            'zip' => 'nullable|numeric|digits:6',
            'is_active' => 'required|boolean',
        ]);

        Supplier::create($validated);
        return to_route('suppliers.index')
            ->with('success', 'Supplier created successfully.');
        }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $states = State::where('is_active', 1)->select('id', 'name')->get();
        return view('panel.masters.suppliers.create', compact('supplier', 'states'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'mobile'    => 'required|digits:10|unique:suppliers,mobile,'.$supplier->id,
            'email'     => 'nullable|email|max:70',
            'gst_no'    => 'nullable|string|max:30|unique:suppliers,gst_no,'.$supplier->id,
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'state_id' => 'nullable|exists:states,id',
            'zip' => 'nullable|numeric|digits:6',
            'is_active' => 'required|boolean',
        ]);

        $supplier->update($validated);
        return back()
            ->with('success', 'Supplier updated successfully.');
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier deleted successfully.');
    }
}
