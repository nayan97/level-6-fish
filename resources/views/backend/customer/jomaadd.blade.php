@extends('backend.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endsection


@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>জমা সংযোজন</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('customers_joma.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>পাইকারের নাম</label>
                                    <div class="input-group">
                                        <select name="customer_id"
                                            class="form-control select2 @error('customer_id') is-invalid @enderror"
                                            id="customer_select">
                                            <option value="">পাইকার নির্বাচন করুন</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}"
                                                    {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('customer_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>বর্তমান বাকি</label>
                                    <div class="input-group">
                                        <input type="text" 
                                               id="customer_balance" 
                                               class="form-control balance-display" 
                                               value="" 
                                               readonly
                                               style="background-color: #f8f9fa; font-weight: bold;">
                                        <span class="input-group-text">টাকা</span>
                                    </div>
                                    <small id="balance_warning" class="text-danger d-none">
                                        ⚠️ গ্রাহকের বাকি রয়েছে, জমা দিতে পারেন
                                    </small>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>জমার পরিমাণ</label>
                                    <div class="input-group">
                                        <input type="number" 
                                               step="any" 
                                               name="amount" 
                                               id="joma_amount"
                                               class="form-control @error('amount') is-invalid @enderror"
                                               placeholder="জমার টাকা লিখুন">
                                        <span class="input-group-text">টাকা</span>
                                    </div>
                                    @error('amount')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <small id="amount_error" class="text-danger d-none">
                                        ❌ জমার পরিমাণ বাকি টাকার চেয়ে বেশি হতে পারবে না
                                    </small>
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>তারিখ</label>
                                    <input type="date" 
                                           name="jomardate"
                                           class="form-control @error('jomardate') is-invalid @enderror"
                                           value="{{ old('jomardate', \Carbon\Carbon::now('Asia/Dhaka')->toDateString()) }}">
                                    @error('jomardate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-12">
                                <button type="submit" id="submitBtn" class="btn btn-submit me-2">
                                    Submit
                                </button>
                                <a href="{{ route('customers_joma.index') }}" class="btn btn-cancel">Cancel</a>
                            </div>
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
            $('.select2').select2();
            
            let currentBalance = 0;

            // When customer is selected
            $('#customer_select').on('change', function() {
                let customerId = $(this).val();
                
                if (!customerId) {
                    resetBalance();
                    return;
                }

                // Show loading state
                $('#customer_balance').val('লোড হচ্ছে...');
                
                $.ajax({
                    url: "{{ url('/customer/balance') }}/" + customerId,
                    type: "GET",
                    success: function(res) {
                        currentBalance = parseFloat(res.balance) || 0;
                        
                        // Format the number with commas
                        let formattedBalance = formatNumber(currentBalance);
                        
                        // Set the balance in the input field
                        $('#customer_balance').val(formattedBalance);
                        
                        // Add color based on balance
                        if (currentBalance > 0) {
                            $('#customer_balance').css('color', '#dc3545');
                            $('#balance_warning').removeClass('d-none');
                        } else if (currentBalance === 0) {
                            $('#customer_balance').css('color', '#28a745');
                            $('#balance_warning').addClass('d-none');
                        } else {
                            $('#customer_balance').css('color', '#6c757d');
                            $('#balance_warning').addClass('d-none');
                        }
                        
                        // Validate amount field if it has value
                        validateAmount();
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        $('#customer_balance').val('লোড করতে ব্যর্থ');
                        $('#customer_balance').css('color', '#dc3545');
                        currentBalance = 0;
                        $('#balance_warning').addClass('d-none');
                    }
                });
            });

            // Validate amount when input changes
            $('#joma_amount').on('input', function() {
                validateAmount();
            });

            // Validate amount function
            function validateAmount() {
                let amount = parseFloat($('#joma_amount').val()) || 0;
                
                if (amount > currentBalance) {
                    $('#amount_error').removeClass('d-none');
                    $('#submitBtn').prop('disabled', true);
                } else {
                    $('#amount_error').addClass('d-none');
                    
                    // Also check if customer is selected
                    let customerId = $('#customer_select').val();
                    if (customerId && amount > 0) {
                        $('#submitBtn').prop('disabled', false);
                    } else {
                        $('#submitBtn').prop('disabled', true);
                    }
                }
            }

            // Reset balance function
            function resetBalance() {
                currentBalance = 0;
                $('#customer_balance').val('');
                $('#customer_balance').css('color', '');
                $('#balance_warning').addClass('d-none');
                $('#amount_error').addClass('d-none');
                $('#submitBtn').prop('disabled', true);
            }

            // Format number with commas
            function formatNumber(number) {
                return number.toLocaleString('en-BD', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Disable submit button initially
            $('#submitBtn').prop('disabled', true);

            // Enable/disable submit button based on form validity
            $('form').on('input change', function() {
                let customerId = $('#customer_select').val();
                let amount = $('#joma_amount').val();
                let date = $('input[name="jomardate"]').val();
                
                if (customerId && amount > 0 && date) {
                    let amountNum = parseFloat(amount);
                    if (amountNum <= currentBalance) {
                        $('#submitBtn').prop('disabled', false);
                    } else {
                        $('#submitBtn').prop('disabled', true);
                    }
                } else {
                    $('#submitBtn').prop('disabled', true);
                }
            });

            // If there's a previously selected customer (on form error)
            @if(old('customer_id'))
                $('#customer_select').val({{ old('customer_id') }}).trigger('change');
            @endif
        });
    </script>
@endsection