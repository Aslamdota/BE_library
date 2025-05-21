@extends('main')
@push('css')
<link href="{{ asset('assets/custom/css/sweetalert2.min.css') }}" rel="stylesheet" />
{{-- data table --}}
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
{{-- <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" /> --}}

<style>
    .modal-center {
        margin-right: 20%;
    }

</style>
@endpush
@section('content')

@include('layouts.style')

<!-- Modaal konfirm -->
<div class="modal fade modal-center" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" novalidate="" action="{{ route('store.member') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <label for="fancy-file-upload" class="form-label">Image</label>
                        <div class="upload-card" id="upload-card">
                            <div id="image-preview" style="display: none;"></div>
                            <label for="fancy-file-upload" class="upload-label">Choose Image</label>
                            <input id="fancy-file-upload" type="file" name="avatar"
                                accept=".jpg, .png, image/jpeg, image/png" onchange="previewImage(event)">
                            <button id="remove-button" class="remove-button" style="display: none;" type="button"
                                onclick="removeImage()">&times;</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="bsValidation1" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name')
                                    is-invalid
                                @enderror" id="bsValidation1" placeholder="Input name ..." required name="name">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="col-md-6">
                        <label for="bsValidation2" class="form-label">Member Id</label>
                        <input type="text" class="form-control @error('member_id')
                                    is-invalid
                                @enderror" id="bsValidation2" placeholder="Member Id" name="member_id" required>
                        @error('member_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div class="col-md-6">
                        <label for="bsValidation3" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email')
                                    is-invalid
                                @enderror" id="bsValidation3" placeholder="email" name="email" required>
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="bsValidation4" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password')
                                    is-invalid
                                @enderror" id="bsValidation4" placeholder="password" name="Password" required>
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="bsValidation4" class="form-label">Phone</label>
                        <input type="number" class="form-control @error('phone')
                                    is-invalid
                                @enderror" id="bsValidation4" placeholder="number" name="phone" required>
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="bsValidation13" class="form-label">Address</label>
                        <textarea class="form-control @error('address')
                                    is-invalid
                                @enderror" id="bsValidation13" placeholder="Address ..." name="address" rows="3"
                            required></textarea>
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <div class="d-md-flex d-grid align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                            <button type="reset" class="btn btn-light px-4">Reset</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

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
                    <table id="members-table" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Member</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Avatar</th>
                                <th>Aksi</th>
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

@push('js')
<script src="{{ asset('assets/custom/js/sweetalert2.min.js') }}"></script>

<!-- Gunakan CDN untuk moment.js -->
<script src="{{ asset('assets/custom/js/moment.min.js') }}"></script>

<!-- Gunakan CDN untuk daterangepicker -->
<script src="{{ asset('assets/custom/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#members-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("view.member") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'member_id',
                    name: 'member_id',
                    render: function (data) {
                        return '<span class="badge bg-gradient-quepal text-white shadow-sm w-10">' +
                            data + '</span>';
                    }
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'avatar',
                    name: 'avatar',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // Handle delete button
        $('#members-table').on('click', '.delete-btn', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            $('#members-table').DataTable().ajax.reload();
                            Swal.fire('Berhasil!', response.message, 'success');
                        },
                        error: function (xhr) {
                            Swal.fire('Gagal!', 'Gagal menghapus user.', 'error');
                        }
                    });
                }
            });
        });
    });

</script>

@endpush

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('formModal'));
        myModal.show();
    });

</script>
@endif

@endsection
