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
                    <h4>পাইকারের তথ্য আপডেট করুন</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form class="form-horizontal" action="{{ route('customers.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <input type="hidden" name="id" class="form-control" id="" placeholder="" value="{{ $customer->id }}">
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>পাইকারের নাম</label>
                                    <input type="text" name="name" class="form-control" id="" placeholder="" value="{{ old('name', $customer->name ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>মোবাইল নম্বর</label>
                                    <input type="text" name="phone" class="form-control" id="" placeholder="" value="{{ old('phone', $customer->phone ?? '') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>ঠিকানা</label>
                                    <textarea class="form-control" name="address">{{ old('address', $customer->address ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button  type="submit" class="btn btn-submit me-2">Submit</button>
                                <a href="{{route('customers.index')}}" class="btn btn-cancel">Cancel</a>
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
