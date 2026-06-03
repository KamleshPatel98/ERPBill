@extends('layouts.panel')

@section('title', 'Product Management')

@section('content')
    <!-- PAGE HEADER -->
    <div class="card page-card mb-3">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-lg-4">

                    <h4 class="page-title">
                        Product Inventory
                    </h4>

                    <p class="page-subtitle">
                        Fertilizer, Pesticide & Seed Management
                    </p>

                </div>

                <div class="col-lg-8">

                    <div class="row g-2">

                        <div class="col-md-4">
                            <input type="text"
                                class="form-control"
                                placeholder="Search Product">
                        </div>

                        <div class="col-md-3">
                            <select class="form-select">
                                <option>All Categories</option>
                                <option>Fertilizer</option>
                                <option>Pesticide</option>
                                <option>Seeds</option>
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
                                Add Product
                            </button>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- PRODUCT TABLE -->
    <div class="card table-card">

        <div class="card-body p-0">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Company</th>
                        <th>Stock</th>
                        <th>MRP</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>1</td>

                        <td>

                            <div class="d-flex align-items-center">

                                <div class="member-avatar me-2">
                                    <i class="fa-solid fa-seedling"></i>
                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        Urea Fertilizer
                                    </div>

                                    <small class="text-muted">
                                        50 KG Bag
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>Fertilizer</td>

                        <td>IFFCO</td>

                        <td>120</td>

                        <td>₹266</td>

                        <td>
                            <span class="badge-active">
                                Available
                            </span>
                        </td>

                        <td class="text-center">

                            <button class="btn btn-outline-primary action-btn">
                                <i class="fa fa-eye"></i>
                            </button>

                            <button class="btn btn-outline-success action-btn">
                                <i class="fa fa-pen"></i>
                            </button>

                            <button class="btn btn-outline-danger action-btn">
                                <i class="fa fa-trash"></i>
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>2</td>

                        <td>

                            <div class="d-flex align-items-center">

                                <div class="member-avatar me-2">
                                    <i class="fa-solid fa-bug"></i>
                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        Chlorpyrifos 20%
                                    </div>

                                    <small class="text-muted">
                                        1 Litre Bottle
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>Pesticide</td>

                        <td>Bayer</td>

                        <td>48</td>

                        <td>₹650</td>

                        <td>
                            <span class="badge-active">
                                Available
                            </span>
                        </td>

                        <td class="text-center">

                            <button class="btn btn-outline-primary action-btn">
                                <i class="fa fa-eye"></i>
                            </button>

                            <button class="btn btn-outline-success action-btn">
                                <i class="fa fa-pen"></i>
                            </button>

                            <button class="btn btn-outline-danger action-btn">
                                <i class="fa fa-trash"></i>
                            </button>

                        </td>

                    </tr>

                    <tr>

                        <td>3</td>

                        <td>

                            <div class="d-flex align-items-center">

                                <div class="member-avatar me-2">
                                    <i class="fa-solid fa-wheat-awn"></i>
                                </div>

                                <div>

                                    <div class="fw-semibold">
                                        Hybrid Paddy Seed
                                    </div>

                                    <small class="text-muted">
                                        10 KG Pack
                                    </small>

                                </div>

                            </div>

                        </td>

                        <td>Seeds</td>

                        <td>Syngenta</td>

                        <td>25</td>

                        <td>₹1,250</td>

                        <td>
                            <span class="badge-active">
                                Available
                            </span>
                        </td>

                        <td class="text-center">

                            <button class="btn btn-outline-primary action-btn">
                                <i class="fa fa-eye"></i>
                            </button>

                            <button class="btn btn-outline-success action-btn">
                                <i class="fa fa-pen"></i>
                            </button>

                            <button class="btn btn-outline-danger action-btn">
                                <i class="fa fa-trash"></i>
                            </button>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>
@endsection