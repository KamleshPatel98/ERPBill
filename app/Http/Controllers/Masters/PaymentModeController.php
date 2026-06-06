<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\PaymentMode;
use Illuminate\Http\Request;

class PaymentModeController extends Controller
{
    /**
     * Listing
     */
    public function index(Request $request)
    {
        $records = PaymentMode::when($request->name, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->is_active !== null, function ($q) use ($request) {
                $q->where('is_active', $request->is_active);
            })
            ->orderBy('name')
            ->paginate(getSetting('page_limit'));
        return view('panel.masters.payment-modes.index', compact('records'));
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_modes,name',
            'is_active' => 'required|in:1,0',
        ]);

        PaymentMode::create($validated);
        return back()->with('success', 'Payment mode created successfully.');
    }

    /**
     * Update
     */
    public function update(Request $request, PaymentMode $paymentMode)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_modes,name,' . $paymentMode->id,
            'is_active' => 'required|in:1,0',
        ]);

        $paymentMode->update($validated);
        return back()->with('success', 'Payment mode updated successfully.');
    }
}