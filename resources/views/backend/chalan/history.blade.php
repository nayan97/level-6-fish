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
                    <h4>চালান বাকি হিসাব</h4>
                    <h6>চালান বাকি হিসাব পরিচালনা</h6>
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
                                    <th>চালান খাত</th>
                                    <th>Mohajon Name</th>
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

                                        {{-- Record ID --}}

                                        {{-- Related Chalan Invoice No --}}
                                        <td>{{ $return->invoice_no ?? 'N/A' }}</td>
                                       <td>{{ $return->mohajon->name ?? 'N/A' }}</td>


                                        {{-- Return Amount --}}
                                        <td>{{ $sum }}</td>

                                        {{-- Date --}}
                                        <td>{{ $return->updated_at ?? 'N/A' }}</td>

                                        {{-- Note --}}
                                        <td>{{ \Illuminate\Support\Str::limit($return->note, 20) }}</td>

                                        {{-- View Button --}}
                                        <td>
                                            <a href="#" class="me-3 viewChalanReturnBtn"
                                                data-id="{{ $return->id }}">
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

    <!-- Chalan Return Details Modal -->
    <div class="modal fade" id="chalanReturnDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Chalan Return Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>চালান খাত</th>
                                <th>ফেরত পরিমান</th>
                                <th>পেমেন্ট নাম্বার</th>
                                <th>তারিখ</th>
                                <th>নোট</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="modalChalanReturnRows">
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">মোট</th>
                                <th id="chalanTotalAmount">0</th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="d-flex justify-content-between mt-2">
                        <button class="btn btn-primary btn-sm" id="chalanPrevPage">Prev</button>
                        <button class="btn btn-primary btn-sm" id="chalanNextPage">Next</button>
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

        // Render Chalan Return Table
        function renderTable() {
            let tbody = "";
            let start = (currentPage - 1) * perPage;
            let end = start + perPage;

            let paginated = returnsData.slice(start, end);

            let total = 0;

            paginated.forEach((item, index) => {

                total += parseFloat(item.amount ?? 0);

                tbody += `
                        <tr>
                            <td>${start + index + 1}</td>
                            <td>${item.chalan?.invoice_no ?? ''}</td>
                            <td>${item.amount}</td>
                            <td>${item.step}</td>
                            <td>${item.date}</td>
                            <td>${item.note ?? ''}</td>

                            <td>
                                <button class="btn btn-sm btn-warning editChalanReturnBtn" data-id="${item.id}">
                                    Edit
                                </button>

                                <button class="btn btn-sm btn-danger deleteChalanReturnBtn" data-id="${item.id}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    `;
            });

            $("#modalChalanReturnRows").html(tbody);
            $("#chalanTotalAmount").text(total.toFixed(2));
        }

        // Next Page
        $(document).on("click", "#chalanNextPage", function() {
            if (currentPage * perPage < returnsData.length) {
                currentPage++;
                renderTable();
            }
        });

        // Prev Page
        $(document).on("click", "#chalanPrevPage", function() {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        // Load Chalan Return History & Open Modal
        $(document).on("click", ".viewChalanReturnBtn", function(e) {
            e.preventDefault();

            let chalanId = $(this).data("id");

            $.ajax({
                url: "/chalans-return/show/" + chalanId,
                method: "GET",
                success: function(res) {

                    returnsData = res;
                    console.log("Chalan Returns:", returnsData);

                    currentPage = 1;
                    renderTable();

                    $("#chalanReturnDetailsModal").modal("show");
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
