@extends('layouts.panel')

@section('title', 'Supplier Management')

@section('content')

<!-- PAGE HEADER -->
<div class="card page-card mb-3">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-lg-4">

                <h4 class="page-title">
                    Supplier Management
                </h4>

                <p class="page-subtitle">
                    Manage Fertilizer, Pesticide & Seed Suppliers
                </p>

            </div>

            <div class="col-lg-8">

                <div class="row g-2">

                    <div class="col-md-4">
                        <input type="text"
                               class="form-control"
                               placeholder="Search Supplier">
                    </div>

                    <div class="col-md-3">
                        <select class="form-select">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Search
                        </button>
                    </div>

                    <div class="col-md-3 text-end">
                        <button class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i>
                            Add Supplier
                        </button>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- SUPPLIER TABLE -->
<div class="card table-card">

    <div class="card-body p-0">

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

                        <button class="btn btn-outline-primary action-btn">
                            <i class="fa fa-eye"></i>
                        </button>

                        <a href="{{ route('suppliers.edit', $row->id) }}" class="btn btn-outline-success action-btn" title="EDIT">
                            <i class="fa fa-pen"></i>
                        </a>

                        <button class="btn btn-outline-danger action-btn">
                            <i class="fa fa-trash"></i>
                        </button>

                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

        {{ $records->links('pagination::bootstrap-5') }}

    </div>

</div>

@endsection