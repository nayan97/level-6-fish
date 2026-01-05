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
                    <h4>দৈনিক নিলামের তালিকা</h4>
                </div>
                <div class="page-btn">
                    <a href="{{ route('daily.create') }}" class="btn btn-added"><img
                            src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">দৈনিক নিলাম
                        সংযোজন</a>
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

                        <form action="{{ route('daily.index') }}" method="GET">
                            <div class="d-flex">
                                <div class="form-group mb-0 me-2">
                                    <label for="filter_date" class="form-label">শুরুর তারিখ</label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="{{ $fromDate ?? '' }}">
                                </div>
                                <div class="form-group mb-0 me-2">
                                    <label for="filter_date" class="form-label">শেষ তারিখ</label>
                                    <input type="date" name="to_date" class="form-control" value="{{ $toDate ?? '' }}">
                                </div>
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>সিরিয়াল নং</th>
                                    <th>ক্রয়ের তারিখ</th>
                                    <th>মহাজনের নাম</th>
                                    <th>মোট টাকা</th>
                                    <th>অপশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailyKroy as $daily)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($daily->created_at)->format('d M Y') }}</td>
                                        <td>{{ $daily->mohajon->name ?? 'N/A' }}</td>
                                   
                                        <td>{{ number_format($daily->total_amount, 2) }}</td>
                                        <td>
                                            @if ($daily->status == 1)
                                                <button class="me-3 btn btn-secondary text-white" disabled>
                                                    চালান তৈরি হয়েছে
                                                </button>
                                            @else
                                                <a class="me-3 btn btn-primary text-white"
                                                    href="{{ route('chalansbymohajon.create', ['mohajon_id' => $daily->mohajon_id, 'date' => $daily->created_at]) }}">
                                                    চালান তৈরি করুন
                                                </a>
                                            @endif

                                            <form
                                                action="{{ route('daily.destroy_by_date', ['mohajon_id' => $daily->mohajon_id, 'date' => $daily->created_at]) }}"
                                                method="POST" class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm border-0 delete-confirm"><img
                                                        src="{{ asset('assets/img/icons/delete.svg') }}"
                                                        alt="img"></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold fs-6">মোট টাকা =</td>
                                    <td id="totalAmount" class="fw-bold fs-6">{{ number_format($totalSum, 2) }}</td>
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
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Stop default submit

                    Swal.fire({
                        title: 'আপনি কি নিশ্চিত?',
                        text: "এই তথ্য ডিলিট হয়ে যাবে!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'হ্যাঁ, ডিলিট করুন',
                        cancelButtonText: 'না, বাতিল'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Proceed with form submission
                        }
                    });
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var table = $('.datanew').DataTable();

            function parseNumber(val) {
                if (!val) return 0;
                return parseFloat(val.toString().replace(/,/g, '')) || 0;
            }

            function updateTotals() {
                let totalAmount = 0;

                table.rows({
                    filter: 'applied'
                }).every(function() {
                    let row = this.node(); // row element
                    let amount = parseNumber($(row).find('td:eq(3)').text()); // কলাম (মোট টাকা)

                    totalAmount += amount;
                });

                $('#totalAmount').text(totalAmount.toFixed(2));
            }

            // Datatable search/pagination/draw হলে update হবে
            table.on('draw', function() {
                updateTotals();
            });

            // প্রথমবার লোডে কল করানো
            updateTotals();
        });
    </script>
@endsection
