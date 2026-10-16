@extends('layouts.panel')

@section('title', 'Add / Edit Product')

@section('content')

    <!-- PAGE HEADER -->
    <div class="card page-card mb-3">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <h4 class="page-title">
                        @if(isset($product))
                            Edit Product
                        @else
                            Add New Product
                        @endif
                    </h4>

                    <p class="page-subtitle">
                        Fertilizer, Pesticide & Seed entry form
                    </p>

                </div>

                <div class="col-lg-6 text-end">

                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>
                        Back to List
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- FORM CARD -->
    <div class="card table-card">

        <div class="card-body">

            <form action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif

                <div class="row g-3">

                    <!-- Product Name -->
                    <div class="col-md-3">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" placeholder="Enter product name" required>
                    </div>

                    <!-- Category -->
                    <div class="col-md-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" required>
                            <option>Select Category</option>
                            @foreach ($categories as $id => $name)
                                <option value="{{ $id }}" @selected(old('category_id', $product->category_id ?? '') == $id)>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- HSN Code -->
                    <div class="col-md-3">
                        <label class="form-label">HSN Code</label>
                        <input type="text" name="hsn_code" class="form-control" value="{{ old('hsn_code', $product->hsn_code ?? '') }}" placeholder="Batch number">
                    </div>

                    <!-- Unit -->
                    <div class="col-md-3">
                        <label class="form-label">Unit <span class="text-danger">*</span></label>
                        <select class="form-select" name="unit_id" required>
                            <option>Select Unit</option>
                            @foreach ($units as $id => $name)
                                <option value="{{ $id }}" @selected(old('unit_id', $product->unit_id ?? '') == $id)> {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- GST -->
                    <div class="col-md-3">
                        <label class="form-label">GST <span class="text-danger">*</span></label>
                        <select class="form-select" name="gst_id" required>
                            <option>Select GST</option>
                            @foreach ($gsts as $id => $name)
                                <option value="{{ $id }}" @selected(old('gst_id', $product->gst_id ?? '') == $id)>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- MRP Price -->
                    <div class="col-md-3">
                        <label class="form-label">MRP Price <span class="text-danger">*</span></label>
                        <input type="number" name="mrp" class="form-control" value="{{ old('mrp', $product->mrp ?? '') }}" placeholder="₹" required>
                    </div>

                    <!-- Sale Price -->
                    <div class="col-md-3">
                        <label class="form-label">Sale Price <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="{{ old('price', $product->price ?? '') }}" placeholder="₹" required>
                    </div>
  
                    <!-- Stock -->
                    <div class="col-md-3">
                        <label class="form-label">Opening Stock <span class="text-danger">*</span></label>
                        <input type="number" name="opening_stock" class="form-control" value="{{ old('opening_stock', $product->opening_stock ?? '') }}" placeholder="0" required>
                    </div>

                    <!-- Description -->
                    <div class="col-6">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Product details..." required>{{ old('description', $product->description ?? '')}}</textarea>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" id="image">
                        @if (isset($product->image_url))
                            <img src="{{ $product->image_url }}" class="img-thumbnail mt-2" alt="{{ $product->name }}" width="100" height="100">
                        @endif
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Is Active</label>
                        <select name="is_active" class="form-select">
                            <option value="1" @selected(old('is_active', $product->is_active ?? '') == '1')>Active</option>
                            <option value="0" @selected(old('is_active', $product->is_active ?? '') == '0')>Inactive</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 text-end">

                        <button type="reset" class="btn btn-secondary me-2">
                            <i class="fa fa-undo me-1"></i>
                            Reset
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-1"></i>
                            Save Product
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection