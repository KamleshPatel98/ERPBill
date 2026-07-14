<?php

namespace App\Http\Controllers;

use App\Models\Masters\Customer;
use App\Models\Masters\FinancialYear;
use App\Models\Masters\Gst;
use App\Models\Masters\PaymentMode;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Sale::with([
            'customer:id,name,mobile',
            'paymentMode:id,name',
            'financialYear:id,name',
            'saleItems',
            'saleItems.product:id,name',
            'saleItems.gst:id,name'
        ])
        ->when($request->customer_id !== null, function($q) use ($request){
            $q->where('customer_id', $request->customer_id);
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

        $customers = Customer::select('name', 'id', 'mobile')->get();
        return view('panel.sales.index', compact('records', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::select('name', 'id', 'mobile')->where('is_active', 1)->get();
        $paymentModes = PaymentMode::select('name', 'id')->where('is_active', 1)->get();
        $financialYears = FinancialYear::select('name', 'id')->where('is_active', 1)->get();
        $products = Product::select('name', 'id')->where('is_active', 1)->get();
        $gsts = Gst::select('name', 'rate', 'id')->where('is_active', 1)->get();
        return view('panel.sales.create', compact('customers', 'paymentModes', 'financialYears', 'products', 'gsts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_no' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'financial_year_id' => 'required|exists:financial_years,id',
            'payment_mode_id' => 'nullable|exists:payment_modes,id',
            'paid_amount' => 'required|numeric|between:0,10000000',
            'discount_amount' => 'nullable|numeric|between:0,10000000',
            'notes' => 'nullable|string|max:1000',

            'customer_type' => 'required|in:new,existing',
            'customer_id' => 'nullable|required_if:customer_type,existing|exists:customers,id',
            'name' => 'nullable|required_if:customer_type,new|string|max:70',
            'mobile' => 'nullable|required_if:customer_type,new|numeric|digits:10|unique:customers,mobile',
            'address' => 'nullable|required_if:customer_type,new|string|max:1000',

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
            if($request->customer_type == 'new'){
                $customer = Customer::create([
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                ]);
                $customer_id = $customer->id;
            }else{
                $customer_id = $request->customer_id;
            }

            $sale = Sale::create([
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'customer_id' => $customer_id,
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

                SaleItem::create([
                    'sale_id' => $sale->id,
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

            $sale->update([
                'grand_amount'    => $grossAmount,
                'gst_amount'      => $gstAmountTotal,
                'discount_amount' => $discountAmountTotal,
                'total_amount'    => $totalAmount,
                'paid_amount'     => $paidAmount,
                'due_amount'      => $dueAmount,
                'payment_status'  => $paymentStatus,
            ]);

            return to_route('sales.index')->with('success', 'Sale created successfully');
        } catch (\Exception $ex) {
            Log::error("Sale create error: ",[
                'ex' => $ex->getMessage(),
                'line' => __LINE__,
            ]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $customers = Customer::select('name', 'id', 'mobile')->where('is_active', 1)->get();
        $paymentModes = PaymentMode::select('name', 'id')->where('is_active', 1)->get();
        $financialYears = FinancialYear::select('name', 'id')->where('is_active', 1)->get();
        $products = Product::select('name', 'id')->where('is_active', 1)->get();
        $gsts = Gst::select('name', 'rate', 'id')->where('is_active', 1)->get();
        $items = SaleItem::with(['product:id,name', 'gst:id,name'])
            ->where('sale_id', $sale->id)->get();
        return view('panel.sales.create', compact('customers', 'paymentModes', 'financialYears', 'products', 'gsts','sale', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'invoice_no' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
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
            $sale->update([
                'invoice_no' => $request->invoice_no,
                'invoice_date' => $request->invoice_date,
                'customer_id' => $request->customer_id,
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
            SaleItem::where('sale_id', $sale->id)->delete();

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

                SaleItem::create([
                    'sale_id' => $sale->id,
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

            $sale->update([
                'grand_amount'    => $grossAmount,
                'gst_amount'      => $gstAmountTotal,
                'discount_amount' => $discountAmountTotal,
                'total_amount'    => $totalAmount,
                'paid_amount'     => $paidAmount,
                'due_amount'      => $dueAmount,
                'payment_status'  => $paymentStatus,
            ]);

            return to_route('sales.index')->with('success', 'Sale updated successfully');
        } catch (\Exception $ex) {
            Log::error("Sale update error: ",[
                'ex' => $ex->getMessage(),
                'line' => __LINE__,
            ]);
            return back()->with('error', 'Something went wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return back()->with('success', 'Sale deleted successfully');
    }

    public function invoice($id)
    {
        $sale = Sale::with([
            'customer:id,name,mobile',
            'paymentMode:id,name',
            'financialYear:id,name',
            'saleItems',
            'saleItems.product:id,name',
            'saleItems.gst:id,name'
        ])
        ->findOrFail($id);
        return view('panel.pdfs.sale-invoice', compact('sale'));
    }
}
