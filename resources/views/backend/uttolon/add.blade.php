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
                    <h4>উত্তোলন সংযোজন</h4>

                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form class="form-horizontal" action="{{ route('uttolon.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>টাকার পরিমান</label>
                                    <input type="number" name="amount" class="form-control" id="" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>উত্তোলনের তারিখ</label>
                                     <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"
                                        readonly>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <button  type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{route('uttolon.index')}}" class="btn btn-cancel">Cancel</a>
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
@endsection
