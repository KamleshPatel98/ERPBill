@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <!-- TOP STATS -->
    <div class="row g-3 mb-3">

        <!-- CARD 1 -->
        <div class="col-md-3">
            <div class="card page-card">
                <div class="card-body d-flex align-items-center">

                    <div class="member-avatar me-3">
                        <i class="fa-solid fa-box"></i>
                    </div>

                    <div>
                        <div class="fw-bold">120</div>
                        <small class="text-muted">Total Products</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="col-md-3">
            <div class="card page-card">
                <div class="card-body d-flex align-items-center">

                    <div class="member-avatar me-3">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>

                    <div>
                        <div class="fw-bold text-warning">15</div>
                        <small class="text-muted">Low Stock</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col-md-3">
            <div class="card page-card">
                <div class="card-body d-flex align-items-center">

                    <div class="member-avatar me-3">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>

                    <div>
                        <div class="fw-bold">₹2,45,000</div>
                        <small class="text-muted">Today Sales</small>
                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="col-md-3">
            <div class="card page-card">
                <div class="card-body d-flex align-items-center">

                    <div class="member-avatar me-3">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div>
                        <div class="fw-bold">85</div>
                        <small class="text-muted">Customers</small>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- MAIN SECTION -->
    <div class="row g-3">

        <!-- RECENT PRODUCTS -->
        <div class="col-md-8">

            <div class="card table-card">

                <div class="card-body p-0">

                    <div class="p-3 border-bottom">
                        <h6 class="mb-0 fw-bold">Recent Products</h6>
                    </div>

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>MRP</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>Urea Fertilizer</td>
                                <td>Fertilizer</td>
                                <td>120</td>
                                <td>₹266</td>
                            </tr>

                            <tr>
                                <td>Chlorpyrifos</td>
                                <td>Pesticide</td>
                                <td>48</td>
                                <td>₹650</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="col-md-4">

            <div class="card page-card">

                <div class="card-body">

                    <h6 class="fw-bold mb-3">Quick Actions</h6>

                    <a href="#" class="btn btn-primary w-100 mb-2">
                        <i class="fa fa-plus me-1"></i> Add Product
                    </a>

                    <a href="#" class="btn btn-outline-success w-100 mb-2">
                        <i class="fa fa-list me-1"></i> View Products
                    </a>

                    <a href="#" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fa fa-layer-group me-1"></i> Categories
                    </a>

                    <a href="#" class="btn btn-outline-danger w-100">
                        <i class="fa fa-cart-shopping me-1"></i> Purchase Entry
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection