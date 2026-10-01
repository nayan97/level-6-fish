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
                    <h4>নিলাম বাকি হিসাব</h4>
                    {{-- <h6>চালান বাকি হিসাব পরিচালনা</h6> --}}
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
                                    <th>ইনভয়েস নাম্বার</th>
                                    <th>মহাজনের নাম</th>
                                    <th>ফেরত পরিমান</th>
                                    <th>তারিখ</th>
                                    <th>নোট</th>
                                    <th>অপশন</th>
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
                    <h5 class="modal-title">নিলাম বাকি ফেরত তালিকা</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>ইনভয়েস নাম্বার</th>
                                <th>ফেরত পরিমান</th>
                                <th>পেমেন্ট নাম্বার</th>
                                <th>তারিখ</th>
                                <th>নোট</th>
                                <th>অপশন</th>
                            </tr>
                        </thead>

                        <tbody id="modalChalanReturnRows">
                        </tbody>

                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">মোট</th>
                                <th id="chalanTotalAmount">0</th>
                                <th colspan="4"></th>
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
        let currentChalanId = null;
        let changed = false;

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

        // Load returns from server (optionally open modal)
        function loadReturns(chalanId, openModal = false) {
            $.get("/chalans-return/show/" + chalanId, function(res) {
                returnsData = res;

                // delete এর পর page খালি হয়ে গেলে আগের page এ যান
                if (currentPage > 1 && (currentPage - 1) * perPage >= returnsData.length) {
                    currentPage--;
                }

                renderTable();

                if (openModal) {
                    $("#chalanReturnDetailsModal").modal("show");
                }
            }).fail(function() {
                alert("Something went wrong!");
            });
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

        // View button: Load Chalan Return History & Open Modal
        $(document).on("click", ".viewChalanReturnBtn", function(e) {
            e.preventDefault();

            currentChalanId = $(this).data("id");
            currentPage = 1;
            changed = false;

            loadReturns(currentChalanId, true);
        });

        // Modal বন্ধ হলে মূল টেবিলের যোগফল refresh
        $("#chalanReturnDetailsModal").on("hidden.bs.modal", function() {
            if (changed) {
                location.reload();
            }
        });

        // EDIT
        $(document).on("click", ".editChalanReturnBtn", function() {
            const id = $(this).data("id");
            const item = returnsData.find(r => r.id == id);
            if (!item) return;

            Swal.fire({
                target: document.getElementById('chalanReturnDetailsModal'), // 👈 এটা যোগ করুন
                title: 'ফেরত এডিট করুন',
                html: `
        <input id="swalAmount" type="number" min="1" class="swal2-input" placeholder="Amount" value="${item.amount}">
        <input id="swalNote" type="text" class="swal2-input" placeholder="Note" value="${item.note ?? ''}">
    `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                didOpen: () => document.getElementById('swalAmount').focus(),
                preConfirm: () => {

                    const amount = document.getElementById('swalAmount').value;
                    if (!amount || amount < 1) {
                        Swal.showValidationMessage('সঠিক amount দিন');
                        return false;
                    }
                    return {
                        amount,
                        note: document.getElementById('swalNote').value
                    };
                }
            }).then(result => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "/chalans-return/" + id,
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        ...result.value
                    },
                    success: function() {
                        changed = true;
                        loadReturns(currentChalanId);
                        Swal.fire('Updated!', '', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong',
                            'error');
                    }
                });
            });
        });

        // DELETE
        $(document).on("click", ".deleteChalanReturnBtn", function() {
            const id = $(this).data("id");

            Swal.fire({
                title: 'নিশ্চিত?',
                text: 'এই ফেরত মুছলে cash এ amount আবার যোগ হবে',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ, ডিলিট',
            }).then(result => {
                if (!result.isConfirmed) return;

                $.ajax({
                    url: "/chalans-return/" + id,
                    method: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function() {
                        changed = true;
                        loadReturns(currentChalanId);
                        Swal.fire('Deleted!', '', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message ?? 'Something went wrong',
                            'error');
                    }
                });
            });
        });
    </script>
@endsection
