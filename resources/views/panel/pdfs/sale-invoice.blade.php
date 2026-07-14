<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sale Invoice - {{ $sale->invoice_no }}</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #f9f9f9;
        }

        .receipt-card {
            background: #fff;
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo-section h1 {
            margin: 0;
            color: #0d6efd;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .logo-section p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #666;
        }

        .receipt-info {
            text-align: right;
        }

        .receipt-info h2 {
            margin: 0;
            font-size: 20px;
            color: #222;
            text-transform: uppercase;
        }

        .receipt-info p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .details-box h3 {
            font-size: 12px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .details-box p {
            margin: 4px 0;
            font-size: 15px;
            line-height: 1.5;
        }

        .details-box .name {
            font-weight: 700;
            color: #111;
            font-size: 16px;
        }

        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .payment-table th {
            background: #f8f9fa;
            text-align: left;
            padding: 12px 15px;
            font-size: 13px;
            text-transform: uppercase;
            color: #666;
            border-bottom: 2px solid #dee2e6;
        }

        .payment-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 15px;
        }

        .text-right {
            text-align: right;
        }

        .summary-section {
            display: flex;
            justify-content: flex-end;
        }

        .summary-box {
            width: 300px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-row.total {
            border-bottom: none;
            padding-top: 15px;
        }

        .summary-row.total span {
            font-size: 18px;
            font-weight: 800;
            color: #0d6efd;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #aaa;
            font-size: 12px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .receipt-card {
                box-shadow: none;
                border: none;
                max-width: 100%;
            }

            .btn-print {
                display: none;
            }
        }

        .btn-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #0d6efd;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>

    <button class="btn-print" onclick="window.print()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        Print Receipt
    </button>

    <div class="receipt-card">

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
                <h2>Sale Invoice</h2>
                <p><strong>Invoice No :</strong> {{ $sale->invoice_no }}</p>
                <p><strong>Date :</strong> {{ $sale->invoice_date }}</p>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="details-grid">

            <div class="details-box">
                <h3>Customer Details</h3>

                <p class="name">
                    {{ $sale->customer->name ?? '-' }}
                </p>

                <p>
                    {{ $sale->customer->mobile ?? '-' }}
                </p>
            </div>

            <div class="details-box">

                <h3>Invoice Details</h3>

                <p>
                    <strong>Financial Year :</strong>
                    {{ $sale->financialYear->name ?? '-' }}
                </p>

                <p>
                    <strong>Payment Mode :</strong>
                    {{ $sale->paymentMode->name ?? '-' }}
                </p>

                <p>
                    <strong>Payment Status :</strong>

                    @php
                        $statusColor = match($sale->payment_status){
                            'paid' => '#198754',
                            'partially' => '#0dcaf0',
                            default => '#ffc107'
                        };
                    @endphp

                    <span style="color:{{ $statusColor }}">
                        {{ ucfirst($sale->payment_status) }}
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

                @foreach($sale->saleItems as $item)

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
                        ₹{{ number_format($sale->grand_amount,2) }}
                    </span>
                </div>

                <div class="summary-row">
                    <span>Discount</span>
                    <span>
                        ₹{{ number_format($sale->discount_amount,2) }}
                    </span>
                </div>

                <div class="summary-row">
                    <span>GST Amount</span>
                    <span>
                        ₹{{ number_format($sale->gst_amount,2) }}
                    </span>
                </div>

                <div class="summary-row total">
                    <strong>Total Amount</strong>
                    <strong>
                        ₹{{ number_format($sale->total_amount,2) }}
                    </strong>
                </div>

                <div class="summary-row">
                    <span>Paid Amount</span>
                    <span>
                        ₹{{ number_format($sale->paid_amount,2) }}
                    </span>
                </div>

                <div class="summary-row">
                    <span>Due Amount</span>
                    <span>
                        ₹{{ number_format($sale->due_amount,2) }}
                    </span>
                </div>

            </div>

        </div>

        @if($sale->notes)
            <div style="margin-top:20px;">
                <strong>Notes</strong>
                <p>{{ $sale->notes }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Thank you for choosing {{ getSetting('app_name') ?? 'Krishi Kendra' }}. This is a computer generated receipt.</p>
        </div>
    </div>

</body>

</html>