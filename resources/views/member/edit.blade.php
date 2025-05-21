@extends('main')
@section('content')
@include('layouts.style')

<div class="page-wrapper">
    <div class="page-content">
        
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h4><span class="badge bg-primary">Edit Member</span></h4>
                        </h6>
                    </div>
                    <div class="dropdown ms-auto">
                        <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
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
                <form class="row g-3 needs-validation" novalidate="" action="{{ route('update.member', $members->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="fancy-file-upload" class="form-label">Image</label>
                                <div class="upload-card" id="upload-card">
                                    <!-- Wrapper for Image Preview -->
                                    <div id="image-preview" style="{{ $members->avatar ? '' : 'display: none;' }}">
                                        @if($members->avatar)
                                            <img src="{{ asset('storage/' . $members->avatar) }}" alt="Preview" class="img-fluid mb-2" style="max-height: 200px;">
                                            <button id="remove-button" class="remove-button" type="button" onclick="removeImage()">&times;</button>
                                        @endif
                                    </div>
                                    
                                    <!-- File Input -->
                                    <label for="fancy-file-upload" class="upload-label">Choose Image</label>
                                    <input id="fancy-file-upload" type="file" name="avatar" accept=".jpg, .png, image/jpeg, image/png" onchange="previewImage(event)">
                                    
                                    <!-- Remove Button (Hidden by Default) -->
                                    <button id="remove-button" class="remove-button" style="{{ $members->avatar ? '' : 'display: none;' }}" type="button" onclick="removeImage()">&times;</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation1" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name')
                                    is-invalid
                                @enderror" id="bsValidation1" placeholder="name" required name="name" value="{{ $members->name }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            
                            
                            
                            <div class="col-md-6">
                                <label for="phone" class="form-label">phone</label>
                                <input type="number" class="form-control @error('phone')
                                    is-invalid
                                @enderror" id="phone" placeholder="phone" name="phone" required value="{{ $members->phone }}">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <label for="bsValidation13" class="form-label">Address</label>
                                <textarea class="form-control @error('address')
                                    is-invalid
                                @enderror" id="bsValidation13" placeholder="Address ..." name="address" rows="3" required>{{ $members->address }}</textarea>
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



@endsection