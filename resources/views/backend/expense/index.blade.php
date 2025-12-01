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
                    <h4>ব্যায় হিসাব</h4>
                    <h6>ব্যায় হিসাব পরিচালনা</h6>
                </div>
                <div class="page-btn">
                    <a href="{{route('expense.create')}}" class="btn btn-added"><img src="{{asset('assets/img/icons/plus.svg')}}" alt="img" class="me-1">নতুন ব্যায় সংযোজন</a>
                </div>
            </div>

                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{asset('assets/img/icons/search-white.svg')}}"
                                        alt="img"></a>
                            </div>
                        </div>

                        <form action="{{ route('expense.index') }}" method="GET">
                            <div class="d-flex">
                                <div class="form-group mb-0 me-2">
                                    <label for="filter_date" class="form-label">শুরুর তারিখ</label>
                                    <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
                                </div>
                                <div class="form-group mb-0 me-2">
                                    <label for="filter_date" class="form-label">শেষ তারিখ</label>
                                    <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>
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
                                <th>ব্যায়ের খাত</th>
                                <th>ব্যায়ের পরিমান</th>
                                <th>তারিখ</th>
                                <th>নোট</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                                 @php
                                    $total = 0;
                                @endphp

                            @foreach($expenses as $expense)
                            
                                    <?php
                                        $total += $expense->amount;
                                    ?>
                                    
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
                                        {{ $expense->reason }}
                                    </td>
                                    <td>{{ $expense->amount }}</td>
                                    <td>{{ $expense->date }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($expense->note, 20) }}</td>
                                    <td>
                                        {{--                                    <a class="me-3" href="product-details.html">--}}
                                        {{--                                        <img src="assets/img/icons/eye.svg" alt="img">--}}
                                        {{--                                    </a>--}}
                                        <a class="me-3" href="{{route('expense.edit', ['id'=>$expense->id] )}}">
                                            <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                                        </a>
                                        <a class="" href="{{route('expense.destroy', $expense->id)}}">
                                            <img src="{{asset('assets/img/icons/delete.svg')}}" alt="img">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach



                            </tbody>
                            
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">মোট খরচ:</th>
                                    <th class="">{{ number_format($total, 2) }} ৳</th>
                                </tr>
                            </tfoot>
                            
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



