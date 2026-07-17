@extends('layouts.invoice')

@section('title','Supplier Ledger Print')

@section('content')

    <!-- Header -->
    <div class="header">

        <x-company-header />

        <div class="receipt-info">

            <h2>Supplier Ledger</h2>

            <p>
                <strong>Period :</strong>
                {{ $startDate ? date('d-m-Y', strtotime($startDate)) : 'Beginning' }}
                -
                {{ $endDate ? date('d-m-Y', strtotime($endDate)) : date('d-m-Y') }}
            </p>

        </div>

    </div>

    <!-- Supplier Details -->

    <div class="details-grid">

        <div class="details-box">

            <h3>Supplier Details</h3>

            <p class="name">
                {{ $supplier->name }}
            </p>

            <p>
                {{ $supplier->mobile }}
            </p>

        </div>

        <div class="details-box">

            <h3>Ledger Summary</h3>

            <p>
                <strong>Opening Balance :</strong>
                ₹{{ number_format($openingBalance,2) }}
            </p>

            <p>
                <strong>Net Due :</strong>
                ₹{{ number_format($summary['net_due'],2) }}
            </p>

        </div>

    </div>

    <!-- Ledger Table -->

    <table class="payment-table">

        <thead>

            <tr>
                <th>Date</th>
                <th>Invoice No</th>
                <th>Type</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Due</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

            <tr>

                <td colspan="5">
                    <strong>Opening Balance</strong>
                </td>

                <td class="text-right">
                    ₹{{ number_format($openingBalance,2) }}
                </td>

                <td>-</td>

            </tr>

            @foreach($records as $record)

                <tr>

                    <td>
                        {{ date('d-m-Y', strtotime($record->invoice_date)) }}
                    </td>

                    <td>
                        {{ $record->invoice_no }}
                    </td>

                    <td>
                        {{ $record->type }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($record->debit,2) }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($record->credit,2) }}
                    </td>

                    <td class="text-right">
                        ₹{{ number_format($record->due_amount,2) }}
                    </td>

                    <td>
                        {{ ucfirst($record->payment_status) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <!-- Summary -->

    <div class="summary-section">

        <div class="summary-box">

            <div class="summary-row">
                <span>Total Purchase</span>
                <span>
                    ₹{{ number_format($summary['total_purchase'],2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Total Paid</span>
                <span>
                    ₹{{ number_format($summary['total_paid'],2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Total Return</span>
                <span>
                    ₹{{ number_format($summary['total_return'],2) }}
                </span>
            </div>

            <div class="summary-row">
                <span>Total Refund</span>
                <span>
                    ₹{{ number_format($summary['total_refund'],2) }}
                </span>
            </div>

            <div class="summary-row total">

                <strong>Net Due</strong>

                <strong>
                    ₹{{ number_format($summary['net_due'],2) }}
                </strong>

            </div>

        </div>

    </div>

@endsection