@extends('main')
@section('content')

@include('layouts.style')

<!-- Modaal konfirm -->
<div class="modal fade modal-center" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate="" action="{{ route('store.user') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="fancy-file-upload" class="form-label">Image</label>
                                <div class="upload-card" id="upload-card">
                                    <div id="image-preview" style="display: none;"></div>
                                    <label for="fancy-file-upload" class="upload-label">Choose Image</label>
                                    <input id="fancy-file-upload" class="@error('avatar')
                                        is-invalid
                                    @enderror" type="file" name="avatar" accept=".jpg, .png, image/jpeg, image/png" onchange="previewImage(event)">
                                    <button id="remove-button" class="remove-button" style="display: none;" type="button" onclick="removeImage()">&times;</button>
                                </div>
                                @error('avatar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation1" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name')
                                    is-invalid
                                @enderror" id="bsValidation1" placeholder="Name" required name="name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation2" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email')
                                    is-invalid
                                @enderror" id="bsValidation2" placeholder="Email Books" name="email" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="bsValidation2" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password')
                                    is-invalid
                                @enderror" id="bsValidation2" placeholder="Password" name="password" required>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            
                            <div class="col-md-6">
                                <label for="bsValidation9" class="form-label">Role</label>
                                <select id="bsValidation9" name="role" class="form-select @error('role')
                                    is-invalid
                                @enderror" required>
                                    <option selected disabled value="">Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="karyawan">Karyawan</option>
                                </select>
                                @error('role')
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
                <h6 class="mb-0">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">Tambah</button>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="users-table" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("view.user") }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { 
                    data: 'role', name: 'role',
                    render: function(data) {
                        return '<span class="badge bg-gradient-quepal text-white shadow-sm w-10">'+data+'</span>';
                    } 
                },
                { data: 'avatar', name: 'avatar', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Handle delete button
        $('#users-table').on('click', '.delete-btn', function(e) {
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
                        success: function(response) {
                            $('#users-table').DataTable().ajax.reload();
                            Swal.fire('Berhasil!', response.message, 'success');
                        },
                        error: function(xhr) {
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
