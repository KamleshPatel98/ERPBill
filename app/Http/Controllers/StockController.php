<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function currentStock()
    {
        $products = $this->stockQuery();
        return view('panel.stocks.current-stock', compact('products'));
    }

    public function lowStock()
    {
        $products = $this->stockQuery()
            ->where('current_stock', '<', 10)
            ->sortBy('current_stock')
            ->values();
        return view('panel.stocks.low-stock', compact('products'));
    }

    private function stockQuery()
    {
        return Product::select('id', 'name', 'category_id', 'opening_stock')
            ->with('category:id,name')
            ->withSum('purchaseItems as purchase_qty', 'quantity')
            ->withSum('saleItems as sale_qty', 'quantity')
            ->withSum('purchaseReturnItems as purchase_return_qty', 'quantity')
            ->withSum('saleReturnItems as sale_return_qty', 'quantity')
            ->get()
            ->map(function ($product) {

                $product->current_stock = ($product->opening_stock ?? 0)
                    + ($product->purchase_qty ?? 0)
                    + ($product->sale_return_qty ?? 0)
                    - ($product->sale_qty ?? 0)
                    - ($product->purchase_return_qty ?? 0);

                return $product;
            });
    }
}
