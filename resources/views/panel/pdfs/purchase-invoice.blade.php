@extends('layouts.invoice')

@section('content')
    <!-- Header -->
    <div class="header">
        <div class="logo-section">
            <h1>{{ getSetting('app_name') ?? 'Krishi Kendra' }}</h1>
            <p>{{ getSetting('landmark') }} {{ getSetting('area') }}</p>
            <p>
                Email: {{ getSetting('app_email') }}
                |
                Mobile: {{ getSetting('app_phone') }}
            </p>
        </div>

        <div class="receipt-info">
            <h2>Purchase Invoice</h2>
            <p><strong>Invoice No :</strong> {{ $purchase->invoice_no }}</p>
            <p><strong>Date :</strong> {{ $purchase->invoice_date }}</p>
        </div>
    </div>

    <!-- Supplier Details -->
    <div class="details-grid">

        <div class="details-box">
            <h3>Supplier Details</h3>

            <p class="name">
                {{ $purchase->supplier->name ?? '-' }}
            </p>

            <p>
                {{ $purchase->supplier->mobile ?? '-' }}
            </p>
        </div>

        <div class="details-box">

            <h3>Invoice Details</h3>

            <p>
                <strong>Financial Year :</strong>
                {{ $purchase->financialYear->name ?? '-' }}
            </p>

            <p>
                <strong>Payment Mode :</strong>
                {{ $purchase->paymentMode->name ?? '-' }}
            </p>

            <p>
                <strong>Payment Status :</strong>

                @php
                    $statusColor = match($purchase->payment_status){
                        'paid' => '#198754',
                        'partially' => '#0dcaf0',
                        default => '#ffc107'
                    };
                @endphp

                <span style="color:{{ $statusColor }}">
                    {{ ucfirst($purchase->payment_status) }}
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

            @foreach($purchase->purchaseItems as $item)

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
                    ₹{{ number_format($purchase->grand_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Discount</span>
                <span>
                    ₹{{ number_format($purchase->discount_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>GST Amount</span>
                <span>
                    ₹{{ number_format($purchase->gst_amount,2) }}
                </span>
            </div>

            <div class="summary-row total">
                <strong>Total Amount</strong>
                <strong>
                    ₹{{ number_format($purchase->total_amount,2) }}
                </strong>
            </div>

            <div class="summary-row">
                <span>Paid Amount</span>
                <span>
                    ₹{{ number_format($purchase->paid_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Due Amount</span>
                <span>
                    ₹{{ number_format($purchase->due_amount,2) }}
                </span>
            </div>

        </div>

    </div>

    @if($purchase->notes)
        <div style="margin-top:20px;">
            <strong>Notes</strong>
            <p>{{ $purchase->notes }}</p>
        </div>
    @endif

@endsection