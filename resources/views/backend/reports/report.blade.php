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
    <!-- Return Amount Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="returnForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">চালান বাকি ফেরত</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="returnAmanotId">

                        <div class="form-group">
                            <label>বাকির পরিমান</label>
                            <input type="number" class="form-control" readonly id="currentDue">
                        </div>

                        <div class="form-group">
                            <label>ফেরত পরিমান</label>
                            <input type="number" min="1" class="form-control" id="returnAmount" required>
                        </div>

                        <div class="form-group mt-2">
                            <label>নোট</label>
                            <textarea class="form-control" id="returnNote"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <!-- FIXED HERE -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                        <button type="submit" class="btn btn-primary">জমা করুন</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>চালান রিপোর্ট</h4>
                </div>
                <div class="page-btn">
                    <form method="GET" action="{{ route('chalan.report') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-auto">
                            <label>শুরুর তারিখ</label>
                            <input type="date" name="from" class="form-control" value="{{ $from }}">
                        </div>
                        <div class="col-auto">
                            <label>শেষ তারিখ</label>
                            <input type="date" name="to" class="form-control" value="{{ $to }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">দেখাও</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ asset('assets/img/icons/search-white.svg') }}" alt="img">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>ক্রমিক</th>
                                    <th>ইনভয়েস নম্বর</th>
                                    <th>তারিখ</th>
                                    <th>মহাজন</th>
                                    <th>বাকী</th>
                                    <th>অপশন</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($chalans as $chalan)
                                    @if ($chalan->total_amount != $chalan->payment_amount)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $chalan->invoice_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($chalan->chalan_date)->format('d M Y') }}</td>
                                            <td>{{ $chalan->mohajon->name ?? 'N/A' }}</td>
                                            <td>৳ {{ number_format($chalan->total_amount - $chalan->payment_amount, 2) }}
                                            </td>
                                            <td>
                                                <button class="btn btn-primary text-white return-btn"
                                                    data-id="{{ $chalan->id }}"
                                                    data-amount="{{ number_format($chalan->total_amount - $chalan->payment_amount, 2)}}">
                                                    পরিশোধ করুন
                                                </button>

                                                <a class="me-3" href="{{ route('chalans.show', $chalan->id) }}">
                                                    <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="img">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
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

    <script>
        $(document).on('click', '.return-btn', function() {
            let id = $(this).data('id');
            let amount = $(this).data('amount');

            // show current due
            $('#currentDue').val(amount);

            $('#returnAmanotId').val(id);
            $('#returnAmount').attr('max', amount);

            $('#returnModal').modal('show');
        });

        $("#returnForm").submit(function(e) {
            e.preventDefault();

            let id = $("#returnAmanotId").val();
            let amount = $("#returnAmount").val();
            let note = $("#returnNote").val();

            $.ajax({
                url: "/dashboard/chalanbaki/" + id + "/return",
                type: "POST",
                data: {
                    amount: amount,
                    note: note,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    Swal.fire("Success!", res.message, "success");
                    location.reload();
                },
                error: function(err) {
                    Swal.fire("Error!", err.responseJSON.message, "error");
                }
            });
        });
    </script>
@endsection
