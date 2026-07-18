@extends('layouts.panel')

@section('title', 'Purchase Management')

@section('content')

<!-- PAGE HEADER -->
<div class="card page-card mb-3">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-lg-3">

                <h4 class="page-title">
                    Purchase Report
                </h4>

                <p class="page-subtitle">
                    Supplier Purchase Report
                </p>

            </div>

            <div class="col-lg-7">

                <form action="{{ url()->current() }}" method="GET">

                    <div class="row g-2">

                        <div class="col-md-4">

                            <select name="supplier_id" class="form-select">

                                <option value="">All Suppliers</option>

                                @foreach($suppliers as $supplier)

                                    <option value="{{ $supplier->id }}"
                                        @selected(request('supplier_id') == $supplier->id)>

                                        {{ $supplier->name }}
                                        ({{ $supplier->mobile }})

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="col-md">

                            <input
                                type="text"
                                class="form-control datepicker"
                                name="from_date"
                                value="{{ request('from_date') ?? date('d-m-Y') }}"
                                placeholder="From Date">

                        </div>

                        <div class="col-md">

                            <input
                                type="text"
                                class="form-control datepicker"
                                name="to_date"
                                value="{{ request('to_date') ?? date('d-m-Y') }}"
                                placeholder="To Date">

                        </div>

                        <div class="col-md-3">

                            <button class="btn btn-primary">
                                <i class="fa fa-search me-1"></i>
                                Search
                            </button>

                            <a href="{{ url()->current() }}"
                               class="btn btn-secondary">

                                <i class="fa fa-refresh me-1"></i>
                                Reset

                            </a>

                        </div>

                    </div>

                </form>

            </div>

            <div class="col-md-2">

                <a href="{{ route('reports.purchasePrint', request()->only([
                    'supplier_id',
                    'from_date',
                    'to_date'
                ])) }}"
                   class="btn btn-secondary">

                    <i class="fa-solid fa-print"></i>
                    Print

                </a>

            </div>

        </div>

    </div>

</div>

<!-- STATS -->

<div class="row mb-3">

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Total Purchases</h6>

                <h4>
                    {{ $stats['total_purchase'] }}
                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Total Amount</h6>

                <h4>
                    ₹ {{ number_format($stats['total_amount'],2) }}
                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Refund Amount</h6>

                <h4 class="text-success">
                    ₹ {{ number_format($stats['paid_amount'],2) }}
                </h4>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card text-center">

            <div class="card-body">

                <h6>Due Amount</h6>

                <h4 class="text-danger">
                    ₹ {{ number_format($stats['due_amount'],2) }}
                </h4>

            </div>

        </div>

    </div>

</div>

<!-- PURCHASE TABLE -->

<div class="card table-card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                <tr>

                    <th>#</th>
                    <th>Invoice</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>Refund</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($records as $index => $row)

                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>
                            {{ $row->invoice_no }}
                        </td>

                        <td>
                            {{ $row->invoice_date }}
                        </td>

                        <td>
                            {{ $row->supplier?->name ?? '-' }}
                            ({{ $row->supplier?->mobile ?? '-' }})
                        </td>

                        <td>
                            ₹{{ number_format($row->total_amount,2) }}
                        </td>

                        <td>
                            ₹{{ number_format($row->refund_amount,2) }}
                        </td>

                        <td>
                            ₹{{ number_format($row->due_amount,2) }}
                        </td>

                        <td>

                            @if($row->payment_status == 'paid')

                                <span class="badge bg-success">
                                    Paid
                                </span>

                            @elseif($row->payment_status == 'partially')

                                <span class="badge bg-warning">
                                    Partial
                                </span>

                            @else

                                <span class="badge bg-danger">
                                    Pending
                                </span>

                            @endif

                        </td>

                        <td class="text-center">

                            <div class="d-flex justify-content-center gap-1">

                                <a href="{{ route('purchases.invoice', $row->id) }}"
                                   class="btn btn-sm btn-outline-secondary"
                                   title="Print Invoice">

                                    <i class="fa-solid fa-print"></i>

                                </a>

                                <button
                                    class="btn btn-sm btn-outline-primary"
                                    type="button"
                                    title="View"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $row->id }}">

                                    <i class="fa fa-eye"></i>

                                </button>

                                <a href="{{ route('purchases.edit',$row) }}"
                                   class="btn btn-sm btn-outline-success">

                                    <i class="fa fa-edit"></i>

                                </a>

                                <form action="{{ route('purchases.destroy',$row) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Delete this purchase?')">

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    <tr>

                        <td colspan="9" class="p-0 border-0">

                            <div class="collapse"
                                 id="collapse{{ $row->id }}">

                                <div class="p-3 bg-light">
                                                                        <div class="row">

                                        <div class="col-md-3">
                                            <strong>Grand Amount:</strong>
                                            ₹{{ number_format($row->grand_amount,2) }}
                                        </div>

                                        <div class="col-md-3">
                                            <strong>GST Amount:</strong>
                                            ₹{{ number_format($row->gst_amount,2) }}
                                        </div>

                                        <div class="col-md-3">
                                            <strong>Discount:</strong>
                                            ₹{{ number_format($row->discount_amount,2) }}
                                        </div>

                                        <div class="col-md-3">
                                            <strong>Payment Mode:</strong>
                                            {{ $row->paymentMode?->name ?? '-' }}
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <strong>Notes:</strong>
                                            {{ $row->notes ?: '-' }}
                                        </div>

                                    </div>

                                    <div class="mt-3">

                                        <h6 class="mb-2">
                                            Purchase Items
                                        </h6>

                                        <table class="table table-bordered table-sm">

                                            <thead class="table-light">

                                            <tr>

                                                <th>#</th>
                                                <th>Product</th>
                                                <th class="text-end">Qty</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-end">Sub Total</th>
                                                <th class="text-end">Discount</th>
                                                <th>GST</th>
                                                <th class="text-end">GST Amount</th>
                                                <th class="text-end">Total</th>

                                            </tr>

                                            </thead>

                                            <tbody>

                                            @forelse($row->purchaseItems as $key => $item)

                                                <tr>

                                                    <td>{{ $key + 1 }}</td>

                                                    <td>
                                                        {{ $item->product?->name ?? '-' }}
                                                    </td>

                                                    <td class="text-end">
                                                        {{ number_format($item->quantity,2) }}
                                                    </td>

                                                    <td class="text-end">
                                                        ₹{{ number_format($item->price,2) }}
                                                    </td>

                                                    <td class="text-end">
                                                        ₹{{ number_format($item->sub_total,2) }}
                                                    </td>

                                                    <td class="text-end">
                                                        ₹{{ number_format($item->discount,2) }}
                                                    </td>

                                                    <td>
                                                        {{ $item->gst_rate ?? '-' }}%
                                                    </td>

                                                    <td class="text-end">
                                                        ₹{{ number_format($item->gst_amount,2) }}
                                                    </td>

                                                    <td class="text-end fw-bold">
                                                        ₹{{ number_format($item->total,2) }}
                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>

                                                    <td colspan="9"
                                                        class="text-center">

                                                        No items found.

                                                    </td>

                                                </tr>

                                            @endforelse

                                            </tbody>

                                            @if($row->purchaseItems->count())

                                                <tfoot class="table-light">

                                                <tr>

                                                    <th colspan="4"
                                                        class="text-end">
                                                        Totals
                                                    </th>

                                                    <th class="text-end">
                                                        ₹{{ number_format($row->grand_amount,2) }}
                                                    </th>

                                                    <th class="text-end">
                                                        ₹{{ number_format($row->discount_amount,2) }}
                                                    </th>

                                                    <th></th>

                                                    <th class="text-end">
                                                        ₹{{ number_format($row->gst_amount,2) }}
                                                    </th>

                                                    <th class="text-end">
                                                        ₹{{ number_format($row->total_amount,2) }}
                                                    </th>

                                                </tr>

                                                </tfoot>

                                            @endif

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9"
                            class="text-center py-4">

                            No purchase records found.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

<x-dropdown />
<x-datepicker />