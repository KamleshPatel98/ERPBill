@extends('layouts.panel')

@section('title', 'Low Stock')

@section('content')

<div class="card page-card mb-3">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h4 class="page-title">
                    Low Stock
                </h4>

                <p class="page-subtitle">
                    Products Below Minimum Stock Level
                </p>

            </div>

        </div>

    </div>

</div>

<div class="card table-card">

    <div class="card-header">

        <h6 class="mb-0">
            Low Stock Products
        </h6>

    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead>

                <tr>
                    <th width="60">SN.</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th class="text-end">Opening</th>
                    <th class="text-end">Purchase</th>
                    <th class="text-end">Purchase Return</th>
                    <th class="text-end">Sale</th>
                    <th class="text-end">Sale Return</th>
                    <th class="text-end">Current Stock</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $product->name }}</td>

                        <td>{{ $product->category->name ?? '-' }}</td>

                        <td class="text-end">
                            {{ $product->opening_stock }}
                        </td>

                        <td class="text-end">
                            {{ $product->purchase_qty ?? 0 }}
                        </td>

                        <td class="text-end text-danger">
                            {{ $product->purchase_return_qty ?? 0 }}
                        </td>

                        <td class="text-end text-danger">
                            {{ $product->sale_qty ?? 0 }}
                        </td>

                        <td class="text-end text-success">
                            {{ $product->sale_return_qty ?? 0 }}
                        </td>

                        <td class="text-end">
                            <span class="badge {{ $product->current_stock <= 0 ? 'bg-dark' : 'bg-danger' }}">
                                {{ $product->current_stock }}
                            </span>
                        </td>

                        <td>
                            <span class="badge {{ $product->current_stock <= 0 ? 'bg-dark' : 'bg-danger' }}">
                                {{ $product->current_stock <= 0 ? 'Out of Stock' : 'Low Stock' }}
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="10" class="text-center">
                            No low stock products found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection