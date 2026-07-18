<?php

namespace App\Http\Controllers;

use App\Models\Masters\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function sale(Request $request)
    {
        $records = Sale::where('customer_id', $request->customer_id)
            ->whereBetween('invoice_date', [date('Y-m-d', strtotime($request->from_date)), date('Y-m-d', strtotime($request->to_date))])
            ->get();
        $stats = [
            'total_sales'   => $records->count(),
            'total_amount'  => $records->sum('total_amount'),
            'paid_amount'   => $records->sum('paid_amount'),
            'due_amount'    => $records->sum('due_amount'),
        ];

        $customers = Customer::select('name', 'id', 'mobile')->get();
        return view('panel.reports.sale', compact('records', 'customers', 'stats'));
    }
}
