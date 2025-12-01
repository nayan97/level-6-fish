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
                    <h4>আমানত হিসাব</h4>
                    <h6>আমানত হিসাব পরিচালনা</h6>
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
                                    <th>Sl No.</th>
                                    <th>আমানত আইডি</th>
                                    <th>আমানতের খাত</th>
                                    <th>ফেরত পরিমান</th>
                                    <th>তারিখ</th>
                                    <th>নোট</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($amanotReturned as $return)
                                    @php
                                        // Decode JSON safely
                                        $returns = json_decode($return->return_amounts, true);

                                        // Calculate sum (only if array)
                                        $sum = is_array($returns) ? array_sum($returns) : 0;
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $return->id ?? 'N/A' }}</td>
                                        <td>{{ $return->source ?? 'N/A' }}</td>

                                        {{-- Show sum of return amounts --}}
                                        <td>{{ $sum }}</td>

                                        <td>{{ $return->date }}</td>

                                        <td>{{ \Illuminate\Support\Str::limit($return->note, 20) }}</td>

                                        <td>
                                            <a href="#" class="me-3 viewReturnBtn" data-id="{{ $return->id }}">
                                                <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="img">
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

    <!-- Return Details Modal -->
    <div class="modal fade" id="returnDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Amanot Return Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>আমানতের খাত</th>
                                <th>ফেরত পরিমান</th>
                                <th>পেমেন্ট নাম্বার</th>
                                <th>তারিখ</th>
                                <th>নোট</th>
                                <th>Action</th> <!-- added -->
                            </tr>
                        </thead>

                        <tbody id="modalReturnRows">
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">মোট</th>
                                <th id="totalAmount">0</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="d-flex justify-content-between mt-2">
                        <button class="btn btn-primary btn-sm" id="prevPage">Prev</button>
                        <button class="btn btn-primary btn-sm" id="nextPage">Next</button>
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
        let currentPage = 1;
        let perPage = 5;
        let returnsData = [];

        function renderTable() {
            let tbody = "";
            let start = (currentPage - 1) * perPage;
            let end = start + perPage;

            let paginated = returnsData.slice(start, end);

            let total = 0;

            paginated.forEach((item, index) => {

                total += parseFloat(item.amount);

                tbody += `
                <tr>
                    <td>${start + index + 1}</td>
                    <td>${item.amanot?.source ?? ''}</td>
                    <td>${item.amount}</td>
                    <td>${item.step}</td>
                    <td>${item.date}</td>
                    <td>${item.note ?? ''}</td>

                    <td>
                        <button class="btn btn-sm btn-warning editBtn" data-id="${item.id}">
                            Edit
                        </button>

                        <button class="btn btn-sm btn-danger deleteBtn" data-id="${item.id}">
                            Delete
                        </button>
                    </td>
                </tr>
            `;
            });

            $("#returnDetailsModal tbody").html(tbody);
            $("#totalAmount").text(total.toFixed(2));
        }

        // Next Page
        $(document).on("click", "#nextPage", function() {
            if (currentPage * perPage < returnsData.length) {
                currentPage++;
                renderTable();
            }
        });

        // Prev Page
        $(document).on("click", "#prevPage", function() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        // Load history and show modal
        $(document).on("click", ".viewReturnBtn", function(e) {
            e.preventDefault();

            let amanotId = $(this).data("id"); // amanot_id

            $.ajax({
                url: "/amanot-return/show/" + amanotId,
                method: "GET",
                success: function(res) {

                    returnsData = res;
                    currentPage = 1;

                    renderTable();

                    $("#returnDetailsModal").modal("show");
                },
                error: function() {
                    alert("Something went wrong!");
                }
            });
        });

        // Edit button
        $(document).on("click", ".editBtn", function() {
            let id = $(this).data("id");
            alert("Edit ID: " + id);
            // You can open edit form here
        });

        // Delete button
        $(document).on("click", ".deleteBtn", function() {
            let id = $(this).data("id");

            if (confirm("Are you sure to delete?")) {

                $.ajax({
                    url: "/amanot-return/delete/" + id,
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        alert("Deleted successfully!");

                        // Remove deleted item from array
                        returnsData = returnsData.filter(item => item.id !== id);

                        renderTable();
                    }
                });
            }
        });
    </script>
@endsection
