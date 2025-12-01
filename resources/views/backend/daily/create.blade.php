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


@section('content')

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>নতুন দৈনিক ক্রয়</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('daily.store') }}" method="POST">
                        @csrf
                        <div class="row justify-content-between">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>মহাজন</label>
                                    <div class="input-group">
                                        <select name="mohajon_id"
                                            class="form-control select2 @error('mohajon_id') is-invalid @enderror">
                                            <option value="">মহাজন নির্বাচন করুন</option>
                                            @foreach ($mohajons as $mohajon)
                                                <option value="{{ $mohajon->id }}"
                                                    {{ old('mohajon_id') == $mohajon->id ? 'selected' : '' }}>
                                                    {{ $mohajon->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#mohajonModal">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>

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


                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <h5 class="mb-0">পণ্যের তালিকা</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#customerModal">
                                পাইকার সংযোজন
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 18%;">পাইকার</th>
                                        <th style="width: 18%;">পণ্য আইটেম</th>
                                        <th style="width: 18%;">মূল্য</th>
                                        <th style="width: 18%;">পরিমাণ</th>
                                        <th style="width: 15%;">মোট মূল্য</th>
                                        <th style="width: 20%;">পেমেন্ট</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="fish-items">
                                    {{-- Iterate through old input or provide a default empty row --}}
                                    @if (old('items'))
                                        @foreach (old('items') as $index => $item)
                                            <tr class="fish-item">

                                                <td>
                                                    <select name="items[{{ $index }}][paikar_name]"
                                                        class="form-control product-select select2 @error('items.{{ $index }}.paikar_name') is-invalid @enderror">
                                                        <option value="">পাইকার</option>
                                                        @foreach ($customers as $customer)
                                                            <option value="{{ $customer->id }}"
                                                                {{ old('items.' . $index . '.paikar_name') == $customer->name ? 'selected' : '' }}>
                                                                {{ $customer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('items.{{ $index }}.paikar_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <select name="items[{{ $index }}][item_name]"
                                                        class="form-control product-select select2 @error('items.{{ $index }}.item_name') is-invalid @enderror">
                                                        <option value="">পণ্য নির্বাচন করুন</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ old('items.' . $index . '.item_name') == $product->name ? 'selected' : '' }}>
                                                                {{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('items.{{ $index }}.item_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </td>

                                                <td>
                                                    <input type="number" name="items[{{ $index }}][unit_price]"
                                                        class="form-control item-unit-price @error('items.' . $index . '.unit_price') is-invalid @enderror"
                                                        placeholder="মূল্য" step="0.01"
                                                        value="{{ $item['unit_price'] ?? '' }}">
                                                    @error('items.' . $index . '.unit_price')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][quantity]"
                                                        class="form-control item-quantity @error('items.' . $index . '.quantity') is-invalid @enderror"
                                                        placeholder="পরিমাণ" step="0.01"
                                                        value="{{ $item['quantity'] ?? '' }}">
                                                    @error('items.' . $index . '.quantity')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control item-total-price" readonly
                                                        placeholder="0.00"
                                                        value="{{ ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0) }}">
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control"
                                                        name="items[{{ $index }}][payment_amount]" placeholder="0"
                                                        value="0">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-fish">×</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="fish-item">

                                            <td>
                                                <select name="items[0][paikar_name]"
                                                    class="form-control product-select select2">
                                                    <option value="">পাইকার</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <select name="items[0][item_name]"
                                                    class="form-control product-select select2">
                                                    <option value="">পণ্য নির্বাচন করুন</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                <input type="number" name="items[0][unit_price]"
                                                    class="form-control item-unit-price" placeholder="মূল্য"
                                                    step="0.01">
                                            </td>
                                            <td>
                                                <input type="number" name="items[0][quantity]"
                                                    class="form-control item-quantity" placeholder="পরিমাণ"
                                                    step="0.01">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control item-total-price" readonly
                                                    placeholder="0.00">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control"
                                                    name="items[0][payment_amount]" placeholder="0" value="0">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger remove-fish">×</button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" id="add-fish">+ পণ্য যোগ করুন</button>

                        <div class="d-flex justify-content-between align-items-start mt-4">
                            <div>
                                <button type="submit" class="btn btn-submit">সাবমিট করুন</button>
                                <a href="{{ route('daily.index') }}" class="btn btn-cancel">বাতিল</a>
                            </div>
                            <div class="summary-box" style="min-width:300px;">
                                <h6>পাইকার মোট টাকা</h6>
                                <div id="paikar-summary"></div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <!-- Customer Create Modal -->
    <!-- Customer Create Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">নতুন পাইকার যোগ করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="ajax-customer-form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>পাইকারের নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>মোবাইল নং <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" required>
                        </div>

                        <div class="form-group mt-3">
                            <label>ঠিকানা</label>
                            <textarea class="form-control" name="address"></textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label>জের</label>
                            <input type="number" name="jer" class="form-control" value="0">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Mohajon Create Modal -->
    <div class="modal fade" id="mohajonModal" tabindex="-1" aria-labelledby="mohajonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mohajonModalLabel">নতুন মহাজন যোগ করুন</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('mohajons.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="mohajon_name_modal">্মহাজনের নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mohajon_name_modal" name="name" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="mohajon_phone_modal">মোবাইল নং <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mohajon_phone_modal" name="phone" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="mohajon_address_modal">ঠিকানা</label>
                            <textarea class="form-control" id="mohajon_address_modal" name="address"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল</button>
                    </div>
                </form>
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

            let itemIndex = 1;
            let expenseIndex = 1; // Keep track of expense index

            function calculateItemTotal(row) {
                const quantity = parseFloat(row.find('.item-quantity').val()) || 0;
                const unitPrice = parseFloat(row.find('.item-unit-price').val()) || 0;
                let itemTotal = quantity * unitPrice;

                row.find('.item-total-price').val(itemTotal.toFixed(2));
                calculateGrandTotal();
            }

            function calculateGrandTotal() {
                let paikarTotals = {};
                let subTotal = 0;
                $('.fish-item').each(function() {
                    const paikarId = $(this).find('select[name*="[paikar_name]"]').val();
                    const itemTotalPrice = parseFloat($(this).find('.item-total-price').val()) || 0;
                    subTotal += itemTotalPrice;

                    if (paikarId) {
                        if (!paikarTotals[paikarId]) {
                            paikarTotals[paikarId] = {
                                total: 0,
                                name: $(this).find('select[name*="[paikar_name]"] option:selected')
                                    .text()
                            };
                        }
                        paikarTotals[paikarId].total += itemTotalPrice;
                    }
                });

                let summaryHtml = '';
                $.each(paikarTotals, function(paikarId, data) {
                    summaryHtml += `
                        <div class="summary-row">
                            <span class="label">${data.name}</span>
                            <span class="value">৳ ${data.total.toFixed(2)}</span>
                            {{-- <input type="number" name="payments[${paikarId}]" 
                                class="form-control w-50" placeholder="পেমেন্টের পরিমান"> --}}
                        </div>
                    `;
                });

                $('#paikar-summary').html(summaryHtml);

            }

            // Initial calculation on page load
            calculateGrandTotal();

            // Event listeners for changes
            $(document).on('input', '.item-quantity, .item-unit-price',
                function() { // Removed item-level discount/vat listeners
                    calculateItemTotal($(this).closest('.fish-item'));
                });

            // Add new fish item
            $('#add-fish').click(function() {
                const item = `
                    <tr class="fish-item">


                          <td>
                            <select name="items[${itemIndex}][paikar_name]" class="form-control product-select select2">
                                                <option value="">পাইকার</option>
                                                @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                </select>
                            </td>

            <td>
                <select name="items[${itemIndex}][item_name]" class="form-control product-select select2">
                                <option value="">পণ্য নির্বাচন করুন</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        
                        <td>
                            <input type="number" name="items[${itemIndex}][unit_price]" class="form-control item-unit-price"
                                placeholder="মূল্য" step="0.01">
                        </td>
                        <td>
                            <input type="number" name="items[${itemIndex}][quantity]" class="form-control item-quantity"
                                placeholder="পরিমাণ" step="0.01">
                        </td>
                        <td>
                            <input type="text" class="form-control item-total-price" readonly placeholder="0.00">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="items[${itemIndex}][payment_amount]"
                                placeholder="পেমেন্ট পরিমাণ"
                                value="0">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-fish">×</button>
                        </td>
                    </tr>`;
                $('#fish-items').append(item);
                itemIndex++;
            });

            // Remove fish item
            $(document).on('click', '.remove-fish', function() {
                $(this).closest('.fish-item').remove();
                calculateGrandTotal(); // Recalculate after removing an item
            });
        });


        $(document).ready(function() {

            // AJAX submit for adding new paikar
            $('#ajax-customer-form').submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('customers.store') }}",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },

                    success: function(res) {
                        console.log("SUCCESS RESPONSE:", res); // DEBUG

                        // Close modal
                        $('#customerModal').modal('hide');

                        // Add new paikar to ALL paikar dropdowns
                        $('select[name^="items"][name$="[paikar_name]"]').each(function() {
                            $(this).append(
                                `<option value="${res.customer.id}">${res.customer.name}</option>`
                            );
                        });

                        // Refresh Select2
                        $('.select2').select2();

                        // Auto-select new paikar in last row
                        let lastRow = $('#fish-items tr:last');
                        lastRow.find('select[name^="items"][name$="[paikar_name]"]')
                            .val(res.customer.id)
                            .trigger('change');

                        // Success message
                        Swal.fire({
                            icon: 'success',
                            title: 'পাইকার সংযোজন সম্পন্ন',
                            timer: 1500
                        });
                    },

                    error: function(err) {
                        console.log("ERROR RESPONSE:", err); // DEBUG

                        let msg = 'কিছু ভুল হয়েছে';

                        if (err.status === 419) {
                            msg = "CSRF টোকেন মেয়াদোত্তীর্ণ হয়েছে!";
                        } else if (err.status === 401) {
                            msg = "আপনি লগইন করেননি! (Unauthenticated)";
                        } else if (err.responseJSON && err.responseJSON.errors) {
                            msg = Object.values(err.responseJSON.errors)
                                .map(v => v.join(', '))
                                .join('\n');
                        } else if (err.responseJSON && err.responseJSON.message) {
                            msg = err.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: msg,
                        });
                    }
                });
            });



        });
    </script>
@endsection
