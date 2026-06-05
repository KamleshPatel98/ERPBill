@extends('layouts.panel')

@section('title', 'Supplier Management')

@section('content')

<!-- PAGE HEADER -->
<div class="card page-card mb-3">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-lg-3">

                <h4 class="page-title">
                    Supplier Management
                </h4>

                <p class="page-subtitle">
                    Manage Fertilizer, Pesticide & Seed Suppliers
                </p>

            </div>

            <div class="col-lg-7">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row g-2">

                        <div class="col-md-5">
                            <input type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search Supplier name / mobile"
                                value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="is_active" class="form-select">
                                <option value="">All</option>
                                <option value="1" @selected(request('is_active') == '1')>
                                    Active
                                </option>
                                <option value="0" @selected(request('is_active') == '0')>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button class="btn btn-primary">
                                <i class="fa fa-search me-1"></i>
                                Search
                            </button>
                            <a href="{{ url()->current() }}" class="btn btn-secondary">
                                <i class="fa fa-refresh me-1"></i> Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i>
                    Add Supplier
                </button>
            </div>
        </div>

    </div>

</div>

<!-- SUPPLIER TABLE -->
<div class="card table-card">

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Supplier</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>GST No.</th>
                        <th>City</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($records as $row)
                    <tr>
                        <td>{{ $records->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="d-flex align-items-center">

                                <div class="member-avatar me-2">
                                    <i class="fa-solid fa-building"></i>
                                </div>

                                <div>
                                    <div class="fw-semibold">
                                        {{ $row->name }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $row->created_at }}
                                    </small>
                                </div>

                            </div>
                        </td>

                        <td>{{ $row->mobile }}</td>

                        <td>{{ $row->email ?? 'N/A' }}</td>

                        <td>{{ $row->gst_no ?? 'N/A'}}</td>

                        <td>{{ $row->city ?? 'N/A'}}</td>

                        <td>
                            <x-is-active :isActive="$row->is_active" />
                        </td>

                        <td class="text-center">

                            <button class="btn btn-outline-primary action-btn"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#supplier{{ $row->id }}">
                                <i class="fa fa-eye"></i>
                            </button>

                            <a href="{{ route('suppliers.edit', $row->id) }}" class="btn btn-outline-success action-btn" title="EDIT">
                                <i class="fa fa-pen"></i>
                            </a>

                            {{-- <button class="btn btn-outline-danger action-btn">
                                <i class="fa fa-trash"></i>
                            </button> --}}

                        </td>

                    </tr>

                    <tr>
                        <td colspan="8" class="p-0 border-0">

                            <div class="collapse" id="supplier{{ $row->id }}">

                                <div class="card card-body m-2">

                                    <div class="row">

                                        <div class="col-md-3 mb-3">
                                            <label class="fw-bold">GST No</label>
                                            <div>{{ $row->gst_no ?: '-' }}</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="fw-bold">Address</label>
                                            <div>{{ $row->address }}</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="fw-bold">State</label>
                                            <div>{{ $row->state?->name }}</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="fw-bold">Zip Code</label>
                                            <div>{{ $row->zip }}</div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="fw-bold">Created At</label>
                                            <div>{{ $row->created_at->format('d M Y') }}</div>
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