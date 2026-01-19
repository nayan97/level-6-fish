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
                    <h4>উত্তোলন হিসাব</h4>
                    <h6>উত্তোলন হিসাব পরিচালনা</h6>
                </div>
                <div class="page-btn">
                    <a href="{{route('uttolon.create')}}" class="btn btn-added"><img src="{{asset('assets/img/icons/plus.svg')}}" alt="img" class="me-1">নতুন উত্তোলন সংযোজন</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{asset('assets/img/icons/search-white.svg')}}" alt="img"></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>উত্তোলনের পরিমান</th>
                                <th>তারিখ</th>
                                <th>মন্তব্য</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($uttolons as $uttolon)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $uttolon->amount }}</td>
                                    <td>{{ $uttolon->date }}</td>
                                    <td>
                                        {{-- <a class="" href="{{route('uttolon.destroy', $uttolon->id)}}">
                                            <img src="{{asset('assets/img/icons/delete.svg')}}" alt="img">
                                        </a> --}}
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

    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
@endsection



