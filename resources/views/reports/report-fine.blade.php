@extends('main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/custom/css/daterangepicker.css') }}">
<link href="{{ asset('assets/custom/css/sweetalert2.min.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('assets/custom/css/pengembalian.css') }}">

{{-- data table --}}
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet"/>
{{-- <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" /> --}}

@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0"><button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#formModal">Tambah</button>
                        </h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                                class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="fine-table" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Member</th>
                                <th width="10%">Buku</th>
                                <th width="10%">Tanggal Peminjaman</th>
                                <th width="10%">Jatuh Tempo</th>
                                <th width="10%">Status</th>
                                <th width="10%">Denda</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('pengembalian.modal')

@endsection
@push('js')
<script src="{{ asset('assets/custom/js/sweetalert2.min.js') }}"></script>

<!-- Gunakan CDN untuk moment.js -->
<script src="{{ asset('assets/custom/js/moment.min.js') }}"></script>

<!-- Gunakan CDN untuk daterangepicker -->
<script src="{{ asset('assets/custom/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	

{{-- get fine all --}}
<script>
$(document).ready(function () {
    $('#fine-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("get.all.fine") }}', // Sesuaikan dengan route kamu
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'member_name', name: 'member_name' },
            { data: 'book_title', name: 'book_title' },
            { data: 'loan_date', name: 'loan_date' },
            { data: 'due_date', name: 'due_date' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'fine', name: 'fine' },
        ]
    });
});
</script>

@endpush