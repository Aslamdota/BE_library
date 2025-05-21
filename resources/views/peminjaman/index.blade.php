@extends('main')
@push('css')
<link rel="stylesheet" href="{{ asset('assets/custom/css/daterangepicker.css') }}">
<link href="{{ asset('assets/custom/css/sweetalert2.min.css') }}" rel="stylesheet"/>
{{-- data table --}}
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet"/>
{{-- <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" /> --}}

@endpush
@section('content')

<style>
    .modal-center {
        margin-right: 20%;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                            <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="borrowings-table" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Buku</th>
                                <th>Member</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirm -->
<div class="modal fade modal-center" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Konfirmasi Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="confirmForm" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <label for="noted" class="form-label">Catatan</label>
                        <textarea class="form-control" id="noted" name="noted" placeholder="Catatan ..." rows="3"></textarea>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                        <button type="reset" class="btn btn-light px-4">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tolak -->
<div class="modal fade modal-center" id="formTolak" tabindex="-1" aria-labelledby="formTolakLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Catatan Penolakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <label for="noted" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="noted" name="noted" placeholder="Masukkan alasan penolakan ..." rows="3" required></textarea>
                        <div class="invalid-feedback">Masukkan alasan penolakan.</div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                        <button type="reset" class="btn btn-light px-4">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="{{ asset('assets/custom/js/sweetalert2.min.js') }}"></script>

<!-- Gunakan CDN untuk moment.js -->
<script src="{{ asset('assets/custom/js/moment.min.js') }}"></script>

<!-- Gunakan CDN untuk daterangepicker -->
<script src="{{ asset('assets/custom/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	
<script>
    $(document).ready(function() {
        var table = $('#borrowings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/viewPeminjaman',
                type: 'GET'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'book_title', name: 'book.title' },
                { data: 'member_name', name: 'member.name' },
                { 
                    data: 'loan_date', 
                    name: 'loan_date',
                    render: function(data) {
                        return new Date(data).toLocaleDateString('id-ID', { 
                            day: 'numeric', 
                            month: 'long', 
                            year: 'numeric' 
                        });
                    }
                },
                { 
                    data: 'status', 
                    name: 'status',
                    render: function(data) {
                        return '<span class="badge bg-gradient-quepal text-white shadow-sm w-10">'+data+'</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <a href="${row.id}" class="badge bg-primary confirm-btn" data-bs-toggle="modal" data-bs-target="#formModal">Konfirm</a>
                            <a href="${row.id}" class="badge bg-danger reject-btn" data-bs-toggle="modal" data-bs-target="#formTolak">Tolak</a>
                        `;
                    }
                }
            ]
        });

        // Handle confirm button click
        $('#borrowings-table').on('click', '.confirm-btn', function(e) {
            e.preventDefault();
            var borrowingId = $(this).attr('href');
            $('#confirmForm').attr('action', '/borrowings/confirm/' + borrowingId);
        });

        // Handle reject button click
        $('#borrowings-table').on('click', '.reject-btn', function(e) {
            e.preventDefault();
            var borrowingId = $(this).attr('href');
            $('#rejectForm').attr('action', '/borrowings/reject/' + borrowingId);
        });

        // Handle form submission
        $('#confirmForm, #rejectForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            
            $.ajax({
                url: url,
                type: method,
                data: form.serialize(),
                success: function(response) {
                    $('.modal').modal('hide');
                    table.ajax.reload();
                    toastr.success(response.message);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endpush