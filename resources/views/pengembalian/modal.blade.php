<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header modal-header-return">
                <h5 class="modal-title text-white">Proses Pengembalian Buku</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="returnForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="loan_date" placeholder="Tanggal Pinjam" readonly>
                                <label for="loan_date">Tanggal Pinjam</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="due_date" placeholder="Jatuh Tempo" readonly>
                                <label for="due_date">Jatuh Tempo</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="return_date" name="return_date" placeholder="Tanggal Kembali" required>
                                <label for="return_date">Tanggal Kembali</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control fine-amount" id="fine" name="fine" placeholder="Denda" readonly>
                                <label for="fine">Denda (Rp)</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="notes" name="notes" placeholder="Catatan" style="height: 100px"></textarea>
                                <label for="notes">Catatan Pengembalian</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="loan_id" name="loan_id">
                    <button type="button" class="btn btn-outline-return" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-return">
                        <i class="bx bx-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fine Setting Modal -->
<div class="modal fade" id="fineSettingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header modal-header-return">
                <h5 class="modal-title text-white">Pengaturan Denda</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="fineSettingForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="fine_amount" name="fine_amount" placeholder="Jumlah Denda" required>
                                <label for="fine_amount">Jumlah Denda per Hari (Rp)</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="grace_period" name="grace_period" placeholder="Masa Tenggang" required>
                                <label for="grace_period">Masa Tenggang (hari)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-return" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-return">
                        <i class="bx bx-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Return Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header modal-header-return">
                <h5 class="modal-title text-white">Detail Pengembalian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-primary"><i class="bx bx-book me-2"></i> Informasi Buku</h6>
                                <hr>
                                <div class="d-flex mb-3">
                                  <!--   <div class="flex-shrink-0">
                                        <img id="book-cover" src="" alt="Book Cover" class="rounded" width="80" height="120" onerror="this.src='{{ asset('assets/images/no-image.jpg') }}'">
                                    </div> -->
                                    <div class="flex-grow-1 ms-3">
                                        <h5 id="book-title" class="mb-1"></h5>
                                        <p class="mb-1"><small class="text-muted">Kode: </small><span id="book-code"></span></p>
                                        <p class="mb-1"><small class="text-muted">ISBN: </small><span id="book-isbn"></span></p>
                                        <p class="mb-1"><small class="text-muted">Pengarang: </small><span id="book-author"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-primary"><i class="bx bx-user me-2"></i> Informasi Member</h6>
                                <hr>
                                <div class="d-flex align-items-center mb-3">
                                    <!-- <div class="flex-shrink-0">
                                        <img id="member-photo" src="" alt="Member Photo" class="rounded-circle" width="60" height="60" onerror="this.src='{{ asset('assets/images/avatars/default.png') }}'">
                                    </div> -->
                                    <div class="flex-grow-1 ms-3">
                                        <h5 id="member-name" class="mb-0"></h5>
                                        <p class="mb-0"><small class="text-muted">ID: </small><span id="member-id"></span></p>
                                        <p class="mb-0"><small class="text-muted">Email: </small><span id="member-email"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title text-primary"><i class="bx bx-calendar me-2"></i> Detail Peminjaman</h6>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Tanggal Pinjam</label>
                                    <p id="detail-loan-date" class="fw-bold"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Jatuh Tempo</label>
                                    <p id="detail-due-date" class="fw-bold"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Tanggal Kembali</label>
                                    <p id="detail-return-date" class="fw-bold"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status</label>
                                    <p><span id="detail-status" class="status-badge"></span></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Denda</label>
                                    <p id="detail-fine" class="fine-amount fw-bold"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Lama Pinjam</label>
                                    <p id="detail-duration" class="fw-bold"></p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <label class="form-label text-muted">Catatan</label>
                            <p id="detail-notes" class="fw-bold"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-return" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-return" id="print-receipt">
                    <i class="bx bx-printer me-1"></i> Cetak Bukti
                </button>
            </div>
        </div>
    </div>
</div>