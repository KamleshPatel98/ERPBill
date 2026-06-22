@extends('layouts.panel')

@section('title', 'Create/Update Purchase')

@section('content')

    <!-- PAGE HEADER -->
    <div class="card page-card mb-3">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-lg-8">
                    <h4 class="page-title">
                        @if(isset($purchase)) Update Purchase
                        @else Create Purchase
                        @endif
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

    <form action="{{ isset($purchase) ? route('purchases.update', $purchase->id) : route('purchases.store') }}" method="POST">
        @csrf

        @isset($purchase)
            @method('PUT')
        @endisset

        <input type="hidden" name="items_json" id="items_json" />

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
                               value="{{ isset($purchase) ? $purchase->invoice_no : generateNo("Purchase", "PUR") }}" 
                               readonly>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Invoice Date</label>
                        <input type="text"
                               name="invoice_date"
                               class="form-control datepicker"
                               value="{{ old('invoice_date', $purchase->invoice_date ?? date('d-m-Y')) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-select select-dropdown" required>
                            <option value="">Select Supplier</option>

                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id)>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Financial Year</label>
                        <select name="financial_year_id" class="form-select" required>
                            @foreach($financialYears as $year)
                                <option value="{{ $year->id }}" @selected(old('financial_year_id', $purchase->financial_year_id ?? '') == $year->id)>
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
                                <option value="{{ $mode->id }}" @selected(old('payment_mode_id', $purchase->payment_mode_id ?? '') == $mode->id)>
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
                               value="{{ $purchase->paid_amount ?? 0}}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Notes</label>
                        <textarea name="notes"
                                  rows="2"
                                  class="form-control">{{ $purchase->notes ?? ''}}</textarea>
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
                                <th width="10%">Discount</th>
                                <th width="10%">GST%</th>
                                <th width="15%">Amount</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            {{-- <tr>

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
                                           name="items[0][discount]"
                                           class="form-control discount"
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

                            @foreach($purchase->items as $item)
                                <tr>
                                    <td>
                                        <select class="form-select product">
                                            <option value="">Select Product</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" class="form-control qty"
                                            value="{{ $item->qty }}">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control rate"
                                            value="{{ $item->rate }}">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control discount"
                                            value="{{ $item->discount }}">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control gst"
                                            value="{{ $item->gst }}">
                                    </td>

                                    <td>
                                        <input type="number" class="form-control amount"
                                            value="{{ $item->amount }}"
                                            readonly>
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm removeRow">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach --}}

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

@push('script')
    <script>
        let items = [];
        let rowIndex = 0;

        /* =========================
        ADD ROW
        ========================= */
        $("#addRow").on("click", function () {

            rowIndex++;

            let row = `
                <tr>
                    <td>
                        <select class="form-select product">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td><input type="number" class="form-control qty" value="1"></td>
                    <td><input type="number" class="form-control rate" value="0"></td>
                    <td><input type="number" class="form-control discount" value="0"></td>
                    <td>
                        <select class="form-select gst">
                            @foreach($gsts as $gst)
                                <option value="{{ $gst->id }}" data-rate="{{ $gst->rate }}">
                                    {{ $gst->name }} ({{ $gst->rate }}%)
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control amount" value="0" readonly></td>

                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeRow">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;

            $("#purchaseTable tbody").append(row);

            formSelect();
            updateItems();
        });


        /* =========================
        DELETE ROW
        ========================= */
        $(document).on("click", ".removeRow", function () {
            $(this).closest("tr").remove();
            updateItems();
        });


        /* =========================
        UPDATE LOCAL ARRAY
        ========================= */
        function updateItems() {

            items = [];

            let grossAmount = 0;
            let totalGstAmount = 0;
            let totalDiscount = 0;
            let totalAmount = 0;

            $("#purchaseTable tbody tr").each(function () {

                let row = $(this);

                let product_id = row.find(".product").val();

                let qty = parseFloat(row.find(".qty").val()) || 0;
                let rate = parseFloat(row.find(".rate").val()) || 0;
                let gst_id = row.find(".gst").val();
                let gst_percentage = parseFloat(
                    row.find(".gst option:selected").data("rate")
                ) || 0;
                let discount = parseFloat(row.find(".discount").val()) || 0;

                // Gross
                let subTotal = qty * rate;

                // Discount
                let netAmount = subTotal - discount;

                // GST
                let gstAmount = (netAmount * gst_percentage) / 100;

                // Final
                let amount = netAmount + gstAmount;

                row.find(".amount").val(amount.toFixed(2));

                // Summary Totals
                grossAmount += subTotal;
                totalDiscount += discount;
                totalGstAmount += gstAmount;
                totalAmount += amount;

                let item = {
                    product_id: product_id,
                    qty: qty,
                    rate: rate,
                    gst_id: gst_id,
                    gst_percentage: gst_percentage,
                    discount: discount,
                    amount: parseFloat(amount.toFixed(2))
                };

                if (product_id) {
                    items.push(item);
                }
            });

            // Paid Amount
            let paidAmount = parseFloat($("#paid_amount").val()) || 0;

            // Due Amount
            let dueAmount = totalAmount - paidAmount;

            // Update Summary
            $("#grossAmount").text(grossAmount.toFixed(2));
            $("#gstAmount").text(totalGstAmount.toFixed(2));
            $("#discountAmount").text(totalDiscount.toFixed(2));
            $("#totalAmount").text(totalAmount.toFixed(2));
            $("#paidDisplay").text(paidAmount.toFixed(2));
            $("#dueAmount").text(dueAmount.toFixed(2));

            $("#items_json").val(JSON.stringify(items));
        }


        /* =========================
        LIVE UPDATE
        ========================= */
        $(document).on("keyup change", "#purchaseTable input, #purchaseTable select", function () {
            updateItems();
        });


        /* =========================
        FORM SUBMIT
        ========================= */
        $("form").on("submit", function () {
            updateItems();
        });

        $(document).on(
            "keyup change",
            "#purchaseTable input, #purchaseTable select, #paid_amount",
            function () {
                updateItems();
            }
        );

        // EFit time
        let purchaseItems = @json($items ?? []);
        let products = @json($products);
        let gsts = @json($gsts);

        $(document).ready(function () {

            if (purchaseItems.length > 0) {

                $("#purchaseTable tbody").html('');

                purchaseItems.forEach(function(item) {

                    let row = `
                        <tr>
                            <td>
                                <select class="form-select product">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}"
                                            ${item.product_id == {{ $product->id }} ? 'selected' : ''}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="number" class="form-control qty"
                                    value="${item.quantity}">
                            </td>

                            <td>
                                <input type="number" class="form-control rate"
                                    value="${item.price}">
                            </td>

                            <td>
                                <input type="number" class="form-control discount"
                                    value="${item.discount}">
                            </td>

                            <td>
                                <select class="form-select gst">
                                    <option value="">Select GST</option>
                                    @foreach($gsts as $gst)
                                        <option value="{{ $gst->id }}"
                                            data-rate="{{ $gst->rate }}"
                                            ${item.gst_id == {{ $gst->id }} ? 'selected' : ''}>
                                            {{ $gst->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="number"
                                    class="form-control amount"
                                    value="${item.total}"
                                    readonly>
                            </td>

                            <td>
                                <button type="button"
                                        class="btn btn-danger btn-sm removeRow">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;

                    $("#purchaseTable tbody").append(row);
                });

                formSelect();
                updateItems();
            }
        });
    </script>
@endpush

<x-datepicker />
<x-dropdown />