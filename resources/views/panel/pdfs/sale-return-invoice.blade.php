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
            <h2>Sale Return Invoice</h2>
            <p><strong>Invoice No :</strong> {{ $saleReturn->invoice_no }}</p>
            <p><strong>Date :</strong> {{ $saleReturn->invoice_date }}</p>
        </div>
    </div>

    <!-- Customer Details -->
    <div class="details-grid">

        <div class="details-box">
            <h3>Customer Details</h3>

            <p class="name">
                {{ $saleReturn->customer->name ?? '-' }}
            </p>

            <p>
                {{ $saleReturn->customer->mobile ?? '-' }}
            </p>
        </div>

        <div class="details-box">

            <h3>Invoice Details</h3>

            <p>
                <strong>Financial Year :</strong>
                {{ $saleReturn->financialYear->name ?? '-' }}
            </p>

            <p>
                <strong>Payment Mode :</strong>
                {{ $saleReturn->paymentMode->name ?? '-' }}
            </p>

            <p>
                <strong>Payment Status :</strong>

                @php
                    $statusColor = match($saleReturn->payment_status){
                        'paid' => '#198754',
                        'partially' => '#0dcaf0',
                        default => '#ffc107'
                    };
                @endphp

                <span style="color:{{ $statusColor }}">
                    {{ ucfirst($saleReturn->payment_status) }}
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

            @foreach($saleReturn->saleReturnItems as $item)

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
                    ₹{{ number_format($saleReturn->grand_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Discount</span>
                <span>
                    ₹{{ number_format($saleReturn->discount_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>GST Amount</span>
                <span>
                    ₹{{ number_format($saleReturn->gst_amount,2) }}
                </span>
            </div>

            <div class="summary-row total">
                <strong>Total Amount</strong>
                <strong>
                    ₹{{ number_format($saleReturn->total_amount,2) }}
                </strong>
            </div>

            <div class="summary-row">
                <span>Paid Amount</span>
                <span>
                    ₹{{ number_format($saleReturn->paid_amount,2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Due Amount</span>
                <span>
                    ₹{{ number_format($saleReturn->due_amount,2) }}
                </span>
            </div>

        </div>

    </div>

    @if($saleReturn->notes)
        <div style="margin-top:20px;">
            <strong>Notes</strong>
            <p>{{ $saleReturn->notes }}</p>
        </div>
    @endif

@endsection