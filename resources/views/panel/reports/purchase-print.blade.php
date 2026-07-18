@extends('layouts.invoice')

@section('title','Purchase Report')

@section('content')

<div class="header">

    <x-company-header />

    <div class="receipt-info">

        <h2>Purchase Report</h2>

        <p>
            <strong>Period :</strong>
            {{ request('from_date') ? date('d-m-Y', strtotime(request('from_date'))) : 'Beginning' }}
            -
            {{ request('to_date') ? date('d-m-Y', strtotime(request('to_date'))) : date('d-m-Y') }}
        </p>

        @if(request('supplier_id'))
            <p>
                <strong>Supplier :</strong>
                {{ $records->first()?->supplier?->name ?? '-' }}
            </p>
        @endif

    </div>

</div>

<!-- Summary -->

<div class="details-grid">

    <div class="details-box">

        <h3>Report Summary</h3>

        <p>
            <strong>Total Purchases :</strong>
            {{ $stats['total_purchase'] }}
        </p>

        <p>
            <strong>Total Amount :</strong>
            ₹{{ number_format($stats['total_amount'],2) }}
        </p>

        <p>
            <strong>Refund Amount :</strong>
            ₹{{ number_format($stats['paid_amount'],2) }}
        </p>

        <p>
            <strong>Due Amount :</strong>
            ₹{{ number_format($stats['due_amount'],2) }}
        </p>

    </div>

</div>

<!-- Report Table -->

<table class="payment-table">

    <thead>

        <tr>

            <th>#</th>
            <th>Date</th>
            <th>Invoice</th>

            @empty(request('supplier_id'))
                <th>Supplier</th>
            @endempty

            <th class="text-right">Amount</th>
            <th class="text-right">Refund</th>
            <th class="text-right">Due</th>
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        @forelse($records as $key => $row)

            <tr>

                <td>{{ $key + 1 }}</td>

                <td>
                    {{ date('d-m-Y', strtotime($row->invoice_date)) }}
                </td>

                <td>
                    {{ $row->invoice_no }}
                </td>

                @empty(request('supplier_id'))

                    <td>
                        {{ $row->supplier?->name }} <br>
                        ({{ $row->supplier?->mobile ?? '-' }})
                    </td>

                @endempty

                <td class="text-right">
                    ₹{{ number_format($row->total_amount,2) }}
                </td>

                <td class="text-right">
                    ₹{{ number_format($row->paid_amount,2) }}
                </td>

                <td class="text-right">
                    ₹{{ number_format($row->due_amount,2) }}
                </td>

                <td>
                    {{ ucfirst($row->payment_status) }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="{{ request('supplier_id') ? 7 : 8 }}"
                    class="text-center">
                    No purchase records found.
                </td>
            </tr>

        @endforelse

    </tbody>

    @if($records->count())

        <tfoot>

            <tr>

                <th colspan="{{ request('supplier_id') ? 3 : 4 }}"
                    class="text-right">

                    Grand Total

                </th>

                <th class="text-right">
                    ₹{{ number_format($stats['total_amount'],2) }}
                </th>

                <th class="text-right">
                    ₹{{ number_format($stats['paid_amount'],2) }}
                </th>

                <th class="text-right">
                    ₹{{ number_format($stats['due_amount'],2) }}
                </th>

                <th>
                    {{ $stats['total_purchase'] }} Inv.
                </th>

            </tr>

        </tfoot>

    @endif

</table>

@endsection