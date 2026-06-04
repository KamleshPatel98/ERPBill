<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $records = Category::when($request->name !== null, function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->name . '%');
        })
        ->when($request->is_active !== null, function($q) use ($request) {
            $q->where('is_active', $request->is_active);
        })
        ->paginate(getSetting('page_limit'));
        return view('panel.masters.categories.index', compact('records'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'is_active' => 'required|in:1,0'
        ]);

        Category::create($validated);
        return to_route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    { 
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'. $category->id,
            'is_active' => 'required|in:1,0'
        ]);

        $category->update($validated);
        return to_route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
