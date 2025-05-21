@extends('main')
@section('content')

<style>
    .modal-center {
        margin-right: 20%;
    }
</style>

<div class="page-wrapper">
    <div class="page-content">

        <!-- Modal -->
        <!-- Modal -->
        <div class="modal fade modal-center" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">Tambah Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" method="post" action="{{ route('add.category') }}" novalidate="">
                            @csrf
                            <div class="col-md-6">
                                <label for="bsValidation1" class="form-label">Nama Buku</label>
                                <input type="text" class="form-control" id="bsValidation1" placeholder="Nama Buku" required="" name="name">
                                <div class="valid-feedback">
                                    Looks good!
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <label for="bsValidation2" class="form-label">Kode Buku</label>
                                <input type="text" class="form-control" id="bsValidation2" placeholder="Kode Buku" name="code" required="">
                                <div class="valid-feedback">
                                    Looks good!
                                  </div>
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


        <div class="card radius-10">
            <div class="card-header bg-transparent">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">Tambah</button>
                        </h6>
                    </div>
                </div>
               </div>
            <div class="card-body">
            <div class="table-responsive">
              <table class="table align-middle mb-0">
               <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Kategori Buku</th>
                  <th>Kode Buku</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $key => $category)
                <tr>
                        
                    
                    <td>{{ $key +1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->code }}</td>
                    <td>
                        <a href="" class="btn btn-sm btn-primary mx-1"><i class="bx bx-pencil"></i></a>
                        <a href="" class="btn btn-sm btn-primary mx-1"><i class="bx bx-pencil"></i></a>
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