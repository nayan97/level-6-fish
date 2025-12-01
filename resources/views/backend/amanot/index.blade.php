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
                        <h5 class="modal-title">Return Amanot Amount</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="returnAmanotId">

                        <div class="form-group">
                            <label>Return Amount</label>
                            <input type="number" min="1" class="form-control" id="returnAmount" required>
                        </div>

                        <div class="form-group mt-2">
                            <label>Note</label>
                            <textarea class="form-control" id="returnNote"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Return</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>আমানত হিসাব</h4>
                    <h6>আমানত হিসাব পরিচালনা</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('amanot.create') }}" class="btn btn-added"><img
                            src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">নতুন আমানত
                        সংযোজন</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            {{--                            <div class="search-path"> --}}
                            {{--                                <a class="btn btn-filter" id="filter_search"> --}}
                            {{--                                    <img src="assets/img/icons/filter.svg" alt="img"> --}}
                            {{--                                    <span><img src="assets/img/icons/closes.svg" alt="img"></span> --}}
                            {{--                                </a> --}}
                            {{--                            </div> --}}
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                        {{--                        <div class="wordset"> --}}
                        {{--                            <ul> --}}
                        {{--                                <li> --}}
                        {{--                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a> --}}
                        {{--                                </li> --}}
                        {{--                                <li> --}}
                        {{--                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a> --}}
                        {{--                                </li> --}}
                        {{--                                <li> --}}
                        {{--                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a> --}}
                        {{--                                </li> --}}
                        {{--                            </ul> --}}
                        {{--                        </div> --}}
                    </div>



                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    {{--                                <th> --}}
                                    {{--                                    <label class="checkboxs"> --}}
                                    {{--                                        <input type="checkbox" id="select-all"> --}}
                                    {{--                                        <span class="checkmarks"></span> --}}
                                    {{--                                    </label> --}}
                                    {{--                                </th> --}}

                                    <th>Sl No.</th>
                                    <th>আমানতের খাত</th>
                                    <th>আমানতের পরিমান</th>
                                    <th>তারিখ</th>
                                    <th>নোট</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($amanots as $amanot)
                                    @if ($amanot->amount > 0)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $amanot->source }}</td>
                                            <td>{{ $amanot->amount }}</td>
                                            <td>{{ $amanot->date }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($amanot->note, 20) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary return-btn"
                                                    data-id="{{ $amanot->id }}" data-amount="{{ $amanot->amount }}">
                                                    Return
                                                </button>

                                                <a class="btn btn-sm btn-danger text-white"
                                                    href="{{ route('amanot.destroy', $amanot->id) }}">
                                                    Delete
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
                url: "/dashboard/amanot/" + id + "/return",
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
