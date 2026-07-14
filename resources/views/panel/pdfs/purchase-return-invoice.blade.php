@extends('layouts.invoice')

@section('content')
    <!-- Header -->
    <div class="header">
        <x-company-header />

        <div class="receipt-info">
            <h2>Purchase Return Invoice</h2>
            <p><strong>Invoice No :</strong> {{ $purchaseReturn->invoice_no }}</p>
            <p><strong>Date :</strong> {{ $purchaseReturn->invoice_date }}</p>
        </div>
    </div>

    <!-- Supplier Details -->
    <div class="details-grid">

        <div class="details-box">
            <h3>Supplier Details</h3>

            <p class="name">
                {{ $purchaseReturn->supplier->name ?? '-' }}
            </p>

            <p>
                {{ $purchaseReturn->supplier->mobile ?? '-' }}
            </p>
        </div>

        <div class="details-box">

            <h3>Invoice Details</h3>

            <p>
                <strong>Financial Year :</strong>
                {{ $purchaseReturn->financialYear->name ?? '-' }}
            </p>

            <p>
                <strong>Payment Mode :</strong>
                {{ $purchaseReturn->paymentMode->name ?? '-' }}
            </p>

            <p>
                <strong>Payment Status :</strong>

                @php
                    $statusColor = match($purchaseReturn->payment_status){
                        'paid' => '#198754',
                        'partially' => '#0dcaf0',
                        default => '#ffc107'
                    };
                @endphp

                <span style="color:{{ $statusColor }}">
                    {{ ucfirst($purchaseReturn->payment_status) }}
                </span>
            </p>

        </div>

    </div>

    <!-- Product Table -->

    <table class="payment-table">

        <thead>

            <tr>
                <th>#</th>
                <th>Product</th>
                <th>GST</th>
                <th class="text-right">Price</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Discount</th>
                <th class="text-right">GST Amt</th>
                <th class="text-right">Total</th>
            </tr>

        </thead>

        <tbody>

            @foreach($purchaseReturn->purchaseReturnItems as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $item->product->name ?? '-' }}
                    </td>

                    <td>
                        {{ $item->gst->name ?? '-' }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($item->price,2) }}
                    </td>

                    <td class="text-right">
                        {{ $item->quantity }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($item->discount,2) }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($item->gst_amount,2) }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($item->total,2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <!-- Summary -->

    <div class="summary-section">

        <div class="summary-box">

            <div class="summary-row">
                <span>Gross Amount</span>
                <span>
                    ₹{{ number_format($purchaseReturn->grand_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Discount</span>
                <span>
                    ₹{{ number_format($purchaseReturn->discount_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>GST Amount</span>
                <span>
                    ₹{{ number_format($purchaseReturn->gst_amount,2) }}
                </span>
            </div>

            <div class="summary-row total">
                <strong>Total Amount</strong>
                <strong>
                    ₹{{ number_format($purchaseReturn->total_amount,2) }}
                </strong>
            </div>

            <div class="summary-row">
                <span>Paid Amount</span>
                <span>
                    ₹{{ number_format($purchaseReturn->paid_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Due Amount</span>
                <span>
                    ₹{{ number_format($purchaseReturn->due_amount,2) }}
                </span>
            </div>

        </div>

    </div>

    @if($purchaseReturn->notes)
        <div style="margin-top:20px;">
            <strong>Notes</strong>
            <p>{{ $purchaseReturn->notes }}</p>
        </div>
    @endif

@endsection