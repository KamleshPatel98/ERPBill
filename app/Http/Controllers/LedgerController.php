<?php

namespace App\Http\Controllers;

use App\Models\Masters\Customer;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    public function customer(Request $request)
    {
        $customers = Customer::select('id','name','mobile')
            ->where('is_active', 1)
            ->get();

        $customerId = $request->customer_id;
        $startDate = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : '';
        $endDate = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : '';

        // Sale Summary
        $saleSummary = Sale::where('customer_id', $customerId)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('invoice_date', [$startDate, $endDate]);
            })
            ->selectRaw("
                COALESCE(SUM(total_amount),0) as total_sale,
                COALESCE(SUM(paid_amount),0) as total_received,
                COALESCE(SUM(due_amount),0) as total_due
            ")
            ->first();

        // Sale Return Summary
        $returnSummary = SaleReturn::where('customer_id', $customerId)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('invoice_date', [$startDate, $endDate]);
            })
            ->selectRaw("
                COALESCE(SUM(total_amount),0) as total_return,
                COALESCE(SUM(refund_amount),0) as total_refund,
                COALESCE(SUM(due_amount),0) as return_due
            ")
            ->first();

        $totalSale     = $saleSummary->total_sale;
        $totalReceived = $saleSummary->total_received;
        $totalDue      = $saleSummary->total_due;

        $totalReturn   = $returnSummary->total_return;
        $totalRefund   = $returnSummary->total_refund;
        $returnDue     = $returnSummary->return_due;

        // Net Due
        $netDue = $totalDue - $returnDue;
        $summary = [
            'total_sale'      => $totalSale,
            'total_received'  => $totalReceived,
            'total_due'       => $totalDue,
            'total_return'    => $totalReturn,
            'total_refund'    => $totalRefund,
            'net_due'         => $netDue,
        ];


        $openingSale = Sale::where('customer_id', $customerId)
            ->when($startDate, fn ($q) => $q->where('invoice_date', '<', $startDate))
            ->sum('paid_amount');

        $openingReturn = SaleReturn::where('customer_id', $customerId)
            ->when($startDate, fn ($q) => $q->where('invoice_date', '<', $startDate))
            ->sum('refund_amount');

        $openingBalance = $openingSale - $openingReturn;


        $sales = Sale::where('customer_id', $customerId)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('invoice_date', [$startDate, $endDate]);
            })
            ->select(
                'id',
                'invoice_date',
                'invoice_no',
                DB::raw("'Sale' as type"),
                DB::raw('0 as debit'),
                'paid_amount as credit',
                'due_amount',
                'payment_status'
            );

        $saleReturns = SaleReturn::where('customer_id', $customerId)
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('invoice_date', [$startDate, $endDate]);
            })
            ->select(
                'id',
                'invoice_date',
                'invoice_no',
                DB::raw("'Sale Return' as type"),
                'refund_amount as debit',
                DB::raw('0 as credit'),
                'due_amount',
                'payment_status'
            );

        $records = $sales
            ->unionAll($saleReturns)
            ->orderBy('invoice_date')
            ->get();

        return view('panel.ledgers.customer', compact('customers', 'summary', 'openingBalance', 'records'));
    }
}
