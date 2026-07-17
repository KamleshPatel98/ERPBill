@extends('layouts.panel')

@section('title','Supplier Ledger')

@section('content')

<div class="card page-card mb-3">

    <div class="card-body">

        <div class="row align-items-center">

            <div class="col-lg-3">
                <h4 class="page-title">
                    Supplier Ledger
                </h4>

                <p class="page-subtitle">
                    Supplier Ledger Records
                </p>
            </div>

            <div class="col-lg-9">

                <form action="{{ url()->current() }}" method="GET">

                    <div class="row g-2">

                        <div class="col-md-3">
                            <select name="supplier_id" class="form-select select-dropdown">

                                <option value="">Select Supplier</option>

                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        @selected(request('supplier_id') == $supplier->id)>
                                        {{ $supplier->name }} ({{ $supplier->mobile }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-2">
                            <input type="text"
                                   name="start_date"
                                   class="form-control datepicker"
                                   autocomplete="off"
                                   placeholder="From Date"
                                   value="{{ request('start_date') ?? date('d-m-Y') }}">
                        </div>

                        <div class="col-md-2">
                            <input type="text"
                                   name="end_date"
                                   class="form-control datepicker"
                                   autocomplete="off"
                                   placeholder="To Date"
                                   value="{{ request('end_date') ?? date('d-m-Y') }}">
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

                        @if(request()->supplier_id)

                            <div class="col-md-2">

                                <a href="{{ route('ledgers.supplierPrint', request()->only([
                                    'supplier_id',
                                    'start_date',
                                    'end_date'
                                ])) }}"
                                   class="btn btn-secondary">

                                    <i class="fa-solid fa-print"></i>
                                    Print

                                </a>

                            </div>

                        @endif

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<div class="row mb-3">

    <div class="row g-3 mb-4">

        <div class="col-md-2">
            <div class="card page-card h-100">
                <div class="card-body">
                    <small class="text-muted">Total Purchase</small>
                    <h4 class="fw-bold text-primary mb-0">
                        ₹{{ number_format($summary['total_purchase'],2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card page-card h-100">
                <div class="card-body">
                    <small class="text-muted">Paid</small>
                    <h4 class="fw-bold text-success mb-0">
                        ₹{{ number_format($summary['total_paid'],2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card page-card h-100">
                <div class="card-body">
                    <small class="text-muted">Balance Due</small>
                    <h4 class="fw-bold text-danger mb-0">
                        ₹{{ number_format($summary['total_due'],2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card page-card h-100">
                <div class="card-body">
                    <small class="text-muted">Purchase Return</small>
                    <h4 class="fw-bold text-warning mb-0">
                        ₹{{ number_format($summary['total_return'],2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card page-card h-100">
                <div class="card-body">
                    <small class="text-muted">Refund</small>
                    <h4 class="fw-bold text-info mb-0">
                        ₹{{ number_format($summary['total_refund'],2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card page-card h-100">
                <div class="card-body">
                    <small class="text-muted">Net Due</small>
                    <h4 class="fw-bold {{ $summary['net_due'] > 0 ? 'text-danger' : 'text-success' }} mb-0">
                        ₹{{ number_format(abs($summary['net_due']),2) }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

</div>

<div class="card table-card">

    <div class="card-header">
        <h6 class="mb-0">
            Ledger Details
        </h6>
    </div>

    <div class="table-responsive">

        <table class="table table-bordered table-hover">

            <thead>

                <tr>
                    <th>SN.</th>
                    <th>Date</th>
                    <th>Invoice</th>
                    <th>Type</th>
                    <th class="text-end">Debit</th>
                    <th class="text-end">Credit</th>
                    <th class="text-end">Due</th>
                    <th class="text-end">Balance</th>
                </tr>

            </thead>

            <tbody>

                @php
                    $balance = $openingBalance;
                @endphp

                <tr class="table-secondary fw-bold">

                    <td>-</td>
                    <td>{{ $startDate ?? '-' }}</td>
                    <td>-</td>
                    <td>Opening Balance</td>
                    <td class="text-end">-</td>
                    <td class="text-end">-</td>
                    <td class="text-end">-</td>

                    <td class="text-end">
                        ₹{{ number_format($openingBalance,2) }}
                    </td>

                </tr>

                @foreach($records as $row)

                    @php
                        $balance -= $row->debit;
                        $balance += $row->credit;
                    @endphp

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $row->invoice_date }}</td>

                        <td>{{ $row->invoice_no }}</td>

                        <td>{{ $row->type }}</td>

                        <td class="text-end text-danger">
                            {{ $row->debit ? number_format($row->debit,2) : '-' }}
                        </td>

                        <td class="text-end text-success">
                            {{ $row->credit ? number_format($row->credit,2) : '-' }}
                        </td>

                        <td class="text-end">
                            {{ $row->due_amount ? number_format($row->due_amount,2) : '-' }}
                        </td>

                        <td class="text-end fw-bold">
                            ₹{{ number_format($balance,2) }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

            <tfoot>

                <tr>

                    <th colspan="7" class="text-end">
                        Closing Balance
                    </th>

                    <th class="text-end">
                        ₹{{ number_format($balance,2) }}
                    </th>

                </tr>

            </tfoot>

        </table>

    </div>

</div>

@endsection

<x-datepicker />
<x-dropdown />