@extends('layouts.panel')

@section('title', 'Add Product')

@section('content')

    <!-- PAGE HEADER -->
    <div class="card page-card mb-3">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <h4 class="page-title">
                        Add New Product
                    </h4>

                    <p class="page-subtitle">
                        Fertilizer, Pesticide & Seed entry form
                    </p>

                </div>

                <div class="col-lg-6 text-end">

                    <a href="#" class="btn btn-secondary">
                        Back to List
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- FORM CARD -->
    <div class="card table-card">

        <div class="card-body">

            <form>

                <div class="row g-3">

                    <!-- Product Name -->
                    <div class="col-md-6">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" placeholder="Enter product name">
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select class="form-select">
                            <option>Select Category</option>
                            <option>Fertilizer</option>
                            <option>Pesticide</option>
                            <option>Seeds</option>
                        </select>
                    </div>

                    <!-- Company -->
                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <input type="text" class="form-control" placeholder="Company name">
                    </div>

                    <!-- Unit -->
                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <select class="form-select">
                            <option>Bag</option>
                            <option>Bottle</option>
                            <option>Kg</option>
                            <option>Gram</option>
                            <option>Liter</option>
                        </select>
                    </div>

                    <!-- Stock -->
                    <div class="col-md-4">
                        <label class="form-label">Opening Stock</label>
                        <input type="number" class="form-control" placeholder="0">
                    </div>

                    <!-- Purchase Price -->
                    <div class="col-md-4">
                        <label class="form-label">Purchase Price</label>
                        <input type="number" class="form-control" placeholder="₹">
                    </div>

                    <!-- Sale Price -->
                    <div class="col-md-4">
                        <label class="form-label">MRP / Sale Price</label>
                        <input type="number" class="form-control" placeholder="₹">
                    </div>

                    <!-- Batch -->
                    <div class="col-md-6">
                        <label class="form-label">Batch / HSN Code</label>
                        <input type="text" class="form-control" placeholder="Batch number">
                    </div>

                    <!-- Expiry -->
                    <div class="col-md-6">
                        <label class="form-label">Expiry Date</label>
                        <input type="date" class="form-control">
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Product details..."></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 text-end">

                        <button type="reset" class="btn btn-secondary me-2">
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