@extends('backend.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endsection


@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <form action="{{ route('admin.dashboard') }}" method="GET">
                    <div class="d-flex justify-content-end">
                        <div class="form-group mb-0 me-2">
                            <label for="filter_date" class="form-label">শুরুর তারিখ</label>
                            <input type="date" name="from_date" class="form-control"
                                value="{{ $from ?? \Carbon\Carbon::now('Asia/Dhaka')->toDateString() }}">
                        </div>
                        <div class="form-group mb-0 me-2">
                            <label for="filter_date" class="form-label">শেষ তারিখ</label>
                            <input type="date" name="to_date" class="form-control"
                                value="{{ $to ?? \Carbon\Carbon::now('Asia/Dhaka')->toDateString() }}">
                        </div>
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
                <!--<div class="col-lg-3 col-sm-6 col-12">-->
                <!--    <div class="dash-widget">-->
                <!--        <div class="dash-widgetimg">-->
                <!--            <span><img src="{{ asset('assets/img/icons/dash1.svg') }}" alt="img"></span>-->
                <!--        </div>-->
                <!--        <div class="dash-widgetcontent">-->
                <!--            <h5>৳ <span class="counters text-info">{{ number_format($total_income) }}</span></h5>-->
                <!--            <h6 class="fw-bold">মোট আয়</h6>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <div class="row">
                    <!-- Card 9: ক্যাশ -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('cash.index') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-success">{{ number_format($totalcash) }}</span></h5>
                                    <h6 class="fw-bold">ক্যাশ</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 1: মোট আয় -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('dadon.due_soon') }}" class="text-decoration-none">
                            <div class="dash-widget">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash1.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span
                                            class="counters text-info">{{ number_format($total_commission - $total_expense) }}</span>
                                    </h5>
                                    <h6 class="fw-bold">মোট আয়</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 2: মোট ব্যায় -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('dadon.due_soon') }}" class="text-decoration-none">
                            <div class="dash-widget dash1">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-warning">{{ number_format($total_expense) }}</span>
                                    </h5>
                                    <h6 class="fw-bold">মোট ব্যায়</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 3: দাদন বাকি -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('dadon.due_soon') }}" class="text-decoration-none">
                            <div class="dash-widget dash2">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-danger">{{ number_format($total_baki) }}</span></h5>
                                    <h6 class="fw-bold">দাদন বাকি</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 4: দাদন জমা -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('dadon_add.index') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-success">{{ number_format($total_baki_aday) }}</span>
                                    </h5>
                                    <h6 class="fw-bold">দাদন জমা</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 5: আমানত -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('chalan.report') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-success">{{ number_format($totalamanot) }}</span></h5>
                                    <h6 class="fw-bold">আমানত</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 6: পাইকার বাকী -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('customers.index') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-success">{{ number_format($totalBaki) }}</span></h5>
                                    <h6 class="fw-bold">পাইকার বাকী</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Card 10: পাইকার জমা -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('customers_joma.index') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-success">{{ number_format($totalJoma) }}</span></h5>
                                    <h6 class="fw-bold">পাইকার জমা</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 7: কমিশন -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('dadon.due_soon') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span
                                            class="counters text-success">{{ number_format($total_commission) }}</span>
                                    </h5>
                                    <h6 class="fw-bold">কমিশন</h6>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 8: উত্তোলন -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('uttolon.index') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-success">{{ number_format($uttolon_amount) }}</span>
                                    </h5>
                                    <h6 class="fw-bold">ক্যাশ সংযোগ</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Card 8: উত্তোলন -->
                    <div class="col-lg-3 col-sm-6 col-12 mb-4">
                        <a href="{{ route('uttolon.index') }}" class="text-decoration-none">
                            <div class="dash-widget dash3">
                                <div class="dash-widgetimg">
                                    <span><img src="{{ asset('assets/img/icons/dash2.svg') }}" alt="img"></span>
                                </div>
                                <div class="dash-widgetcontent">
                                    <h5>৳ <span class="counters text-success">{{ number_format($uttolon_amount) }}</span>
                                    </h5>
                                    <h6 class="fw-bold">ক্যাশ উত্তোলন</h6>
                                </div>
                            </div>
                        </a>
                    </div>

   


                </div>

                <div class="row">
                    <div class="col-lg-7 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">আয়/ব্যয় চার্ট রিপোর্ট</h4>
                                <div class="dropdown">
                                    <button class="btn btn-white btn-sm dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $year }} <img src="{{ asset('assets/img/icons/dropdown.svg') }}"
                                            alt="img" class="ms-2">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($years as $y)
                                            <li>
                                                <a href="{{ route('dashboard.year', $y) }}"
                                                    class="dropdown-item">{{ $y }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="income-expense-chart" class="chart-set"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-sm-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">সকল খাতের রিপোর্ট</h4>
                            </div>

                            <hr>


                            <div class="card-body">
                                <div id="summary-radial-chart" class="chart-set"></div>
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

        <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

        <script src="{{ asset('assets/js/script.js') }}"></script>

        <script>
            var options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'আয়',
                    data: {
                        !!json_encode($incomeData) !!
                    }
                }, {
                    name: 'ব্যয়',
                    data: {
                        !!json_encode($expenseData) !!
                    }
                }],
                xaxis: {
                    categories: {
                        !!json_encode($months) !!
                    }
                },
                colors: ['#24E6A4', '#FD5F76']
            };

            var chart = new ApexCharts(document.querySelector("#income-expense-chart"), options);
            chart.render();
        </script>

        <script>
            const summarySeries = [{
                    {
                        $total_income
                    }
                },
                {
                    {
                        $total_expense
                    }
                },
                {
                    {
                        $total_baki
                    }
                },
                {
                    {
                        $total_baki_aday
                    }
                }
            ];
            const summaryLabels = ['মোট আয়', 'মোট ব্যয়', 'মোট বাকী', 'মোট বাকী আদায়'];

            document.addEventListener("DOMContentLoaded", function() {
                if (document.querySelector("#summary-radial-chart")) {
                    var radialChart = {
                        chart: {
                            height: 350,
                            type: 'radialBar',
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            radialBar: {
                                dataLabels: {
                                    name: {
                                        fontSize: '22px',
                                    },
                                    value: {
                                        fontSize: '16px',
                                        formatter: function(val, opts) {
                                            return '৳ ' + parseFloat(val).toFixed(2);
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'মোট',
                                        formatter: function(w) {
                                            let total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            return '৳ ' + total.toFixed(2); // মোট টাকা দেখাবে
                                        }
                                    }
                                }
                            }
                        },
                        series: summarySeries,
                        labels: summaryLabels,
                        colors: ['#0DCEF4', '#FEB019', '#DC3545', '#198754']
                    };

                    var chart = new ApexCharts(document.querySelector("#summary-radial-chart"), radialChart);
                    chart.render();

                }
            });
        </script>
    @endsection
