@extends('main')
@section('content')
@include('layouts.style')

<div class="page-wrapper">
    <div class="page-content">
        
        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h4><span class="badge bg-primary">Edit Kategori</span></h4>
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
                <form class="row g-3 needs-validation" novalidate="" action="{{ route('update.category', $categories->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="col-md-6">
                                <label for="bsValidation1" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name')
                                    is-invalid
                                @enderror" id="bsValidation1" placeholder="name" required name="name" value="{{ $categories->name }}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            
                            
                            
                            <div class="col-md-6">
                                <label for="code" class="form-label">Kode</label>
                                <input type="text" class="form-control @error('code')
                                    is-invalid
                                @enderror" id="code" placeholder="code" name="code" required value="{{ $categories->code }}">
                                @error('code')
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