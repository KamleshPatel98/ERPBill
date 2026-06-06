<?php

namespace App\Http\Controllers;

use App\Models\Masters\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Product::with(['category:id,name', 'unit:id,name', 'gst:id,name'])
            ->when($request->name !== null, function($q) use ($request){
                $q->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->category_id !== null, function($q) use ($request){
                $q->where('category_id', $request->category_id);
            })
            ->when($request->is_active !== null, function($q) use ($request){
                $q->where('is_active', $request->is_active);
            })
            ->latest()
            ->paginate(getSetting('page_limit'))
            ->withQueryString();
        $categories = Category::pluck('name', 'id');
        return view('panel.products.index', compact('records', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
