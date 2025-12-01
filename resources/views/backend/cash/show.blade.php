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
                    <h4>হিসাবের বিবরণ</h4>
                    <h6>একটি হিসাবের বিস্তারিত দেখুন</h6>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>ক্যাশ বিবরণ</h5>
                        <hr>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                ক্যাশ:
                                <span>{{ number_format($cashEntry->cash, 2) }} ৳</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                কমিশন:
                                <span>{{ number_format($cashEntry->today_commisoin, 2) }} ৳</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                পাইকার বাকি:
                                <span>{{ number_format($cashEntry->pre_day_paikar_due, 2) }} ৳</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                আমানত:
                                <span>{{ number_format($cashEntry->today_amount, 2) }} ৳</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                মোট আমানত:
                                <strong>{{ number_format($cashEntry->total_amanot, 2) }} ৳</strong>
                            </li>
                        </ul>
                        
                    </div>
                    <div class="col-md-6">
                        <h5>খরচের তালিকা</h5>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-info">
                                    <tr>
                                        <th style="width: 10%;">#</th>
                                        <th>খরচের বিবরণ</th>
                                        <th style="width: 20%;" class="text-end">টাকার পরিমাণ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_expense = 0;
                                    @endphp
                                    @forelse($cashEntry->expenses as $expense)
                                        <?php
                                            $total_expense += $expense->amount;
                                        ?>
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $expense->name }}</td>
                                            <td class="text-end">{{ number_format($expense->amount, 2) }} ৳</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">এই তারিখে কোনো খরচ পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2" class="text-end">মোট খরচ:</th>
                                        <th class="text-end h5">{{ number_format($total_expense, 2) }} ৳</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
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
@endsection