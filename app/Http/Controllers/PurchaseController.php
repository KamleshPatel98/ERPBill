<?php

namespace App\Http\Controllers;

use App\Models\Masters\FinancialYear;
use App\Models\Masters\Gst;
use App\Models\Masters\PaymentMode;
use App\Models\Masters\Supplier;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Purchase::with([
            'supplier:id,name,mobile',
            'paymentMode:id,name',
            'financialYear:id,name',
            'purchaseItems',
            'purchaseItems.product:id,name',
            'purchaseItems.gst:id,name'
        ])
        ->when($request->supplier_id !== null, function($q) use ($request){
            $q->where('supplier_id', $request->supplier_id);
        })
        ->when($request->invoice_no !== null, function($q) use ($request){
            $q->where('invoice_no', $request->invoice_no);
        })
        ->when($request->payment_status !== null, function($q) use ($request){
            $q->where('payment_status', $request->payment_status);
        })
        ->latest()
        ->paginate(getSetting('page_limit'))
        ->withQueryString();
        $suppliers = Supplier::select('name', 'id', 'mobile')->get();
        return view('panel.purchases.index', compact('records', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::select('name', 'id', 'mobile')->where('is_active', 1)->get();
        $paymentModes = PaymentMode::select('name', 'id')->where('is_active', 1)->get();
        $financialYears = FinancialYear::select('name', 'id')->where('is_active', 1)->get();
        $products = Product::select('name', 'id')->where('is_active', 1)->get();
        $gsts = Gst::select('name', 'rate', 'id')->where('is_active', 1)->get();
        return view('panel.purchases.create', compact('suppliers', 'paymentModes', 'financialYears', 'products', 'gsts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $request->validate([
            'invoice_no' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'financial_year_id' => 'required|exists:financial_years,id',
            'payment_mode_id' => 'nullable|exists:payment_modes,id',
            'paid_amount' => 'required|numeric|between:0,10000000',
            'discount_amount' => 'nullable|numeric|between:0,10000000',
            'notes' => 'nullable|string|max:1000',

            'items_json' => 'required|json|min:1',
            'items_json.*.product_id' => 'required|exists:products,id',
            'items_json.*.qty' => 'required|numeric|min:1',
            'items_json.*.rate' => 'required|numeric|min:0.01',
            'items_json.*.gst_id'        => 'required|numeric|min:0|max:100',
            'items_json.*.gst_percentage' => 'required|numeric|min:0|max:100',
            'items_json.*.discount'   => 'nullable|numeric|min:0',
            'items_json.*.amount'     => 'required|numeric|min:0.01',
        ]);

        try {
            $purchase = Purchase::create([
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'supplier_id' => $request->supplier_id,
                'financial_year_id' => $request->financial_year_id,
                'payment_mode_id' => $request->payment_mode_id,
                'paid_amount' => $request->paid_amount,
                'notes' => $request->notes,
            ]);

            $grossAmount = 0;
            $gstAmountTotal = 0;
            $discountAmountTotal = 0;
            $totalAmount = 0;

            $items = json_decode($request->items_json);
            if (empty($items)) {
                return back()->with('error', 'At least one item is required.');
            }

            foreach($items as $item){
                $subTotal = $item->qty * $item->rate; //gross
                $netAmount = $subTotal - $item->discount; //discount
                $gstAmount = ($netAmount * $item->gst_percentage) / 100; //gst
                $amount = $netAmount + $gstAmount; //net

                // Summary Totals
                $grossAmount += $subTotal;
                $discountAmountTotal += $item->discount;
                $gstAmountTotal += $gstAmount;
                $totalAmount += $amount;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->product_id,
                    'price' => $item->rate,
                    'quantity' => $item->qty,
                    'sub_total' => $subTotal,
                    'discount' => $item->discount,
                    'gst_id' => $item->gst_id,
                    'gst_rate' => $item->gst_percentage,
                    'gst_amount' => $gstAmount,
                    'total' => $amount,
                ]);
            }

            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $totalAmount - $paidAmount;
            if ($paidAmount <= 0) {
                $paymentStatus = 'pending';
            } elseif ($dueAmount <= 0) {
                $paymentStatus = 'paid';
            } else {
                $paymentStatus = 'partially';
            }

            $purchase->update([
                'grand_amount'    => $grossAmount,
                'gst_amount'      => $gstAmountTotal,
                'discount_amount' => $discountAmountTotal,
                'total_amount'    => $totalAmount,
                'paid_amount'     => $paidAmount,
                'due_amount'      => $dueAmount,
                'payment_status'  => $paymentStatus,
            ]);

            return to_route('purchases.index')->with('success', 'Purchase created successfully');
        } catch (\Exception $ex) {
            Log::error("Purchase create error: ",[
                'ex' => $ex->getMessage(),
                'line' => __LINE__,
            ]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $suppliers = Supplier::select('name', 'id', 'mobile')->where('is_active', 1)->get();
        $paymentModes = PaymentMode::select('name', 'id')->where('is_active', 1)->get();
        $financialYears = FinancialYear::select('name', 'id')->where('is_active', 1)->get();
        $products = Product::select('name', 'id')->where('is_active', 1)->get();
        $gsts = Gst::select('name', 'rate', 'id')->where('is_active', 1)->get();
        $items = PurchaseItem::with(['product:id,name', 'gst:id,name'])
            ->where('purchase_id', $purchase->id)->get();
        return view('panel.purchases.create', compact('suppliers', 'paymentModes', 'financialYears', 'products', 'gsts','purchase', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'invoice_no' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'financial_year_id' => 'required|exists:financial_years,id',
            'payment_mode_id' => 'nullable|exists:payment_modes,id',
            'paid_amount' => 'required|numeric|between:0,10000000',
            'discount_amount' => 'nullable|numeric|between:0,10000000',
            'notes' => 'nullable|string|max:1000',

            'items_json' => 'required|json|min:1',
            'items_json.*.product_id' => 'required|exists:products,id',
            'items_json.*.qty' => 'required|numeric|min:1',
            'items_json.*.rate' => 'required|numeric|min:0.01',
            'items_json.*.gst_id'        => 'required|numeric|min:0|max:100',
            'items_json.*.gst_percentage' => 'required|numeric|min:0|max:100',
            'items_json.*.discount'   => 'nullable|numeric|min:0',
            'items_json.*.amount'     => 'required|numeric|min:0.01',
        ]);

        try {
            $purchase->update([
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'supplier_id' => $request->supplier_id,
                'financial_year_id' => $request->financial_year_id,
                'payment_mode_id' => $request->payment_mode_id,
                'paid_amount' => $request->paid_amount,
                'notes' => $request->notes,
            ]);

            $grossAmount = 0;
            $gstAmountTotal = 0;
            $discountAmountTotal = 0;
            $totalAmount = 0;

            // old items delete
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            $items = json_decode($request->items_json);
            if (empty($items)) {
                return back()->with('error', 'At least one item is required.');
            }
            
            foreach($items as $item){
                $subTotal = $item->qty * $item->rate; //gross
                $netAmount = $subTotal - $item->discount; //discount
                $gstAmount = ($netAmount * $item->gst_percentage) / 100; //gst
                $amount = $netAmount + $gstAmount; //net

                // Summary Totals
                $grossAmount += $subTotal;
                $discountAmountTotal += $item->discount;
                $gstAmountTotal += $gstAmount;
                $totalAmount += $amount;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->product_id,
                    'price' => $item->rate,
                    'quantity' => $item->qty,
                    'sub_total' => $subTotal,
                    'discount' => $item->discount,
                    'gst_id' => $item->gst_id,
                    'gst_rate' => $item->gst_percentage,
                    'gst_amount' => $gstAmount,
                    'total' => $amount,
                ]);
            }

            $paidAmount = $request->paid_amount ?? 0;
            $dueAmount = $totalAmount - $paidAmount;
            if ($paidAmount <= 0) {
                $paymentStatus = 'pending';
            } elseif ($dueAmount <= 0) {
                $paymentStatus = 'paid';
            } else {
                $paymentStatus = 'partially';
            }

            $purchase->update([
                'grand_amount'    => $grossAmount,
                'gst_amount'      => $gstAmountTotal,
                'discount_amount' => $discountAmountTotal,
                'total_amount'    => $totalAmount,
                'paid_amount'     => $paidAmount,
                'due_amount'      => $dueAmount,
                'payment_status'  => $paymentStatus,
            ]);

            return to_route('purchases.index')->with('success', 'Purchase updated successfully');
        } catch (\Exception $ex) {
            Log::error("Purchase update error: ",[
                'ex' => $ex->getMessage(),
                'line' => __LINE__,
            ]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return back()->with('success', 'Purchase deleted successfully');
    }
}
