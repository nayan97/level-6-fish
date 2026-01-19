@extends('backend.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endsection


@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>দৈনিক ক্যাশ ক্লোজ</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form class="form-horizontal" action="{{ route('cash.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group mb-3">
                                    <label>ক্যাশ:</label>
                                    <input type="number" name="cash" id="cash" class="form-control calculatable-left" value="{{ $totalcash }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label>আজকের কমিশন:</label>
                                    <input type="number" name="commission" id="commission" class="form-control calculatable-left" value="{{ $todaycommission }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label>গতকালের পাইকার বাকি:</label>
                                    <input type="number" name="goto_kaler_baki" id="goto_kaler_baki" class="form-control calculatable-left" value="{{ $gotokalerpaikarBaki }}" readonly>
                                </div>
                                <div class="form-group mb-3">
                                    <label>আজকের আমানত:</label>
                                    <input type="number" name="ajker_amanot" id="ajker_amanot" class="form-control calculatable-left" value="{{ $todayamanot }}" readonly>
                                </div>
                                <hr>
                                <h4>মোট : <span id="left-total">0</span></h4>
                            </div>
                            <div class="col-md-1"></div>

                            <div class="col-md-6">
                                <h5>আজকের খরচ :</h5>
                                
                                <div id="expense-container">
                                    <div class="row expense-row mb-2">
                                        <div class="col-5">
                                            <input type="text" name="khoroch_details[]" class="form-control" placeholder="খরচের বিবরণ">
                                        </div>
                                        <div class="col-5">
                                            <input type="number" name="khoroch_amount[]" class="form-control khoroch-amount" placeholder="টাকা">
                                        </div>
                                        <div class="col-2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="button" id="add-expense-btn" class="btn btn-primary btn-sm">ADD</button>
                                    </div>
                                </div>
                                
                                <hr>
                                <h4>মোট : <span id="khoroch-total">0</span>/-</h4>

                            </div>
                        </div>

                        <input type="hidden" name="left_side_total" id="left_side_total_input">
                        <input type="hidden" name="khoroch_side_total" id="khoroch_side_total_input">

                        <div class="row mt-4">
                             <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{route('cash.index')}}" class="btn btn-cancel">Cancel</a>
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
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {

            function calculateTotals() {
                let leftTotal = 0;
                $('.calculatable-left').each(function() {
                    leftTotal += parseFloat($(this).val()) || 0;
                });
                $('#left-total').text(leftTotal.toFixed(2));
                $('#left_side_total_input').val(leftTotal.toFixed(2));

                // Calculate Khoroch Total
                let khorochTotal = 0;
                $('.khoroch-amount').each(function() {
                    khorochTotal += parseFloat($(this).val()) || 0;
                });
                $('#khoroch-total').text(khorochTotal.toFixed(2));
                $('#khoroch_side_total_input').val(khorochTotal.toFixed(2));
            }

            $('#add-expense-btn').on('click', function() {
                const newRow = `
                <div class="row expense-row mb-2">
                    <div class="col-5">
                        <input type="text" name="khoroch_details[]" class="form-control" placeholder="খরচের বিবরণ">
                    </div>
                    <div class="col-5">
                        <input type="number" name="khoroch_amount[]" class="form-control khoroch-amount" placeholder="টাকা">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-danger btn-sm remove-expense-btn">REMOVE</button>
                    </div>
                </div>`;
                $('#expense-container').append(newRow);
            });

            // Remove expense row
            $('#expense-container').on('click', '.remove-expense-btn', function() {
                $(this).closest('.expense-row').remove();
                calculateTotals();
            });

            // Recalculate totals whenever any relevant input value changes
            $('body').on('input', '.calculatable-left, .khoroch-amount', function() {
                calculateTotals();
            });

            // Initial calculation on page load
            calculateTotals(); 
        });
    </script>
@endsection