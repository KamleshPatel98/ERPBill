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
                            @php
                                $isProfit = $stats['netProfit'] >= 0;
                            @endphp

                            <div class="fw-bold {{ $isProfit ? 'text-success' : 'text-danger' }}">
                                ₹{{ number_format(abs($stats['netProfit']), 2) }}
                            </div>

                            <small class="text-muted">
                                {{ $isProfit ? 'Net Profit' : 'Net Loss' }}
                            </small>
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

        <div class="col-md-8">
            <div class="card table-card">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="mb-0 fw-bold">Monthly Sales vs Purchase</h6>
                    <span>{{ date('Y') }}</span>
                </div>

                <div class="card-body">
                    <canvas id="salesPurchaseChart" height="110"></canvas>
                </div>
            </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="col-md-4">

            <div class="card table-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Low Stock Products</h6>
                </div>

                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Current Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            {{ $product->name }}
                                        </div>

                                        <small class="text-muted">
                                            <i class="fa-solid fa-layer-group me-1"></i>
                                            {{ $product->category?->name }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge {{ $product->current_stock <= 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
                                            {{ $product->current_stock <= 0 ? 'Out of Stock' : $product->current_stock . ' Left' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-3">
                                        No low stock products found.
                                    </td>
                                </tr>
                            @endforelse 
                        </tbody>
                    </table>
                    {{ $lowStockProducts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('script')
    <script src="{{ asset('assets/chart.js') }}"></script>
    <script>
        const graph = @json($graph);

        new Chart(document.getElementById('salesPurchaseChart'), {
            type: 'bar',
            data: {
                labels: graph.months,
                datasets: [
                    {
                        label: 'Sales',
                        data: graph.sales,
                        backgroundColor: '#36A2EB'
                    },
                    {
                        label: 'Purchase',
                        data: graph.purchases,
                        backgroundColor: '#FF9F40'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endpush