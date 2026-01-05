@extends('backend.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
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
$expensesName = ['খাজনা', 'টেলিফোন', 'মোবাইল', 'লাইনম্যান', 'বাস কুলি', 'নৌকা ভাড়া', 'পাইকার ছুট', 'বাস ভাড়া', 'ভ্যান ভাড়া', 'রিক্সা ভাড়া', 'বাজার কুলি', 'বরফ খরচ', 'সুতলী', 'খোরাকী', 'হাত খরচ', 'সমিতি', 'দাদন জমা', 'চাঁদা'];
?>


@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>নতুন চালান</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal"
                        action="{{ route('chalans.chalanStore', [$mohajon_id ?? request('mohajon_id'), $date ?? request('date')]) }}"
                        method="POST">
                        @csrf

                        <!-- Correct Hidden Inputs -->
                        <input type="hidden" name="url_datetime" value="{{ $date ?? request('date') }}">
                        <input type="hidden" name="url_mohajon_id" value="{{ $mohajon_id ?? request('mohajon_id') }}">

                        <div class="row justify-content-between">


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>মহাজন</label>
                                    <div class="input-group">
                                        <select name="mohajon_id"
                                            class="form-control @error('mohajon_id') is-invalid @enderror">
                                            <option value="{{ $header['mohajon_id'] }}">{{ $header['mohajon_name'] }}
                                            </option>
                                        </select>
                                        @error('mohajon_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>ইনভয়েস নম্বর</label>
                                    <input type="text" name="invoice_no"
                                        class="form-control @error('invoice_no') is-invalid @enderror"
                                        value="{{ $invoice_no }}" readonly>
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
                                    <input type="date" name="chalan_date"
                                        class="form-control @error('chalan_date') is-invalid @enderror"
                                        value="{{ old('chalan_date', date('Y-m-d')) }}">
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
                                        $items = old('items', $chalanItems ?? [[]]); // Assuming chalanItems is the relationship
                                    @endphp
                                    @foreach ($items as $index => $item)
                                        <tr class="fish-item">
                                            {{-- <td>
                                                <select name="items[{{ $index }}][item_name]"
                                                    class="form-control product-select select2 @error('items.{{ $index }}.item_name') is-invalid @enderror">
                                                    <option value="">পণ্য নির্বাচন করুন</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->name }}" {{ $item->item_name ==  $product->name ? 'selected' : '' }}>{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('items.{{ $index }}.item_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td> --}}
                                            <td>
                                                <input type="text" name="items[{{ $index }}][item_name]"
                                                    class="form-control product-select @error('items.' . $index . '.item_name') is-invalid @enderror"
                                                    value="{{ $item['product_name'] ?? ($item->product_name ?? '') }}"
                                                    readonly>
                                                @error('items.' . $index . '.item_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    class="form-control item-quantity @error('items.' . $index . '.quantity') is-invalid @enderror"
                                                    placeholder="পরিমাণ" step="0.01"
                                                    value="{{ $item['quantity'] ?? ($item->quantity ?? '') }}">
                                                @error('items.' . $index . '.quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="number" name="items[{{ $index }}][unit_price]"
                                                    class="form-control item-unit-price @error('items.' . $index . '.unit_price') is-invalid @enderror"
                                                    placeholder="মূল্য" step="0.01"
                                                    value="{{ $item['amount'] ?? ($item->amount ?? '') }}">
                                                @error('items.' . $index . '.unit_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-total-price" readonly
                                                    placeholder="0.00"
                                                    value="{{ ($item['quantity'] ?? ($item->quantity ?? 0)) * ($item['amount'] ?? ($item->amount ?? 0)) }}">
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
                            {{-- Iterate through old input or provide a default empty row --}}
                            @if (old('expenses'))
                                @foreach (old('expenses') as $index => $expense)
                                    <div class="row expense-item mt-2">
                                        <div class="col-md-4">
                                            <select name="expenses[{{ $index }}][expense_type]"
                                                class="form-control select2 @error('expenses.{{ $index }}.expense_type') is-invalid @enderror">
                                                <option value="">খরচ নির্বাচন করুন</option>
                                                @foreach ($expensesName as $expenseName)
                                                    <option value="{{ $expenseName }}"
                                                        {{ old('expenses.' . $index . '.expense_type') == $expenseName ? 'selected' : '' }}>
                                                        {{ $expenseName }}</option>
                                                @endforeach
                                            </select>
                                            @error('expenses.' . $index . '.expense_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="expenses[{{ $index }}][amount]"
                                                class="form-control expense-amount @error('expenses.' . $index . '.amount') is-invalid @enderror"
                                                placeholder="টাকা" step="0.01"
                                                value="{{ $expense['amount'] ?? '' }}">
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
                            @else
                                <div class="row expense-item mt-2">
                                    <div class="col-md-4">
                                        <select name="expenses[0][expense_type]" class="form-control select2">
                                            <option value="">খরচ নির্বাচন করুন</option>
                                            @foreach ($expensesName as $expenseName)
                                                <option value="{{ $expenseName }}">{{ $expenseName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="expenses[0][amount]"
                                            class="form-control expense-amount" placeholder="টাকা" step="0.01">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger remove-expense">×</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" id="add-expense">+ খরচ যোগ করুন</button>

                        <div class="row mt-4 justify-content-end">
                            <div class="col-md-6">
                                <div class="summary-box">

                                    <div class="summary-row">
                                        <span class="label">কমিশন</span>
                                        <span class="value d-flex align-items-center">
                                            <input type="number" step="0.01" name="commission_amount"
                                                class="form-control text-right @error('commission_amount') is-invalid @enderror"
                                                placeholder="0" id="commission_amount" style="width: 100px;"
                                                value="{{ old('commission_amount') }}">
                                            <input type="number" step="0.01" name="commission_percent"
                                                class="form-control text-right ml-1 @error('commission_percent') is-invalid @enderror"
                                                placeholder="%" id="commission_percent" style="width: 100px;"
                                                value="{{ old('commission_percent') }}">
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
                                        <span class="value" id="total-expenses-display">৳
                                            {{ old('total_expenses_amount', '0.00') }}</span>
                                        <input type="hidden" name="total_expenses_amount"
                                            id="total-expenses-amount-hidden" value="{{ old('total_expenses_amount') }}">
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">কাঁচা বিক্রয়</span>
                                        <span class="value" id="sub-total-display">৳
                                            {{ old('sub_total', '0.00') }}</span>
                                        <input type="hidden" name="sub_total" id="sub-total-hidden"
                                            value="{{ old('sub_total') }}">
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">পাকা বিক্রয়</span>
                                        <span class="value" id="grand-total-display">৳
                                            {{ old('grand_total', '0.00') }}</span>
                                        <input type="hidden" name="grand_total" id="grand-total-hidden"
                                            value="{{ old('grand_total') }}">
                                    </div>
                                    <div class="summary-row">
                                        <span class="label">নগদ পেমেন্ট</span>
                                        <input type="number" step="0.01" name="payment_amount"
                                            class="form-control text-right @error('payment_amount') is-invalid @enderror"
                                            placeholder="0" id="payment-amount" style="width: 100px;"
                                            value="{{ old('payment_amount') }}">
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
                                পেমেন্ট: <span id="payment-display">৳ {{ old('payment_amount', '0.00') }}</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-submit">সাবমিট করুন</button>
                            <a href="{{ route('daily.index') }}" class="btn btn-cancel">বাতিল</a>
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
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2();

            let itemIndex = {{ old('items') ? count(old('items')) : 1 }};
            let expenseIndex = {{ old('expenses') ? count(old('expenses')) : 1 }};

            function calculateItemTotal(row) {
                const quantity = parseFloat(row.find('.item-quantity').val()) || 0;
                const unitPrice = parseFloat(row.find('.item-unit-price').val()) || 0;
                let itemTotal = quantity * unitPrice;

                row.find('.item-total-price').val(itemTotal.toFixed(2));
                calculateGrandTotal();
            }

            function calculateGrandTotal() {
                let subTotal = 0;
                $('.fish-item').each(function() {
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
                $('.expense-amount').each(function() {
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

            // Set default 3% commission on page load if not already set, then calculate totals.
            if ($('#commission_percent').val() === '' || $('#commission_percent').val() === null) {
                $('#commission_percent').val('3.00').trigger('input');
            } else {
                calculateGrandTotal();
            }


            // --- Event Listeners ---

            // For item rows
            $(document).on('input', '.item-quantity, .item-unit-price', function() {
                calculateItemTotal($(this).closest('.fish-item'));
            });

            // For expenses
            $(document).on('input', '.expense-amount', function() {
                calculateGrandTotal();
            });

            // For payment amount
            $('#payment-amount').on('input', function() {
                calculateGrandTotal();
            });

            // --- Sync Handlers for Percentage/Amount fields ---

            // NEW Commission Sync Logic (based on Sub Total)
            $('#commission_percent').on('input', function() {
                const percent = parseFloat($(this).val()) || 0;
                const subTotal = parseFloat($('#sub-total-hidden').val()) || 0;
                const amount = subTotal * (percent / 100);
                $('#commission_amount').val(amount.toFixed(2));
                calculateGrandTotal();
            });

            $('#commission_amount').on('input', function() {
                const amount = parseFloat($(this).val()) || 0;
                const subTotal = parseFloat($('#sub-total-hidden').val()) || 0;
                if (subTotal > 0) {
                    const percent = (amount / subTotal) * 100;
                    $('#commission_percent').val(percent.toFixed(2));
                } else {
                    $('#commission_percent').val('0.00');
                }
                calculateGrandTotal();
            });

            // Discount and VAT sync logic (disconnected from grand total as per request)
            $('#overall-discount-percent').on('input', function() {
                const percent = parseFloat($(this).val()) || 0;
                const subTotal = parseFloat($('#sub-total-hidden').val()) || 0;
                $('#overall-discount-amount').val((subTotal * (percent / 100)).toFixed(2));
            });
            $('#overall-discount-amount').on('input', function() {
                const amount = parseFloat($(this).val()) || 0;
                const subTotal = parseFloat($('#sub-total-hidden').val()) || 0;
                if (subTotal > 0) {
                    $('#overall-discount-percent').val(((amount / subTotal) * 100).toFixed(2));
                } else {
                    $('#overall-discount-percent').val('0.00');
                }
            });
            $('#overall-vat-percent').on('input', function() {
                const percent = parseFloat($(this).val()) || 0;
                const subTotal = parseFloat($('#sub-total-hidden').val()) || 0;
                $('#overall-vat-amount').val((subTotal * (percent / 100)).toFixed(2));
            });
            $('#overall-vat-amount').on('input', function() {
                const amount = parseFloat($(this).val()) || 0;
                const subTotal = parseFloat($('#sub-total-hidden').val()) || 0;
                if (subTotal > 0) {
                    $('#overall-vat-percent').val(((amount / subTotal) * 100).toFixed(2));
                } else {
                    $('#overall-vat-percent').val('0.00');
                }
            });


            // Add new fish item
            $('#add-fish').click(function() {
                const item = `
                    <tr class="fish-item">
                        <td>
                            <select name="items[${itemIndex}][item_name]" class="form-control product-select select2-add">
                                <option value="">পণ্য নির্বাচন করুন</option>
                                @foreach ($products as $product)
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
                $('.select2-add').select2(); // Re-initialize select2 for the new element
                itemIndex++;
            });

            // Remove fish item
            $(document).on('click', '.remove-fish', function() {
                $(this).closest('.fish-item').remove();
                calculateGrandTotal(); // Recalculate after removing an item
            });

            // Add new expense item
            $('#add-expense').click(function() {
                const item = `
                    <div class="row expense-item mt-2">
                        <div class="col-md-4">
                            <select name="expenses[${expenseIndex}][expense_type]" class="form-control select2-add">
                                <option value="">খরচ নির্বাচন করুন</option>
                                @foreach ($expensesName as $expenseName)
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
                $('.select2-add').select2(); // Re-initialize select2 for the new element
                expenseIndex++;
            });

            // Remove expense item
            $(document).on('click', '.remove-expense', function() {
                $(this).closest('.expense-item').remove();
                calculateGrandTotal(); // Recalculate after removing an expense
            });
        });
    </script>
@endsection
