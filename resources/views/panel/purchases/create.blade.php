@extends('layouts.panel')

@section('title', 'Create Purchase')

@section('content')

    <!-- PAGE HEADER -->
    <div class="card page-card mb-3">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-lg-8">
                    <h4 class="page-title">
                        Create Purchase
                    </h4>

                    <p class="page-subtitle">
                        Supplier Purchase Entry & Stock Management
                    </p>
                </div>

                <div class="col-lg-4 text-end">
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i>
                        Back
                    </a>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        <!-- PURCHASE DETAILS -->
        <div class="card table-card mb-3">

            <div class="card-header">
                <strong>Purchase Information</strong>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">Invoice No</label>
                        <input type="text"
                               name="invoice_no"
                               class="form-control"
                               value="{{ generateNo("Purchase", "PUR") }}" 
                               readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Invoice Date</label>
                        <input type="text"
                               name="invoice_date"
                               class="form-control datepicker"
                               value="{{ old('invoice_date', date('d-m-Y')) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select select-dropdown">
                            <option value="">Select Supplier</option>

                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">
                                    {{ $supplier->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Financial Year</label>
                        <select name="financial_year_id" class="form-select">
                            @foreach($financialYears as $year)
                                <option value="{{ $year->id }}">
                                    {{ $year->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode_id" class="form-select">
                            <option value="">Select Mode</option>

                            @foreach($paymentModes as $mode)
                                <option value="{{ $mode->id }}">
                                    {{ $mode->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Paid Amount</label>
                        <input type="number"
                               step="0.01"
                               name="paid_amount"
                               id="paid_amount"
                               class="form-control"
                               value="0">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Discount Amount</label>
                        <input type="number"
                               step="0.01"
                               name="discount_amount"
                               id="discount_amount"
                               class="form-control"
                               value="0">
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes"
                                  rows="2"
                                  class="form-control"></textarea>
                    </div>

                </div>

            </div>

        </div>

        <!-- PURCHASE ITEMS -->
        <div class="card table-card mb-3">

            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Purchase Items</strong>

                <button type="button"
                        class="btn btn-sm btn-primary"
                        id="addRow">
                    <i class="fa fa-plus me-1"></i>
                    Add Item
                </button>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle mb-0" id="purchaseTable">

                        <thead>
                            <tr>
                                <th width="25%">Product</th>
                                <th width="10%">Qty</th>
                                <th width="12%">Rate</th>
                                <th width="10%">GST%</th>
                                <th width="10%">Discount</th>
                                <th width="15%">Amount</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>

                                <td>
                                    <select name="items[0][product_id]"
                                            class="form-select">

                                        <option value="">Select Product</option>

                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </td>

                                <td>
                                    <input type="number"
                                           name="items[0][qty]"
                                           class="form-control qty"
                                           value="1">
                                </td>

                                <td>
                                    <input type="number"
                                           step="0.01"
                                           name="items[0][rate]"
                                           class="form-control rate"
                                           value="0">
                                </td>

                                <td>
                                    <input type="number"
                                           step="0.01"
                                           name="items[0][gst]"
                                           class="form-control gst"
                                           value="0">
                                </td>

                                <td>
                                    <input type="number"
                                           step="0.01"
                                           name="items[0][discount]"
                                           class="form-control discount"
                                           value="0">
                                </td>

                                <td>
                                    <input type="number"
                                           readonly
                                           class="form-control amount"
                                           value="0">
                                </td>

                                <td>
                                    <button type="button"
                                            class="btn btn-danger btn-sm removeRow">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- SUMMARY -->
        <div class="card table-card mb-3">

            <div class="card-header">
                <strong>Purchase Summary</strong>
            </div>

            <div class="card-body">

                <div class="row justify-content-end">

                    <div class="col-md-4">

                        <table class="table table-bordered">

                            <tr>
                                <th>Gross Amount</th>
                                <td class="text-end">₹ <span id="grossAmount">0.00</span></td>
                            </tr>

                            <tr>
                                <th>GST Amount</th>
                                <td class="text-end">₹ <span id="gstAmount">0.00</span></td>
                            </tr>

                            <tr>
                                <th>Discount</th>
                                <td class="text-end">₹ <span id="discountAmount">0.00</span></td>
                            </tr>

                            <tr class="table-primary">
                                <th>Total Amount</th>
                                <td class="text-end">₹ <span id="totalAmount">0.00</span></td>
                            </tr>

                            <tr>
                                <th>Paid Amount</th>
                                <td class="text-end">₹ <span id="paidDisplay">0.00</span></td>
                            </tr>

                            <tr class="table-warning">
                                <th>Due Amount</th>
                                <td class="text-end">₹ <span id="dueAmount">0.00</span></td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        <div class="text-end mb-4">

            <a href="{{ route('purchases.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit"
                    class="btn btn-primary">
                <i class="fa fa-save me-1"></i>
                Save Purchase
            </button>

        </div>

    </form>

@endsection

<x-datepicker />