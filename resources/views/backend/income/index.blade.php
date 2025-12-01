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
                    <h4>আয় হিসাব</h4>
                    <h6>আয় হিসাব পরিচালনা</h6>
                </div>
                <div class="page-btn">
                    <a href="{{route('income.create')}}" class="btn btn-added"><img src="{{asset('assets/img/icons/plus.svg')}}" alt="img" class="me-1">নতুন আয় সংযোজন</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            {{--                            <div class="search-path">--}}
                            {{--                                <a class="btn btn-filter" id="filter_search">--}}
                            {{--                                    <img src="assets/img/icons/filter.svg" alt="img">--}}
                            {{--                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span>--}}
                            {{--                                </a>--}}
                            {{--                            </div>--}}
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{asset('assets/img/icons/search-white.svg')}}" alt="img"></a>
                            </div>
                        </div>
                        {{--                        <div class="wordset">--}}
                        {{--                            <ul>--}}
                        {{--                                <li>--}}
                        {{--                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>--}}
                        {{--                                </li>--}}
                        {{--                                <li>--}}
                        {{--                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>--}}
                        {{--                                </li>--}}
                        {{--                                <li>--}}
                        {{--                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>--}}
                        {{--                                </li>--}}
                        {{--                            </ul>--}}
                        {{--                        </div>--}}
                    </div>



                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                            <tr>
                                {{--                                <th>--}}
                                {{--                                    <label class="checkboxs">--}}
                                {{--                                        <input type="checkbox" id="select-all">--}}
                                {{--                                        <span class="checkmarks"></span>--}}
                                {{--                                    </label>--}}
                                {{--                                </th>--}}

                                <th>Sl No.</th>
                                <th>আয়ের খাত</th>
                                <th>আয়ের পরিমান</th>
                                <th>তারিখ</th>
                                <th>নোট</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($incomes as $income)
                                <tr>
                                    {{--                                <td>--}}
                                    {{--                                    <label class="checkboxs">--}}
                                    {{--                                        <input type="checkbox">--}}
                                    {{--                                        <span class="checkmarks"></span>--}}
                                    {{--                                    </label>--}}
                                    {{--                                </td>--}}
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $income->source }}
                                    </td>
                                    <td>{{ $income->amount }}</td>
                                    <td>{{ $income->date }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($income->note, 20) }}</td>
                                    <td>
                                        {{--<a class="me-3" href="{{route('income.edit', ['id'=>$income->id] )}}">
                                            <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                                        </a>--}}
                                        <a class="" href="{{route('income.destroy', $income->id)}}">
                                            <img src="{{asset('assets/img/icons/delete.svg')}}" alt="img">
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

    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>

    <script src="{{asset('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
@endsection



