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

        $products = Product::query()
            ->withSum('purchaseItems as purchase_qty', 'quantity')
            ->withSum('saleItems as sale_qty', 'quantity')
            ->withSum('purchaseReturnItems as purchase_return_qty', 'quantity')
            ->withSum('saleReturnItems as sale_return_qty', 'quantity')
            ->get();
        $lowStockProducts = $products->filter(function ($product) {
            $stock = ($product->opening_stock ?? 0)
                + ($product->purchase_qty ?? 0)
                + ($product->sale_return_qty ?? 0)
                - ($product->sale_qty ?? 0)
                - ($product->purchase_return_qty ?? 0);
            $product->current_stock = $stock;
            return $stock < 500;
        });

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
        return view('panel.dashboard', compact('stats'));
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return to_route('login')->with('success', 'Logout successful');
    }
}
