<?php

namespace App\Http\Controllers;

use App\Models\Masters\Customer;
use App\Models\Masters\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{
    public function customer(Request $request)
    {
        $data = $this->getCustomerLedgerData($request);
        return view('panel.ledgers.customer', $data);
    }

    public function customerPrint(Request $request)
    {
        $data = $this->getCustomerLedgerData($request);
        return view('panel.ledgers.customerPrint', $data);
    }

    private function getCustomerLedgerData(Request $request): array
    {
        $customers = Customer::select('id', 'name', 'mobile')
            ->where('is_active', 1)
            ->get();

        $customerId = $request->customer_id;
        $startDate = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : null;
        $endDate = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null;

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
        return [
            'customers'      => $customers,
            'customer'       => Customer::find($customerId),
            'summary'        => $summary,
            'openingBalance' => $openingBalance,
            'records'        => $records,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
        ];
    }

    public function supplier(Request $request)
    {
        $data = $this->getSupplierLedgerData($request);
        return view('panel.ledgers.supplier', $data);
    }

    public function supplierPrint(Request $request)
    {
        $data = $this->getSupplierLedgerData($request);
        return view('panel.ledgers.supplierPrint', $data);
    }

    private function getSupplierLedgerData(Request $request): array
    {
        $suppliers = Supplier::select('id', 'name', 'mobile')
            ->where('is_active', 1)
            ->get();

        $supplierId = $request->supplier_id;
        $startDate = $request->start_date ? date('Y-m-d', strtotime($request->start_date)) : null;
        $endDate = $request->end_date ? date('Y-m-d', strtotime($request->end_date)) : null;

        $supplier = Supplier::find($supplierId);

        // Purchase Summary
        $purchaseSummary = Purchase::where('supplier_id', $supplierId)
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('invoice_date', [$startDate, $endDate]))
            ->selectRaw("
                COALESCE(SUM(total_amount),0) as total_purchase,
                COALESCE(SUM(paid_amount),0) as total_paid,
                COALESCE(SUM(due_amount),0) as total_due
            ")
            ->first();

        // Purchase Return Summary
        $returnSummary = PurchaseReturn::where('supplier_id', $supplierId)
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('invoice_date', [$startDate, $endDate]))
            ->selectRaw("
                COALESCE(SUM(total_amount),0) as total_return,
                COALESCE(SUM(refund_amount),0) as total_refund,
                COALESCE(SUM(due_amount),0) as return_due
            ")
            ->first();

        $summary = [
            'total_purchase' => $purchaseSummary->total_purchase,
            'total_paid'     => $purchaseSummary->total_paid,
            'total_due'      => $purchaseSummary->total_due,
            'total_return'   => $returnSummary->total_return,
            'total_refund'   => $returnSummary->total_refund,
            'net_due'        => $purchaseSummary->total_due - $returnSummary->return_due,
        ];

        $openingPurchase = Purchase::where('supplier_id', $supplierId)
            ->when($startDate, fn($q) => $q->where('invoice_date', '<', $startDate))
            ->sum('paid_amount');

        $openingReturn = PurchaseReturn::where('supplier_id', $supplierId)
            ->when($startDate, fn($q) => $q->where('invoice_date', '<', $startDate))
            ->sum('refund_amount');

        $openingBalance = $openingPurchase - $openingReturn;

        $purchases = Purchase::where('supplier_id', $supplierId)
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('invoice_date', [$startDate, $endDate]))
            ->select(
                'id',
                'invoice_date',
                'invoice_no',
                DB::raw("'Purchase' as type"),
                'paid_amount as debit',
                DB::raw('0 as credit'),
                'due_amount',
                'payment_status'
            );

        $purchaseReturns = PurchaseReturn::where('supplier_id', $supplierId)
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('invoice_date', [$startDate, $endDate]))
            ->select(
                'id',
                'invoice_date',
                'invoice_no',
                DB::raw("'Purchase Return' as type"),
                DB::raw('0 as debit'),
                'refund_amount as credit',
                'due_amount',
                'payment_status'
            );

        $records = $purchases
            ->unionAll($purchaseReturns)
            ->orderBy('invoice_date')
            ->get();

        return [
            'suppliers'      => $suppliers,
            'supplier'       => $supplier,
            'summary'        => $summary,
            'openingBalance' => $openingBalance,
            'records'        => $records,
            'startDate'      => $startDate,
            'endDate'        => $endDate,
        ];
    }
}
