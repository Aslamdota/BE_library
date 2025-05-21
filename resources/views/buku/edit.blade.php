@extends('main')
@section('content')
@include('layouts.style')
<div class="page-wrapper">
    <div class="page-content">
        
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h4><span class="badge bg-primary">Edit Buku</span></h4>
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
                <form class="row g-3 needs-validation" novalidate="" action="{{ route('update.books', $books->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12">
                                <label for="fancy-file-upload" class="form-label">Image</label>
                                <div class="upload-card" id="upload-card">
                                    <!-- Wrapper for Image Preview -->
                                    <div id="image-preview" style="{{ $books->cover_image ? '' : 'display: none;' }}">
                                        @if($books->cover_image)
                                            <img src="{{ asset('storage/' . $books->cover_image) }}" alt="Preview" class="img-fluid mb-2" style="max-height: 200px;">
                                            <button id="remove-button" class="remove-button" type="button" onclick="removeImage()">&times;</button>
                                        @endif
                                    </div>
                                    
                                    <!-- File Input -->
                                    <label for="fancy-file-upload" class="upload-label">Choose Image</label>
                                    <input id="fancy-file-upload" type="file" name="cover_image" accept=".jpg, .png, image/jpeg, image/png" onchange="previewImage(event)">
                                    
                                    <!-- Remove Button (Hidden by Default) -->
                                    <button id="remove-button" class="remove-button" style="{{ $books->cover_image ? '' : 'display: none;' }}" type="button" onclick="removeImage()">&times;</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation1" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title')
                                    is-invalid
                                @enderror" id="bsValidation1" placeholder="Title" required name="title" value="{{ $books->title }}">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation2" class="form-label">Author</label>
                                <input type="text" class="form-control @error('author')
                                    is-invalid
                                @enderror" id="bsValidation2" placeholder="Author Books" name="author" required value="{{ $books->author }}">
                                @error('author')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation3" class="form-label">Publisher</label>
                                <input type="text" class="form-control @error('publisher')
                                    is-invalid
                                @enderror" id="bsValidation3" placeholder="publisher" name="publisher" value="{{ $books->publisher }}" required>
                                @error('publisher')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation4" class="form-label">Isbn</label>
                                <input type="text" class="form-control @error('isbn')
                                    is-invalid
                                @enderror" id="bsValidation4" placeholder="isbn" name="isbn" required value="{{ $books->isbn }}">
                                @error('isbn')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" class="form-control @error('publication_year')
                                    is-invalid
                                @enderror" id="year" placeholder="Year" name="publication_year" value="{{ $books->publication_year }}" required>
                                @error('publication_year')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control @error('stock')
                                    'is-invalid'
                                @enderror" id="stock" placeholder="stock" name="stock" required value="{{ $books->stock }}">
                                @error('stock')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation9" class="form-label">Kategori</label>
                                <select id="bsValidation9" name="category_id" class="form-select @error('category_id')
                                    is-invalid
                                @enderror" required>
                                    <option selected disabled value="">Pilih Kategory</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ $books->category_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation13" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description')
                                    is-invalid
                                @enderror" id="bsValidation13" placeholder="Deskripsi ..." name="description" rows="3" required>{{ $books->description }}</textarea>
                                @error('description')
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