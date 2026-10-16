<?php

namespace App\Http\Controllers;

use App\Models\Masters\Category;
use App\Models\Masters\Gst;
use App\Models\Masters\Unit;
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
        $categories = Category::where('is_active', 1)->pluck('name', 'id');
        $units = Unit::where('is_active', 1)->pluck('name', 'id');
        $gsts = Gst::where('is_active', 1)->pluck('name', 'id');
        return view('panel.products.create', compact('categories', 'units', 'gsts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'hsn_code' => 'nullable|string|max:10',
            'unit_id' => 'required|exists:units,id',
            'gst_id' => 'required|exists:gsts,id',
            'price' => 'required|numeric|between:1,10000000|lte:mrp',
            'mrp' => 'nullable|numeric|between:1,10000000',
            'opening_stock' => 'nullable|numeric|between:0,10000000',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $exist = Product::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->exists();
        if($exist){
            return back()->with('error', 'Product already exists');
        }
        
        $validated['image'] = uploadFile($request->image, 'products/');
        Product::create($validated);
        return to_route('products.index')->with('success', 'Product created successfully');
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
        $categories = Category::where('is_active', 1)->pluck('name', 'id');
        $units = Unit::where('is_active', 1)->pluck('name', 'id');
        $gsts = Gst::where('is_active', 1)->pluck('name', 'id');
        return view('panel.products.create', compact('categories', 'units', 'gsts', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'gst_id' => 'required|exists:gsts,id',
            'price' => 'required|numeric|between:1,10000000|lte:mrp',
            'mrp' => 'nullable|numeric|between:1,10000000',
            'opening_stock' => 'nullable|numeric|between:0,10000000',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $exist = Product::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->where('id', '!=', $product->id)
            ->exists();
        if($exist){
            return back()->with('error', 'Product already exists');
        }

        if( ($request->hasFile('image'))){
            deleteFile($product->image, 'products/');
            $validated['image'] = uploadFile($request->image, 'products/');
        }else{
            $validated['image'] = $product->image;
        }

        $product->update($validated);
        return back()->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        deleteFile($product->image, 'products/');
        return back()->with('success', 'Product deleted successfully');
    }
}
