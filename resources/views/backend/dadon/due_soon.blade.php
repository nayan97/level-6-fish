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
                    <h4>পরিশোধের অপেক্ষায় দাদন</h4>
                    <h6>পরিশোধের তারিখ অনুযায়ী দাদনের তালিকা</h6>
                </div>
                <div class="page-btn">
                    <a href="{{route('dadon.create')}}" class="btn btn-added"><img src="{{asset('assets/img/icons/plus.svg')}}" alt="img" class="me-1">দাদন সংযোজন</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{asset('assets/img/icons/search-white.svg')}}" alt="img"></a>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>দাদনের নাম</th>
                                    <th>পাইকারের নাম</th>
                                    <th>মোট প্রদান</th>
                                    <th>মোট জমা</th>
                                    <th>মোট বাকি</th>
                                    <th>প্রদানের তারিখ</th>
                                    <th>পরিশোধের তারিখ</th>
                                    <th>নোট</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dadons as $dadon)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $dadon->name }}
                                        </td>
                                        <td>{{ $dadon->customer }}</td>
                                        <td>{{ number_format($dadon->total_given_amount, 2) }}</td>
                                        <td>{{ number_format($dadon->collections->sum('collection_amount'), 2) }}</td>
                                        <td>{{ ($dadon->total_given_amount - $dadon->collections->sum('collection_amount')) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($dadon->given_date)->format('Y-m-d') }}</td>
                                        <td>{{ $dadon->due_pay_date ? \Carbon\Carbon::parse($dadon->due_pay_date)->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $dadon->note ?? 'N/A' }}</td>
                                        <td>
                                            @if( $dadon->total_given_amount == $dadon->collections->sum('collection_amount'))
                                                সম্পূর্ণ
                                            @else
                                                বাকি
                                            @endif
                                        </td>
                                        <td>
                                            <a class="me-3" href="{{route('collections.show', $dadon->id)}}">
                                                <img src="{{asset('assets/img/icons/eye.svg')}}" alt="img">
                                            </a>
                                            <a class="me-3" href="{{route('collections.create', ['id' => $dadon->id])}}">
                                                <img src="{{asset('assets/img/icons/dollar-square.svg')}}" alt="img">
                                            </a>
                                            <a class="me-3" href="{{route('dadon.edit', ['id'=>$dadon->id] )}}">
                                                <img src="{{asset('assets/img/icons/edit.svg')}}" alt="img">
                                            </a>

                                            <form action="{{ route('dadon.destroy', $dadon->id) }}" method="POST"
                                                class="d-inline delete-form">
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
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
