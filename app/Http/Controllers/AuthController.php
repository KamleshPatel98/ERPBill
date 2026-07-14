<?php

namespace App\Http\Controllers;

use App\Models\Masters\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SaleReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class AuthController extends Controller
{
    public function login()
    {
        return view('panel.auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ]);

        if($request->remember_me == '1'){
            Cache::put('remember_email', $request->email, now()->addDays(30));
        }else{ 
            Cache::forget('remember_email');
        }

        if(Auth::attempt(['email'=>$request->email, 'password' => $request->password])){
            return to_route('auth.dashboard')->with('success', 'Login successful');
        }else{
            return to_route('login')->with('error', 'Invalid password');
        }
    }

    public function dashboard()
    { 
        $sale = Sale::sum('total_amount');
        $sailPaid = Sale::sum('paid_amount');
        $purchase = Purchase::sum('total_amount');
        $purchaseDue = Purchase::sum('paid_amount');

        $products = Product::select('id','name','category_id','opening_stock')
            ->with('category:id,name')
            ->withSum('purchaseItems as purchase_qty', 'quantity')
            ->withSum('saleItems as sale_qty', 'quantity')
            ->withSum('purchaseReturnItems as purchase_return_qty', 'quantity')
            ->withSum('saleReturnItems as sale_return_qty', 'quantity')
            ->get();

        $perPage = getSetting('page_limit');
        $page = request()->get('page', 1);

        $lowStockProducts = $products
            ->map(function ($product) {
                $product->current_stock = ($product->opening_stock ?? 0)
                    + ($product->purchase_qty ?? 0)
                    + ($product->sale_return_qty ?? 0)
                    - ($product->sale_qty ?? 0)
                    - ($product->purchase_return_qty ?? 0);

                return $product;
            })
            ->where('current_stock', '<', 10)
            ->sortBy('current_stock')
            ->values();
        $lowStockCount = $lowStockProducts->count();

        $stats = [
            'totalSaleAmt' => $sale,
            'totalPurchaseAmt' => $purchase,
            'netProfit' => $sale - $purchase,
            'lowStock' => $lowStockCount,

            'customerDue' => $sale - $sailPaid,
            'purchaseDue' => $purchase - $purchaseDue,
            'saleReturn' => SaleReturn::sum('refund_amount'),
            'purchaseReturn' => PurchaseReturn::sum('refund_amount')
        ];

        $salesChart = Sale::select(
            DB::raw('MONTH(invoice_date) as month'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereYear('invoice_date', date('Y'))
        ->groupBy(DB::raw('MONTH(invoice_date)'))
        ->pluck('total', 'month')
        ->toArray();

        $purchaseChart = Purchase::select(
                DB::raw('MONTH(invoice_date) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->whereYear('invoice_date', date('Y'))
            ->groupBy(DB::raw('MONTH(invoice_date)'))
            ->pluck('total', 'month')
            ->toArray();

        $months = [];
        $salesData = [];
        $purchaseData = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $salesData[] = $salesChart[$i] ?? 0;
            $purchaseData[] = $purchaseChart[$i] ?? 0;
        }
        $graph = [
            'months' => $months,
            'sales' => $salesData,
            'purchases' => $purchaseData,
        ];


        $lowStockProducts = new LengthAwarePaginator(
            $lowStockProducts->forPage($page, $perPage),
            $lowStockProducts->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );


        $sales = Sale::query()
            ->select([
                DB::raw("'Sale' as type"),
                'sales.id',
                'sales.invoice_no',
                'sales.invoice_date',
                'sales.total_amount as amount',
                'sales.payment_status',
                'customers.name as party_name',
                'customers.mobile as party_mobile',
                'sales.created_at',
            ])
            ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
            ->latest('sales.created_at')
            ->limit(10);

        $purchases = Purchase::query()
            ->select([
                DB::raw("'Purchase' as type"),
                'purchases.id',
                'purchases.invoice_no',
                'purchases.invoice_date',
                'purchases.total_amount as amount',
                'purchases.payment_status',
                'suppliers.name as party_name',
                'suppliers.mobile as party_mobile',
                'purchases.created_at',
            ])
            ->leftJoin('suppliers', 'suppliers.id', '=', 'purchases.supplier_id')
            ->latest('purchases.created_at')
            ->limit(10);

        $transactions = DB::query()
            ->fromSub(
                $sales->unionAll($purchases),
                'transactions'
            )
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();


        return view('panel.dashboard', compact('stats', 'graph', 'lowStockProducts', 'transactions'));
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return to_route('login')->with('success', 'Logout successful');
    }
}
