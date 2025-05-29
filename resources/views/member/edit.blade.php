@extends('main')
@section('content')
@include('layouts.style')

<div class="page-wrapper">
    <div class="page-content">
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div class="row w-100">
                        <div class="col-md-5">
                            <h4><span class="badge bg-primary">Edit Member</span></h4>
                        </div>
                        <div class="col-md-7 text-end">
                            @if (!$members->is_active)
                                <form action="{{ route('resend.otp', $members->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Kirim Ulang OTP</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="card-body">
                <form class="row g-3 needs-validation" novalidate action="{{ route('update.member', $members->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Upload Image --}}
                    <div class="col-md-12">
                        <label for="fancy-file-upload" class="form-label">Image</label>
                        <div class="upload-card" id="upload-card">
                            <div id="image-preview" style="{{ $members->avatar ? '' : 'display: none;' }}">
                                @if($members->avatar)
                                    <img src="{{ asset('storage/' . $members->avatar) }}" alt="Preview" class="img-fluid mb-2" style="max-height: 200px;">
                                    <button class="remove-button" type="button" onclick="removeImage()">&times;</button>
                                @endif
                            </div>
                            <label for="fancy-file-upload" class="upload-label">Choose Image</label>
                            <input id="fancy-file-upload" type="file" name="avatar" accept=".jpg, .png, image/jpeg, image/png" onchange="previewImage(event)">
                        </div>
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" name="name" placeholder="Name" required value="{{ $members->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror"
                            id="phone" name="phone" placeholder="Phone" required value="{{ $members->phone }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="col-md-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" rows="3" placeholder="Address ..." required>{{ $members->address }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit Buttons --}}
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

{{-- Script to remove image --}}
<script>
    function removeImage() {
        const preview = document.getElementById('image-preview');
        const input = document.getElementById('fancy-file-upload');
        preview.style.display = 'none';
        input.value = '';
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = `<img src="${reader.result}" alt="Preview" class="img-fluid mb-2" style="max-height: 200px;">
                                 <button class="remove-button" type="button" onclick="removeImage()">&times;</button>`;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

@endsection
