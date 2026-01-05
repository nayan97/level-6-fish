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
                    <h4>ক্যাশ খাতা হিসাব</h4>
                    {{-- <h6>ক্যাশ হিসাব পরিচালনা</h6> --}}
                </div>
                <div class="page-btn">
                    @if ($isDailyClosed == 1)
                        <button class="btn btn-added" disabled>
                            <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">
                            ক্যাশ ক্লোজ হয়েছে
                        </button>
                    @else
                        <a href="{{ route('cash.create') }}" class="btn btn-added">
                            <img src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">
                            ক্যাশ ক্লোজ করুন
                        </a>
                    @endif
                </div>

            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>তারিখ</th>
                                    <th>ক্যাশ পরিমান</th>
                                    <th>কমিশন</th>
                                    <th>পাইকার বাকি</th>
                                    <th>আমানত</th>
                                    <th>মোট</th>
                                    <th>অপশন</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($cashs as $cash)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($cash->created_at)->format('d F, Y') }}</td>
                                        <td>{{ $cash->cash }}</td>
                                        <td>{{ $cash->today_commisoin }}</td>
                                        <td>{{ $cash->pre_day_paikar_due }}</td>
                                        <td>{{ $cash->today_amount }}</td>
                                        <td>{{ $cash->total_amanot }}</td>
                                        <td>
                                            <a class="me-3" href="{{ route('cash.show', $cash->id) }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="img">
                                            </a>
                                            <a class="" href="{{ route('cash.destroy', $cash->id) }}">
                                                <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">
                                            </a>
                                        </td>
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

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
@endsection
