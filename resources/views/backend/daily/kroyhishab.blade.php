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
@php
    function en2bn($number)
    {
        $en = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bn = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($en, $bn, $number);
    }

    $today = \Carbon\Carbon::today('Asia/Dhaka')->format('d-m-Y');
@endphp
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>ক্রয়ের তালিকা বিস্তারিত</h4>
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
                            <div class="ms-2">
                                <button id="paikarPrintBtn" class="btn btn-success">প্রিন্ট রিপোর্ট</button>
                            </div>
                        </div>

                        <form action="{{ route('kroy.hishab') }}" method="GET">
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
                                    <th>সিরিয়াল নং</th>
                                    <th>ক্রয়ের তারিখ</th>
                                    <th>মহাজনের নাম</th>
                                    <th>পাইকারের নাম</th>
                                    <th>পণ্যের নাম</th>
                                    <th>পণ্যের পরিমাণ (কেজি)</th>
                                    <th>চার্জ এড হয়েছে (কেজি)</th>
                                    <th>পণ্যের দাম</th>
                                    <th>মোট টাকা</th>
                                    <th>অপশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dailyKroy as $daily)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($daily->chalan_date)->format('d M Y') }}</td>
                                        <td>{{ $daily->mohajon->name ?? 'N/A' }}</td>
                                        <td data-paikar-id="{{ $daily->customer->id ?? '' }}">
                                            {{ $daily->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $daily->product->name ?? 'N/A' }}</td>
                                        <td>{{ $daily->quantity ?? 'N/A' }}</td>
                                        <td>{{ $daily->set_charged ?? 'N/A' }}</td>
                                        <td>{{ number_format($daily->amount, 2) }}</td>
                                        <td>{{ number_format($daily->total_amount, 2) }}</td>


                                        {{-- ✅ New column with button --}}
                                        <td>

                                            <button type="button"
                                                class="btn paikarChargeBtn {{ $daily->quantity == $daily->set_charged ? 'btn-secondary' : 'btn-success' }}"
                                                data-bs-toggle="modal" data-bs-target="#chargeModal"
                                                data-order-id="{{ $daily->id }}"
                                                data-paikar-id="{{ $daily->customer->id }}"
                                                data-paikar-name="{{ $daily->customer->name }}"
                                                data-qty="{{ $daily->quantity - $daily->set_charged }}"
                                                {{ $daily->quantity == $daily->set_charged ? 'disabled' : '' }}>
                                                পাইকার চার্জ হিসাব
                                            </button>


                                            {{-- Delete Button --}}
                                            <form action="{{ route('daily.destroy', $daily->id) }}" method="POST"
                                                class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm border-0 delete-confirm">
                                                    <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="img">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end fw-bold fs-6">মোট কেজি =</td>
                                    <td id="totalQty" class="fw-bold fs-6">{{ number_format($totalQty, 2) }}</td>
                                    <td class="text-end fw-bold fs-6">মোট টাকা =</td>
                                    <td id="totalAmount" class="fw-bold fs-6">{{ number_format($totalSum, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- charge Modal -->
    <div class="modal fade" id="chargeModal" tabindex="-1" aria-labelledby="chargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="chargeForm" method="POST" action="{{ route('charge.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chargeModalLabel">পাইকার চার্জ হিসাব</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">পাইকারের নাম</label>
                            <input type="text" id="paikarName" class="form-control" readonly>
                            <input type="hidden" id="paikarId" name="paikar_id">

                        </div>

                        <div class="mb-3">

                            <input type="hidden" id="orderId" name="order_id">
                        </div>


                        <div class="mb-3">
                            <label class="form-label">মোট কেজি</label>
                            <input type="text" id="totalKg" name="total_qty" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">প্রতি কেজির চার্জ (৳)</label>
                            <input type="number" id="chargePerKg" name="charge_per_kg" class="form-control"
                                placeholder="যেমন 5" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">মোট চার্জ (৳)</label>
                            <input type="text" id="totalCharge" name="total_charge" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">তারিখ</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ \Carbon\Carbon::now('Asia/Dhaka')->toDateString() }}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">জমা করুন</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বাতিল করুন</button>
                    </div>
                </div>
            </form>
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
        $(document).ready(function() {
            var table = $('.datanew').DataTable();

            function parseNumber(val) {
                if (!val) return 0;
                return parseFloat(val.toString().replace(/,/g, '')) || 0;
            }

            function updateTotals() {
                let totalQty = 0;
                let totalAmount = 0;

                table.rows({
                    filter: 'applied'
                }).every(function() {
                    let row = this.node(); // row element
                    let qty = parseNumber($(row).find('td:eq(5)').text()); // 6 culumn (quantity)
                    let amount = parseNumber($(row).find('td:eq(7)').text()); // 8 culumn

                    totalQty += qty;
                    totalAmount += amount;
                });

                $('#totalQty').text(totalQty.toFixed(2));
                $('#totalAmount').text(totalAmount.toFixed(2));
            }

            // update for Datatable search/pagination/draw
            table.on('draw', function() {
                updateTotals();
            });

            // first time load
            updateTotals();

        });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('.datanew').DataTable();

            function toNumber(text) {
                if (!text) return 0;
                text = text.toString().trim();
                text = text.replace(/,/g, '');
                let match = text.match(/[\d.]+$/);
                return match ? parseFloat(match[0]) : 0;
            }

            // print only filtered paikar rows
            $('#paikarPrintBtn').on('click', function() {
                var filteredRows = table.rows({
                    search: 'applied'
                }).nodes();
                if (filteredRows.length === 0) {
                    alert('কোনো তথ্য পাওয়া যায়নি!');
                    return;
                }

                let paikarIds = [];
                $(filteredRows).each(function() {
                    let id = $(this).find('td:eq(3)').data('paikar-id'); // ৪র্থ column (paikar)
                    if (id) paikarIds.push(id);
                });

                // console.log(paikarIds);

                // Dates
                let fromDate = $('input[name="from_date"]').val();
                let toDate = $('input[name="to_date"]').val();

                // Ajax: get charge sum
                $.ajax({
                    url: '/get-paikar-charge-sum',
                    method: 'POST',
                    data: {
                        paikar_ids: paikarIds,
                        from_date: fromDate,
                        to_date: toDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        // বাদ দিতে চাও এমন হেডারের নাম
                        let excludeCols = ["ক্রয়ের তারিখ", "পণ্যের দাম", "অপশন"];

                        // সব হেডারের নাম collect
                        let headers = [];
                        $('.datanew thead tr th').each(function() {
                            headers.push($(this).text().trim());
                        });

                        // style + header
                        var printContent = `
                        <!DOCTYPE html>
                        <html>
                        <head>
                        <meta charset="UTF-8">
                        <style>
                            body { font-family: 'SolaimanLipi', sans-serif; margin: 0; padding: 20px; font-size: 10pt; }
                            .header-section { text-align: center; margin-bottom: 10px; }
                            .header-top-text { font-size: 6pt; margin-bottom: 5px; }
                            .main-title { font-size: 14pt; font-weight: bold; margin-bottom: 5px; line-height: 1.2; color: #3d5bbd; }
                            .proprietor-info, .contact-info, .address-info { font-size: 6pt; margin-bottom: 5px; }
                            .address-info { line-height: 1.5; }
                            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                            th, td { padding: 8px; text-align: center; border: 1px solid #000; }
                            .header { font-weight: bold; }
                            .total-row { text-align: right; margin-top: 20px; font-size: 11pt; }
                            .total-amount { text-align: right; font-weight: bold; font-size: 12pt; margin-top: 10px; }
                        </style>
                        </head>
                        <body>

                        <div class="header-section">
                            <div class="header-top-text">বিসমিল্লাহির রাহমানির রাহিম</div>
                            <div class="main-title">কলম মৎস্য আড়ত</div>
                            <div class="proprietor-info">প্রোঃ মোঃ শাহাজান হোসেন (শাহান)</div>
                            <div class="contact-info">মোবাঃ ০১৯২৩-৭৮০৮৬২, ০১৭৯২-৭৮০৮৬২</div>
                            <div class="contact-info">তারিখ: {{ en2bn($today) }}</div>
                            <div class="address-info">ডেমকাম ও গিংহা বাসস্ট্যান্ড, সিংড়া, নাটোর।</div>
                        </div>

                        <table>
                            <thead>
                                <tr class="header">
                        `;

                        // টেবিল হেডার exclude বাদ দিয়ে
                        headers.forEach(function(h) {
                            if (!excludeCols.includes(h)) {
                                printContent += `<th>${h}</th>`;
                            }
                        });

                        printContent += `
                                </tr>
                            </thead>
                            <tbody>
                        `;

                        // টেবিল রো + টোটাল হিসাব
                        let totalQty = 0;
                        let totalAmount = 0;
                        let totalCharge = 0;
                        let jer = 0;
                        let grandTotal = 0;

                        $(filteredRows).each(function() {
                            let rowHtml = '';
                            $(this).find('td').each(function(i, td) {
                                let headerName = headers[i];
                                if (!excludeCols.includes(headerName)) {
                                    let cellText = $(td).text().trim();
                                    rowHtml += `<td>${cellText}</td>`;

                                    // Header name
                                    if (headerName === "পণ্যের পরিমাণ (কেজি)") {
                                        totalQty += toNumber(cellText);
                                    }
                                    if (headerName === "মোট টাকা") {
                                        totalAmount += toNumber(cellText);
                                    }
                                }
                            });
                            printContent += `<tr>${rowHtml}</tr>`;
                        });

                        // Add charge_amount
                        totalCharge += parseFloat(res.charge_amount) || 0;
                        jer += parseFloat(res.jer) || 0;
                        grandTotal = totalAmount + totalCharge + jer;

                        printContent += `
                            </tbody>
                        </table>

                        <div class="total-row">
                            মোট কেজি = ${totalQty.toFixed(2)} <br>
                            মোট চার্জ = ${totalCharge.toFixed(2)} <br>
                            মোট টাকা = ${totalAmount.toFixed(2)}<br>
                            জের = ${jer.toFixed(2)}
                        </div>

                        <div class="total-amount">
                            সর্বমোট: ${grandTotal.toFixed(2)}
                        </div>

                        </body>
                        </html>
                        `;

                        var myWindow = window.open('', '', 'width=800,height=600');
                        myWindow.document.write(printContent);
                        myWindow.document.close();
                        myWindow.focus();

                        // Print এর পর window close
                        myWindow.onafterprint = function() {
                            myWindow.close();
                        };

                        myWindow.print();
                    }
                });
            });

        });
    </script>


    <script>
        $(document).ready(function() {

            // When charge button is clicked
            $(document).on('click', '.paikarChargeBtn', function() {

                let paikarName = $(this).data('paikar-name');
                let paikarId = $(this).data('paikar-id');
                let qty = $(this).data('qty'); // Remaining quantity
                let orderId = $(this).data('order-id');

                $('#paikarName').val(paikarName);
                $('#paikarId').val(paikarId);
                $('#orderId').val(orderId);

                // Set input value AND data attribute
                $('#totalKg')
                    .val('')
                    .data('qty', qty)
                    .attr('placeholder', qty );

                $('#chargePerKg').val('');
                $('#totalCharge').val('');
            });

            // Validate totalKg
            $(document).on('input', '#totalKg', function() {

                let totalKg = parseFloat($(this).val()) || 0;
                let maxQty = parseFloat($(this).data('qty')) || 0;

                if (totalKg > maxQty) {
                    Swal.fire({
                        icon: 'error',
                        title: 'ভুল ইনপুট',
                        text: 'ইনপুট করা কেজি মোট কেজির থেকে বেশি হতে পারবে না!',
                    });

                    $(this).val('');
                    $('#totalCharge').val('');
                    return;
                }

                // Auto-calc charge
                let chargePerKg = parseFloat($('#chargePerKg').val()) || 0;
                $('#totalCharge').val((totalKg * chargePerKg).toFixed(2));
            });

            // When charge per kg changes
            $(document).on('input', '#chargePerKg', function() {

                let totalKg = parseFloat($('#totalKg').val()) || 0;
                let chargePerKg = parseFloat($(this).val()) || 0;

                $('#totalCharge').val((totalKg * chargePerKg).toFixed(2));
            });

        });
    </script>
@endsection
