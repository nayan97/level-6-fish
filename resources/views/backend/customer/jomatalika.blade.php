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
                    <h4>পাইকারের জমার তালিকা</h4>
                </div>
                <div class="page-btn">
                    <a href="{{ route('customers_joma.create') }}" class="btn btn-added"><img
                            src="{{ asset('assets/img/icons/plus.svg') }}" alt="img" class="me-1">জমা সংযোজন</a>
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
                        <form action="{{ route('customers_joma.index') }}" method="GET">
                            <div class="d-flex">
                                <div class="form-group mb-0 me-2">
                                    <label for="filter_date" class="form-label">শুরুর তারিখ</label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="{{ $fromDate->format('Y-m-d') }}">
                                </div>
                                <div class="form-group mb-0 me-2">
                                    <label for="filter_date" class="form-label">শেষ তারিখ</label>
                                    <input type="date" name="to_date" class="form-control"
                                        value="{{ $toDate->format('Y-m-d') }}">
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
                                    <th>Sl No.</th>
                                    <th>পাইকারের নাম</th>
                                    <th>জমার তারিখ</th>
                                    <th>মোট জমা</th>
                                    <th>মন্তব্য</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($customerJomas as $joma)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>{{ $joma->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $joma->jomardate ?? 'N/A' }}</td>
                                        <td>{{ $joma->jomartaka ?? 'N/A' }}</td>
                                        <td>
                                            {{-- <form action="{{ route('customers_joma.destroy', $joma->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn-sm border-0 delete-confirm"><img src="{{asset('assets/img/icons/delete.svg')}}" alt="img"></button>
                                            </form> --}}
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
@endsection
