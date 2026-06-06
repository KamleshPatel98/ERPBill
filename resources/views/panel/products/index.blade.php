@extends('layouts.panel')

@section('title', 'Product Management')

@section('content')
    <!-- PAGE HEADER -->
    <div class="card page-card mb-3">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-lg-3">

                    <h4 class="page-title">
                        Product Inventory
                    </h4>

                    <p class="page-subtitle">
                        Fertilizer, Pesticide & Seed Management
                    </p>

                </div>

                <div class="col-lg-8">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-2">

                            <div class="col-md-4">
                                <input type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{ request('name') }}"
                                    placeholder="Search Product">
                            </div>

                            <div class="col-md-3">
                                <select name="category_id" class="form-select select-dropdown">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" @selected(request('category_id') == $id)>{{ $name }}</option>
                                    @endforeach 
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="is_active" class="form-select">
                                    <option value="">All</option>
                                    <option value="1" @selected(request('is_active') == '1')>Active</option>
                                    <option value="0" @selected(request('is_active') == '0')>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary">
                                    <i class="fa fa-search me-1"></i>
                                    Search
                                </button>

                                <a href="{{ url()->current() }}" class="btn btn-secondary">
                                    <i class="fa fa-search me-1"></i>
                                    Reset
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="col-md-1">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i>
                        Add New
                    </a>
                </div>
            </div>

        </div>

    </div>

    <!-- PRODUCT TABLE -->
    <div class="card table-card">

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>GST</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($records as $index => $row)

                            {{-- MAIN ROW --}}
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->category?->name ?? '-' }}</td>
                                <td>{{ $row->gst?->rate ?? 0 }}%</td>
                                <td>{{ $row->opening_stock }}</td>
                                <td>₹{{ $row->price }}</td>
                                <td>
                                    <x-is-active :isActive="$row->is_active" />
                                </td>

                                {{-- ACTION --}}
                                <td class="text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-1">

                                        <button class="btn btn-sm btn-outline-primary action-btn"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $row->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        <a href="{{ route('products.edit', $row) }}"
                                            class="btn btn-sm btn-outline-success action-btn"
                                            title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('products.destroy', $row) }}"
                                            method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-outline-danger action-btn"
                                                type="submit"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this product?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                            {{-- DETAIL ROW --}}
                            <tr>
                                <td colspan="8" class="p-0 border-0">
                                    <div class="collapse" id="collapse{{ $row->id }}">
                                        <div class="p-3 bg-light">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <strong>HSN:</strong> {{ $row->hsn_code ?? '-' }}
                                                </div>

                                                <div class="col-md-3">
                                                    <strong>MRP:</strong> ₹{{ $row->mrp }}
                                                </div>

                                                <div class="col-md-6">
                                                    <strong>Description:</strong> {{ $row->description ?? '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>
                {{ $records->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
@endsection