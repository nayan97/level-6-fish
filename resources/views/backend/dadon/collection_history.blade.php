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
        .info-card {
            background-color: #f8f9fa;
            border-left: 5px solid #007bff;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-card h5 {
            color: #007bff;
            margin-bottom: 10px;
        }
        .info-card p {
            margin-bottom: 5px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .balance-negative { color: red; font-weight: bold; }
        .balance-positive { color: green; font-weight: bold; }
    </style>
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>দাদন আইডি: {{ $dadon->id }} এর বিস্তারিত</h4>
                    <h6>দাদনের জমার হিসাব</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ url()->previous() }}" class="btn btn-cancel">
                        দাদন তালিকায় ফিরে যান
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="info-card">
                                <h5>দাদন তথ্য</h5>
                                <p><strong>পাইকারের নাম:</strong> {{ $dadon->customer ?? 'N/A' }}</p>
                                <p><strong>দাদনের পরিমাণ:</strong> {{ number_format($dadon->total_given_amount, 2) }} টাকা</p>
                                <p><strong>দাদনের তারিখ:</strong> {{ \Carbon\Carbon::parse($dadon->given_date)->format('Y-m-d') }}</p>
                                <p><strong>পরিশোধের শেষ তারিখ:</strong> {{ $dadon->due_pay_date ? \Carbon\Carbon::parse($dadon->due_pay_date)->format('Y-m-d') : 'N/A' }}</p>
                                <p><strong>মোট জমা:</strong> {{ number_format($totalCollectedAmount, 2) }} টাকা</p>
                                <p>
                                    <strong>বাকি:</strong>
                                    <span class="{{ $remainingBalance > 0 ? 'balance-negative' : 'balance-positive' }}">
                                        {{ number_format($remainingBalance, 2) }} টাকা
                                    </span>
                                </p>
                                <p><strong>নোট:</strong> {{ $dadon->note ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="table-top">
                        <div class="page-title">
                            <h4>জমার তালিকা</h4>
                        </div>
                        {{-- Search and other table top elements can be added here if needed --}}
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>জমার পরিমাণ</th>
                                    <th>জমার তারিখ</th>
                                    <th>নোট</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dadon->collections as $collection)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ number_format($collection->collection_amount, 2) }} টাকা</td>
                                        <td>{{ \Carbon\Carbon::parse($collection->collection_date)->format('Y-m-d') }}</td>
                                        <td>{{ $collection->note ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        <script>
        $(document).ready(function() {
            // Initialize DataTables if needed for the collections table
            // Note: 'datanew' class might already initialize it via your script.js
            // If not, you can do it here:
            // $('.datanew').DataTable();
        });
    </script>
@endsection
