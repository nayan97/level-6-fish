@extends('backend.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        /* Custom styles to better match the screenshot */
        .form-group label {
            font-weight: 500;
        }

        .card-body {
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .table-responsive {
            margin-top: 15px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }

        .summary-box {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px dashed #e9ecef;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row .label {
            font-weight: 500;
        }

        .summary-row .value {
            font-weight: 600;
        }

        .total-payable {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
            text-align: right;
            margin-top: 15px;
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group .input-group-append .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group .input-group-prepend .btn {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-with-percent {
            display: flex;
        }

        .input-with-percent input[type="number"] {
            flex-grow: 1;
            border-radius: .25rem 0 0 .25rem;
        }

        .input-with-percent .input-group-append {
            margin-left: -1px;
        }

        .input-with-percent .input-group-text {
            border-radius: 0 .25rem .25rem 0;
            background-color: #e9ecef;
            border-left: none;
        }

        .fish-item .col-md-1,
        .expense-item .col-md-1 {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection


<?php
$expensesName = [
    'খাজনা',
    'টেলিফোন',
    'মোবাইল',
    'লাইনম্যান',
    'বাস কুলি',
    'নৌকা ভাড়া',
    'পাইকার ছুটি',
    'বাস ভাড়া',
    'ভ্যান ভাড়া',
    'রিক্সা ভাড়া',
    'বাজার কুলি',
    'বরফ খরচ',
    'সুতলী',
    'খোরাকী',
    'হাত খরচ',
    'সমিতি',
    'দাদন জমা',
    'চাঁদা'
];
?>

@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>আপডেট চালান</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('chalans.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ $chalan->id }}">
                        <div class="row justify-content-between">
                            {{--<div class="col-md-3">
                                <div class="form-group">
                                    <label>পাইকার</label>
                                    <select name="customer_id" class="form-control select2 @error('customer_id') is-invalid @enderror">
                                        <option value="">পাইকার নির্বাচন করুন</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $chalan->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>--}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>মহাজন</label>
                                    <select name="mohajon_id" class="form-control select2 @error('mohajon_id') is-invalid @enderror">
                                        <option value="">মহাজনের নির্বাচন করুন</option>
                                        @foreach($mohajons as $mohajon)
                                            <option value="{{ $mohajon->id }}" {{ old('mohajon_id', $chalan->mohajon_id) == $mohajon->id ? 'selected' : '' }}>{{ $mohajon->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('mohajon_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>ইনভয়েস নম্বর</label>
                                    <input type="text" name="invoice_no" class="form-control @error('invoice_no') is-invalid @enderror"
                                        value="{{ old('invoice_no', $chalan->invoice_no) }}" readonly> {{-- Usually invoice no is readonly --}}
                                    @error('invoice_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>তারিখ</label>
                                    <input type="date" name="chalan_date" class="form-control @error('chalan_date') is-invalid @enderror" value="{{ old('chalan_date', $chalan->chalan_date) }}">
                                    @error('chalan_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-3">পণ্যের তালিকা</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">পণ্য আইটেম</th>
                                        <th style="width: 20%;">পরিমাণ</th>
                                        <th style="width: 20%;">মূল্য</th>
                                        <th style="width: 15%;">মোট মূল্য</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody id="fish-items">
                                    {{-- Loop through existing chalan items or old input if validation fails --}}
                                    @php
                                        $items = old('items', $chalan->chalan_items ?? [[]]); // Assuming chalanItems is the relationship
                                    @endphp
                                    @foreach($items as $index => $item)
                                        <tr class="fish-item">
                                            <td>
                                                <select name="items[{{ $index }}][item_name]"
                                                    class="form-control product-select select2 @error('items.{{ $index }}.item_name') is-invalid @enderror">
                                                    <option value="">পণ্য নির্বাচন করুন</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->name }}" {{ $item->item_name ==  $product->name ? 'selected' : '' }}>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('items.{{ $index }}.item_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    class="form-control item-quantity @error('items.' . $index . '.quantity') is-invalid @enderror" placeholder="পরিমাণ" step="0.01" value="{{ $item['quantity'] ?? $item->quantity ?? '' }}">
                                                @error('items.' . $index . '.quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][unit_price]"
                                                    class="form-control item-unit-price @error('items.' . $index . '.unit_price') is-invalid @enderror" placeholder="মূল্য" step="0.01" value="{{ $item['unit_price'] ?? $item->unit_price ?? '' }}">
                                                @error('items.' . $index . '.unit_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-total-price" readonly
                                                    placeholder="0.00" value="{{ ($item['quantity'] ?? $item->quantity ?? 0) * ($item['unit_price'] ?? $item->unit_price ?? 0) }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger remove-fish">×</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" id="add-fish">+ পণ্য যোগ করুন</button>

                        <h5 class="mt-4">খরচের বিবরণ</h5>
                        <div id="expense-items">
                            {{-- Loop through existing chalan expenses or old input if validation fails --}}
                            @php
                                $expenses = old('expenses', $chalan->chalan_expenses ?? [[]]);
                            @endphp
                            @foreach($expenses as $index => $expense)
                                <div class="row expense-item mt-2">
                                    <div class="col-md-4">
                                        <select name="expenses[{{ $index }}][expense_type]"
                                            class="form-control select2 @error('expenses.{{ $index }}.expense_type') is-invalid @enderror">
                                            <option value="">খরচ নির্বাচন করুন</option>
                                            @foreach($expensesName as $expenseName)
                                                <option value="{{ $expenseName }}" {{ $expense->expense_type == $expenseName ? 'selected' : '' }}>{{ $expenseName }}</option>
                                            @endforeach
                                        </select>
                                        @error('expenses.' . $index . '.expense_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="expenses[{{ $index }}][amount]" class="form-control expense-amount @error('expenses.' . $index . '.amount') is-invalid @enderror"
                                            placeholder="টাকা" step="0.01" value="{{ $expense['amount'] ?? $expense->amount ?? '' }}">
                                        @error('expenses.' . $index . '.amount')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-expense">×</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" id="add-expense">+ খরচ যোগ করুন</button>


                        <div class="row mt-4 justify-content-end">
                            <div class="col-md-6">
                                <div class="summary-box">
                                    {{--<div class="summary-row">
                                        <span class="label">ডিসকাউন্ট</span>
                                        <span class="value d-flex align-items-center">
                                            <input type="number" step="0.01" name="overall_discount_amount"
                                                class="form-control text-right @error('overall_discount_amount') is-invalid @enderror" placeholder="0" id="overall-discount-amount"
                                                style="width: 100px;" value="{{ old('overall_discount_amount', $chalan->discount_amount) }}">
                                            <input type="number" step="0.01" name="overall_discount_percent"
                                                class="form-control text-right ml-1 @error('overall_discount_percent') is-invalid @enderror" placeholder="%"
                                                id="overall-discount-percent" style="width: 100px;" value="{{ old('overall_discount_percent', $chalan->discount_percent) }}">
                                            <span class="ml-2">৳</span>
                                        </span>
                                        @error('overall_discount_amount')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('overall_discount_percent')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">ভ্যাট</span>
                                        <span class="value d-flex align-items-center">
                                            <input type="number" step="0.01" name="overall_vat_amount"
                                                class="form-control text-right @error('overall_vat_amount') is-invalid @enderror" placeholder="0" id="overall-vat-amount"
                                                style="width: 100px;" value="{{ old('overall_vat_amount', $chalan->vat_amount) }}">
                                            <input type="number" step="0.01" name="overall_vat_percent"
                                                class="form-control text-right ml-1 @error('overall_vat_percent') is-invalid @enderror" placeholder="%"
                                                id="overall-vat-percent" style="width: 100px;" value="{{ old('overall_vat_percent', $chalan->vat_percent) }}">
                                            <span class="ml-2">৳</span>
                                        </span>
                                        @error('overall_vat_amount')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('overall_vat_percent')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>--}}
                                    
                                    <div class="summary-row">
                                        <span class="label">কমিশন</span>
                                        <span class="value d-flex align-items-center">
                                            <input type="number" step="0.01" name="commission_amount"
                                                class="form-control text-right @error('commission_amount') is-invalid @enderror"
                                                placeholder="0" id="commission_amount" style="width: 100px;"
                                                value="{{ old('commission_amount', $chalan->commission_amount) }}">
                                            <input type="number" step="0.01" name="commission_percent"
                                                class="form-control text-right ml-1 @error('commission_percent') is-invalid @enderror"
                                                placeholder="%" id="commission_percent" style="width: 100px;"
                                                value="{{ old('commission_percent', $chalan->commission_percent) }}">
                                            <span class="ml-2">৳</span>
                                        </span>
                                        @error('commission_amount')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('commission_percent')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">যাবতীয় খরচ</span>
                                        <span class="value" id="total-expenses-display">৳ {{ old('total_expenses_amount', $chalan->total_expense ?? '0.00') }}</span>
                                        <input type="hidden" name="total_expenses_amount" id="total-expenses-amount-hidden" value="{{ old('total_expenses_amount', $chalan->total_expense) }}">
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">কাঁচা বিক্রয়</span>
                                        <span class="value" id="sub-total-display">৳ {{ old('sub_total', $chalan->subtotal ?? '0.00') }}</span>
                                        <input type="hidden" name="sub_total" id="sub-total-hidden" value="{{ old('sub_total', $chalan->subtotal) }}">
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">পাকা বিক্রয়</span>
                                        <span class="value" id="grand-total-display">৳ {{ old('grand_total', $chalan->total_amount ?? '0.00') }}</span>
                                        <input type="hidden" name="grand_total" id="grand-total-hidden" value="{{ old('grand_total', $chalan->total_amount) }}">
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">পেমেন্ট</span>
                                        <input type="number" step="0.01" name="payment_amount"
                                            class="form-control text-right @error('payment_amount') is-invalid @enderror" placeholder="0" id="payment-amount"
                                            style="width: 100px;" value="{{ old('payment_amount', $chalan->payment_amount) }}">
                                        @error('payment_amount')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="total-payable">
                                পেমেন্ট: <span id="payment-display">৳ {{ old('payment_amount', $chalan->payment_amount ?? '0.00') }}</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-submit">আপডেট করুন</button>
                            <a href="{{ route('chalans.index') }}" class="btn btn-cancel">বাতিল</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Initialize select2
            $('.select2').select2();

            let itemIndex = 1;
            let expenseIndex = 1; // Keep track of expense index

            function calculateItemTotal(row) {
                const quantity = parseFloat(row.find('.item-quantity').val()) || 0;
                const unitPrice = parseFloat(row.find('.item-unit-price').val()) || 0;
                let itemTotal = quantity * unitPrice;

                // No individual item discount or VAT calculations anymore

                row.find('.item-total-price').val(itemTotal.toFixed(2));
                calculateGrandTotal();
            }

            function calculateGrandTotal() {
                let subTotal = 0;
                $('.fish-item').each(function () {
                    const itemTotalPrice = parseFloat($(this).find('.item-total-price').val()) || 0;
                    subTotal += itemTotalPrice;
                });

                // কমিশন হিসাব হবে Subtotal থেকে
                let commissionAmount = parseFloat($('#commission_amount').val()) || 0;
                let commissionPercent = parseFloat($('#commission_percent').val()) || 0;

                if (commissionPercent > 0) {
                    commissionAmount = subTotal * (commissionPercent / 100);
                    $('#commission_amount').val(commissionAmount.toFixed(2));
                } else if (commissionAmount > 0) {
                    commissionPercent = (commissionAmount / subTotal) * 100;
                    if (isNaN(commissionPercent)) commissionPercent = 0;
                    $('#commission_percent').val(commissionPercent.toFixed(2));
                }

                // খরচের বিবরণ
                let expensesOnly = 0;
                $('.expense-amount').each(function () {
                    expensesOnly += parseFloat($(this).val()) || 0;
                });

                // মোট খরচ = খরচ + কমিশন
                let totalExpenses = expensesOnly + commissionAmount;
                $('#total-expenses-amount-hidden').val(totalExpenses.toFixed(2));
                $('#total-expenses-display').text('৳ ' + totalExpenses.toFixed(2));

                // পরিশোধযোগ্য = Subtotal - TotalExpenses
                let grandTotal = subTotal - totalExpenses;

                // Hidden & Display সেট করা
                $('#sub-total-hidden').val(subTotal.toFixed(2));
                $('#sub-total-display').text('৳ ' + subTotal.toFixed(2));

                $('#grand-total-hidden').val(grandTotal.toFixed(2));
                $('#grand-total-display').text('৳ ' + grandTotal.toFixed(2));

                const paymentAmount = parseFloat($('#payment-amount').val()) || 0;
                $('#payment-display').text('৳ ' + paymentAmount.toFixed(2));
            }


            // Initial calculation on page load
            calculateGrandTotal();

            // Event listeners for changes
            $(document).on('input', '.item-quantity, .item-unit-price', function () { // Removed item-level discount/vat listeners
                calculateItemTotal($(this).closest('.fish-item'));
            });

            $(document).on('input', '#overall-discount-amount, #overall-discount-percent, #overall-vat-amount, #overall-vat-percent,#commission_amount, #commission_percent, #delivery-charge, #payment-amount', function () {
                calculateGrandTotal();
            });

            $(document).on('input', '.expense-amount', function () {
                calculateGrandTotal(); // Recalculate if expense amounts change
            });


            // Handle percentage/amount synchronization for overall discount
            $('#overall-discount-amount').on('input', function () {
                const amount = parseFloat($(this).val()) || 0;
                const grandTotalBeforeOverallDiscount = parseFloat($('#sub-total').text().replace('৳ ', '')) || 0;
                if (grandTotalBeforeOverallDiscount > 0) {
                    const percent = (amount / grandTotalBeforeOverallDiscount) * 100;
                    $('#overall-discount-percent').val(percent.toFixed(2));
                } else {
                    $('#overall-discount-percent').val('0.00');
                }
                calculateGrandTotal();
            });

            $('#overall-discount-percent').on('input', function () {
                const percent = parseFloat($(this).val()) || 0;
                const grandTotalBeforeOverallDiscount = parseFloat($('#sub-total').text().replace('৳ ', '')) || 0;
                const amount = grandTotalBeforeOverallDiscount * (percent / 100);
                $('#overall-discount-amount').val(amount.toFixed(2));
                calculateGrandTotal();
            });

            // Handle percentage/amount synchronization for overall VAT
            $('#overall-vat-amount').on('input', function () {
                const amount = parseFloat($(this).val()) || 0;
                // For VAT calculation, we often use the sub-total after discount but before VAT
                let currentGrandTotal = parseFloat($('#sub-total').text().replace('৳ ', '')) || 0;
                const overallDiscountAmount = parseFloat($('#overall-discount-amount').val()) || 0;
                currentGrandTotal -= overallDiscountAmount; // Apply discount first

                if (currentGrandTotal > 0) {
                    const percent = (amount / currentGrandTotal) * 100;
                    $('#overall-vat-percent').val(percent.toFixed(2));
                } else {
                    $('#overall-vat-percent').val('0.00');
                }
                calculateGrandTotal();
            });

            $('#overall-vat-percent').on('input', function () {
                const percent = parseFloat($(this).val()) || 0;
                let currentGrandTotal = parseFloat($('#sub-total').text().replace('৳ ', '')) || 0;
                const overallDiscountAmount = parseFloat($('#overall-discount-amount').val()) || 0;
                currentGrandTotal -= overallDiscountAmount; // Apply discount first

                const amount = currentGrandTotal * (percent / 100);
                $('#overall-vat-amount').val(amount.toFixed(2));
                calculateGrandTotal();
            });


            // Handle percentage/amount synchronization for commission
            $('#commission_amount').on('input', function () {
                const amount = parseFloat($(this).val()) || 0;
                // For VAT calculation, we often use the sub-total after discount but before VAT
                let currentGrandTotal = parseFloat($('#sub-total').text().replace('৳ ', '')) || 0;
                const overallDiscountAmount = parseFloat($('#overall-discount-amount').val()) || 0;
                currentGrandTotal -= overallDiscountAmount; // Apply discount first

                if (currentGrandTotal > 0) {
                    const percent = (amount / currentGrandTotal) * 100;
                    $('#commission_percent').val(percent.toFixed(2));
                } else {
                    $('#commission_percent').val('0.00');
                }
                calculateGrandTotal();
            });

            $('#commission_percent').on('input', function () {
                const percent = parseFloat($(this).val()) || 0;
                let currentGrandTotal = parseFloat($('#sub-total').text().replace('৳ ', '')) || 0;
                const overallDiscountAmount = parseFloat($('#overall-discount-amount').val()) || 0;
                currentGrandTotal -= overallDiscountAmount; // Apply discount first

                const amount = currentGrandTotal * (percent / 100);
                $('#commission_amount').val(amount.toFixed(2));
                calculateGrandTotal();
            });


            // Add new fish item
            $('#add-fish').click(function () {
                const item = `
                    <tr class="fish-item">
                        <td>
                            <select name="items[${itemIndex}][item_name]" class="form-control product-select select2">
                                <option value="">পণ্য নির্বাচন করুন</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->name }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[${itemIndex}][quantity]" class="form-control item-quantity"
                                placeholder="পরিমাণ" step="0.01">
                        </td>
                        <td>
                            <input type="number" name="items[${itemIndex}][unit_price]" class="form-control item-unit-price"
                                placeholder="মূল্য" step="0.01">
                        </td>
                        <td>
                            <input type="text" class="form-control item-total-price" readonly placeholder="0.00">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-fish">×</button>
                        </td>
                    </tr>`;
                $('#fish-items').append(item);
                itemIndex++;
            });

            // Remove fish item
            $(document).on('click', '.remove-fish', function () {
                $(this).closest('.fish-item').remove();
                calculateGrandTotal(); // Recalculate after removing an item
            });

            // Add new expense item
            $('#add-expense').click(function () {
                const item = `
                    <div class="row expense-item mt-2">
                        <div class="col-md-4">
                            <select name="expenses[${expenseIndex}][expense_type]" class="form-control select2-add">
                                <option value="">খরচ নির্বাচন করুন</option>
                                @foreach($expensesName as $expenseName)
                                    <option value="{{ $expenseName }}">{{ $expenseName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="expenses[${expenseIndex}][amount]" class="form-control expense-amount" placeholder="টাকা" step="0.01">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger remove-expense">×</button>
                        </div>
                    </div>`;
                $('#expense-items').append(item);
                expenseIndex++;
            });

            // Remove expense item
            $(document).on('click', '.remove-expense', function () {
                $(this).closest('.expense-item').remove();
                calculateGrandTotal(); // Recalculate after removing an expense
            });
        });
    </script>
@endsection