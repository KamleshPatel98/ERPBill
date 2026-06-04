<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\FinancialYear;
use Illuminate\Http\Request;

class FinancialYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = FinancialYear::when($request->name !== null, function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->name . '%');
        })
        ->when($request->is_active !== null, function($q) use ($request) {
            $q->where('is_active', $request->is_active);
        })
        ->paginate(getSetting('page_limit'));
        return view('panel.masters.financial_years.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
        ]);

        FinancialYear::create($validated);
        return back()->with('success', 'Financial Year created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialYear $financialYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialYear $financialYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialYear $financialYear)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'. $financialYear->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'required|boolean',
        ]);

        $financialYear->update($validated);
        return back()->with('success', 'Financial Year updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialYear $financialYear)
    {
        //
    }
}
