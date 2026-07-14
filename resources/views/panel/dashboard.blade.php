@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <!-- TOP STATS -->
    <div class="row g-3 mb-3">

        {{-- CARD 1 : Total Sale --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <div>
                            <div class="fw-bold">₹{{ number_format($stats['totalSaleAmt'], 2) }}</div>
                            <small class="text-muted">Total Sale</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('sales.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 2 : Total Purchase --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-cart-plus"></i>
                        </div>
                        <div>
                            <div class="fw-bold">₹{{ number_format($stats['totalPurchaseAmt'], 2) }}</div>
                            <small class="text-muted">Total Purchase</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('purchases.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 3 : Net Profit --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <div>
                            <div class="fw-bold">₹{{ number_format($stats['netProfit'], 2) }}</div>
                            <small class="text-muted">Net Profit</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="#" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 4 : Low Stock --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <div class="fw-bold">{{ $stats['lowStock'] }}</div>
                            <small class="text-muted">Low Stock</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('products.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 5 : Customer Due --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                        <div>
                            <div class="fw-bold">₹{{ number_format($stats['customerDue'], 2) }}</div>
                            <small class="text-muted">Customer Due</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('sales.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 6 : Supplier Due --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <div>
                            <div class="fw-bold">₹{{ number_format($stats['purchaseDue'], 2) }}</div>
                            <small class="text-muted">Supplier Due</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('purchases.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 7 : Sale Return --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-rotate-left"></i>
                        </div>
                        <div>
                            <div class="fw-bold">₹{{ number_format($stats['saleReturn'], 2) }}</div>
                            <small class="text-muted">Sale Return</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('sale-returns.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD 8 : Purchase Return --}}
        <div class="col-md-3">
            <div class="card page-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="member-avatar me-3">
                            <i class="fa-solid fa-rotate-right"></i>
                        </div>
                        <div>
                            <div class="fw-bold">₹{{ number_format($stats['purchaseReturn'], 2) }}</div>
                            <small class="text-muted">Purchase Return</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('purchase-returns.index') }}" class="text-primary text-decoration-none small fw-semibold">
                            View Details <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
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