<?php

namespace App\Http\Controllers;

use App\Models\Masters\Customer;
use App\Models\Masters\Supplier;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sale(Request $request)
    {
        extract($this->getSaleReport($request));

        $customers = Customer::select('id', 'name', 'mobile')->get();

        return view('panel.reports.sale', compact(
            'records',
            'stats',
            'customers'
        ));
    }

    public function salePrint(Request $request)
    {
        extract($this->getSaleReport($request));

        return view('panel.reports.sale-print', compact(
            'records',
            'stats'
        ));
    }

    private function getSaleReport(Request $request)
    {
        $query = Sale::with(['customer:id,name,mobile', 'saleItems.product', 'paymentMode:id,name']);

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('invoice_date', [
                date('Y-m-d', strtotime($request->from_date)),
                date('Y-m-d', strtotime($request->to_date))
            ]);
        }

        $records = $query->orderBy('invoice_date')->get();

        $stats = [
            'total_sales'   => $records->count(),
            'total_amount'  => $records->sum('total_amount'),
            'paid_amount'   => $records->sum('paid_amount'),
            'due_amount'    => $records->sum('due_amount'),
        ];

        return compact('records', 'stats');
    }

    public function purchase(Request $request)
    {
        extract($this->getPurchaseReport($request));

        $suppliers = Supplier::select('id', 'name', 'mobile')->get();

        return view('panel.reports.purchase', compact(
            'records',
            'stats',
            'suppliers'
        ));
    }

    public function purchasePrint(Request $request)
    {
        extract($this->getPurchaseReport($request));

        return view('panel.reports.purchase-print', compact(
            'records',
            'stats'
        ));
    }

    private function getPurchaseReport(Request $request)
    {
        $query = Purchase::with([
            'supplier:id,name,mobile',
            'purchaseItems.product',
            'paymentMode:id,name'
        ]);

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('invoice_date', [
                date('Y-m-d', strtotime($request->from_date)),
                date('Y-m-d', strtotime($request->to_date))
            ]);
        }

        $records = $query->orderBy('invoice_date')->get();

        $stats = [
            'total_purchase' => $records->count(),
            'total_amount'   => $records->sum('total_amount'),
            'paid_amount'  => $records->sum('paid_amount'),
            'due_amount'     => $records->sum('due_amount'),
        ];

        return compact('records', 'stats');
    }
}
