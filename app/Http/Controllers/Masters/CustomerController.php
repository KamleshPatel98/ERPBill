<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Listing
     */
    public function index(Request $request)
    {
        $records = Customer::when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('mobile', 'like', '%' . $request->search . '%')
                        ->orWhere('address', 'like', '%' . $request->search . '%');
                });
            })
            ->when(!empty($request->is_active), function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->orderBy('id', 'desc')
            ->paginate(getSetting('page_limit'))
            ->withQueryString();

        return view('panel.masters.customers.index', compact('records'));
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'mobile' => 'required|digits:10|unique:customers,mobile',
            'address' => 'required|string',
            'is_active' => 'required|in:1,0',
        ]);

        Customer::create($validated);
        return back()->with('success', 'Customer created successfully.');
    }

    /**
     * Update
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:70',
            'mobile' => 'required|digits:10|unique:customers,mobile,' . $customer->id,
            'address' => 'required|string',
            'is_active' => 'required|in:1,0',
        ]);

        $customer->update($validated);
        return back()->with('success', 'Customer updated successfully.');
    }

    /**
     * Delete
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success', 'Customer deleted successfully.');
    }
}