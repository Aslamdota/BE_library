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
        <div class="card card-return radius-10">
            <div class="card-header card-header-return">
                <div class="d-flex align-items-center">
                    <div>
                        <h6 class="mb-0 text-white">Manajemen Pengembalian Buku</h6>
                        <p class="mb-0 text-white-50">Kelola proses pengembalian dan riwayat peminjaman</p>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-light btn-sm btn-pulse" data-bs-toggle="modal" data-bs-target="#fineSettingModal">
                            <i class="bx bx-cog me-1"></i> Pengaturan Denda
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary mb-4" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pinjamReturns" role="tab" aria-selected="true">
                            <i class="bx bx-time me-1"></i> Pinjam
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#kembaliReturns" role="tab" aria-selected="false">
                            <i class="bx bx-time me-1"></i> Kembali
                        </a>
                    </li>
                    
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#returnHistory" role="tab" aria-selected="false">
                            <i class="bx bx-history me-1"></i> Riwayat
                        </a>
                    </li>
                </ul>
                
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pinjamReturns" role="tabpanel">
                        <div class="table-responsive">
                            <table id="pinjam-table" class="table table-return table-hover" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Kode</th>
                                        <th>Buku</th>
                                        <th>Member</th>
                                        <th width="10%">Pinjam</th>
                                        <th width="10%">Jatuh Tempo</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="kembaliReturns" role="tabpanel">
                        <div class="table-responsive">
                            <table id="kembali-table" class="table table-return table-hover" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Kode</th>
                                        <th>Buku</th>
                                        <th>Member</th>
                                        <th width="10%">Pinjam</th>
                                        <th width="10%">Jatuh Tempo</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="returnHistory" role="tabpanel">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                    <input type="text" id="date-range-filter" class="form-control" placeholder="Filter tanggal">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select id="status-filter" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="returned">Dikembalikan</option>
                                    <option value="overdue">Terlambat</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="search-history" class="form-control" placeholder="Cari...">
                                    <button class="btn btn-outline-secondary" type="button" id="reset-filters">
                                        <i class="bx bx-reset"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table id="history-table" class="table table-return table-hover" style="width:100%">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Kode</th>
                                        <th>Buku</th>
                                        <th>Member</th>
                                        <th width="10%">Pinjam</th>
                                        <th width="10%">Jatuh Tempo</th>
                                        <th width="10%">Kembali</th>
                                        <th width="10%">Denda</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Aksi</th>
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
	
<script>
$(document).ready(function() {
    // Check if required elements exist before initializing
    if (!$('meta[name="csrf-token"]').length) {
        console.error('CSRF token meta tag is missing');
        return;
    }

    // Set CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize date range picker only if element exists
    if ($('#date-range-filter').length) {
        $('#date-range-filter').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                fromLabel: 'Dari',
                toLabel: 'Sampai',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                firstDay: 1
            },
            opens: 'right',
            autoUpdateInput: false
        });

        $('#date-range-filter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            if (typeof historyTable !== 'undefined') {
                historyTable.draw();
            }
        });

        $('#date-range-filter').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            if (typeof historyTable !== 'undefined') {
                historyTable.draw();
            }
        });
    }

    // Set today as default return date if element exists
    if ($('#return_date').length) {
        $('#return_date').val(new Date().toISOString().split('T')[0]);
    }
    
    // Initialize DataTables only if tables exist
    var kembaliTable, historyTable, pinjamTable;
    if ($('#pinjam-table').length) {
        pinjamTable = $('#pinjam-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('returns.data_borrowing') }}",
                type: "GET"
            },
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada peminjaman yang perlu diproses",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false,
                    className: 'text-center'
                },
                { 
                    data: 'id', 
                    name: 'id',
                    className: 'text-center',
                    render: function(data) {
                        return 'PJ-' + (data ? data.toString().padStart(4, '0') : '0000');
                    }
                },
                { 
                    data: 'book.title', 
                    name: 'book.title',
                    render: function(data, type, row) {
                        if (!row.book) return '-';
                        return `<div class="d-flex align-items-center cursor-pointer" onclick="showBookDetail(${row.book.id || 0})">
                            <div class="ms-2">
                                <h6 class="mb-0 text-ellipsis">${data || '-'}</h6>
                                <small class="text-muted">Kode: ${row.book.code || '-'}</small>
                            </div>
                        </div>`;
                    }
                },
                { 
                    data: 'member.name', 
                    name: 'member.name',
                    render: function(data, type, row) {
                        if (!row.member) return '-';
                        return `<div class="cursor-pointer" onclick="showMemberDetail(${row.member.id || 0})">
                            <h6 class="mb-0 text-ellipsis">${data || '-'}</h6>
                            <small class="text-muted">ID: ${row.member.member_id || '-'}</small>
                        </div>`;
                    }
                },
                { 
                    data: 'loan_date', 
                    name: 'loan_date',
                    render: function(data) {
                        return data ? moment(data).format('DD MMM YYYY') : '-';
                    }
                },
                { 
                    data: 'due_date', 
                    name: 'due_date',
                    render: function(data) {
                        if (!data) return '-';
                        const dueDate = moment(data);
                        const today = moment();
                        const isOverdue = dueDate.isBefore(today, 'day');
                        
                        return `<span class="fw-bold ${isOverdue ? 'text-danger' : ''}">${dueDate.format('DD MMM YYYY')}</span>`;
                    }
                },
                { 
                    data: 'status', 
                    name: 'status',
                    className: 'text-center',
                    render: function(data) {
                        let statusText = '';
                        switch(data) {
                            case 'pending': statusText = 'Menunggu'; break;
                            case 'borrowed': statusText = 'Dipinjam'; break;
                            case 'returned': statusText = 'Dikembalikan'; break;
                            case 'rejected': statusText = 'Ditolak'; break;
                            case 'overdue': statusText = 'Terlambat'; break;
                            default: statusText = data || '-';
                        }
                        return `<span class="status-badge badge-${data || ''}">${statusText}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (!row.id) return '-';
                        return `
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-return process-return" data-id="${row.id}" title="Proses Pengembalian">
                                    <i class="bx bx-undo me-1"></i> Proses
                                </button>
                                <button class="btn btn-sm btn-outline-secondary view-detail" data-id="${row.id}" title="Lihat Detail">
                                    <i class="bx bx-show"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function(settings) {
                // Add hover effects
                $('.process-return').hover(
                    function() {
                        $(this).addClass('shadow-sm');
                    },
                    function() {
                        $(this).removeClass('shadow-sm');
                    }
                );
                
                $('.view-detail').hover(
                    function() {
                        $(this).addClass('shadow-sm');
                    },
                    function() {
                        $(this).removeClass('shadow-sm');
                    }
                );
            }
        });
    }

    
    if ($('#kembali-table').length) {
        kembaliTable = $('#kembali-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('returns.data') }}",
                type: "GET"
            },
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada peminjaman yang perlu diproses",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false,
                    className: 'text-center'
                },
                { 
                    data: 'id', 
                    name: 'id',
                    className: 'text-center',
                    render: function(data) {
                        return 'PJ-' + (data ? data.toString().padStart(4, '0') : '0000');
                    }
                },
                { 
                    data: 'book.title', 
                    name: 'book.title',
                    render: function(data, type, row) {
                        if (!row.book) return '-';
                        return `<div class="d-flex align-items-center cursor-pointer" onclick="showBookDetail(${row.book.id || 0})">
                            <div class="ms-2">
                                <h6 class="mb-0 text-ellipsis">${data || '-'}</h6>
                                <small class="text-muted">Kode: ${row.book.code || '-'}</small>
                            </div>
                        </div>`;
                    }
                },
                { 
                    data: 'member.name', 
                    name: 'member.name',
                    render: function(data, type, row) {
                        if (!row.member) return '-';
                        return `<div class="cursor-pointer" onclick="showMemberDetail(${row.member.id || 0})">
                            <h6 class="mb-0 text-ellipsis">${data || '-'}</h6>
                            <small class="text-muted">ID: ${row.member.member_id || '-'}</small>
                        </div>`;
                    }
                },
                { 
                    data: 'loan_date', 
                    name: 'loan_date',
                    render: function(data) {
                        return data ? moment(data).format('DD MMM YYYY') : '-';
                    }
                },
                { 
                    data: 'due_date', 
                    name: 'due_date',
                    render: function(data) {
                        if (!data) return '-';
                        const dueDate = moment(data);
                        const today = moment();
                        const isOverdue = dueDate.isBefore(today, 'day');
                        
                        return `<span class="fw-bold ${isOverdue ? 'text-danger' : ''}">${dueDate.format('DD MMM YYYY')}</span>`;
                    }
                },
                { 
                    data: 'status', 
                    name: 'status',
                    className: 'text-center',
                    render: function(data) {
                        let statusText = '';
                        switch(data) {
                            case 'pending': statusText = 'Menunggu'; break;
                            case 'borrowed': statusText = 'Dipinjam'; break;
                            case 'returned': statusText = 'Dikembalikan'; break;
                            case 'rejected': statusText = 'Ditolak'; break;
                            case 'overdue': statusText = 'Terlambat'; break;
                            default: statusText = data || '-';
                        }
                        return `<span class="status-badge badge-${data || ''}">${statusText}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (!row.id) return '-';
                        return `
                            <div class="btn-group" role="group">                                
                                <button class="btn btn-sm btn-outline-secondary view-detail" data-id="${row.id}" title="LihatDetail">
                                    <i class="bx bx-show"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function(settings) {
                // Add hover effects
                $('.process-return').hover(
                    function() {
                        $(this).addClass('shadow-sm');
                    },
                    function() {
                        $(this).removeClass('shadow-sm');
                    }
                );
                
                $('.view-detail').hover(
                    function() {
                        $(this).addClass('shadow-sm');
                    },
                    function() {
                        $(this).removeClass('shadow-sm');
                    }
                );
            }
        });
    }

    if ($('#history-table').length) {
        historyTable = $('#history-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('returns.history_data') }}",
                type: "GET",
                data: function(d) {
                    // Add your filter parameters here
                    d.date_range = $('#date-range-filter').val();
                    d.status = $('#status-filter').val();
                    d.search = $('#search-history').val();
                }
            },
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ada riwayat pengembalian",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            columns: [
                { 
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false, 
                    searchable: false,
                    className: 'text-center'
                },
                { 
                    data: 'id', 
                    name: 'id',
                    className: 'text-center',
                    render: function(data) {
                        return 'PJ-' + (data ? data.toString().padStart(4, '0') : '0000');
                    }
                },
                { 
                    data: 'book.title', 
                    name: 'book.title',
                    render: function(data, type, row) {
                        if (!row.book) return '-';
                        return `<div class="d-flex align-items-center cursor-pointer" onclick="showBookDetail(${row.book.id || 0})">
                            <div class="ms-2">
                                <h6 class="mb-0 text-ellipsis">${data || '-'}</h6>
                                <small class="text-muted">Kode: ${row.book.code || '-'}</small>
                            </div>
                        </div>`;
                    }
                },
                { 
                    data: 'member.name', 
                    name: 'member.name',
                    render: function(data, type, row) {
                        if (!row.member) return '-';
                        return `<div class="cursor-pointer" onclick="showMemberDetail(${row.member.id || 0})">
                            <h6 class="mb-0 text-ellipsis">${data || '-'}</h6>
                            <small class="text-muted">ID: ${row.member.member_id || '-'}</small>
                        </div>`;
                    }
                },
                { 
                    data: 'loan_date', 
                    name: 'loan_date',
                    render: function(data) {
                        return data ? moment(data).format('DD MMM YYYY') : '-';
                    }
                },
                { 
                    data: 'due_date', 
                    name: 'due_date',
                    render: function(data) {
                        return data ? moment(data).format('DD MMM YYYY') : '-';
                    }
                },
                { 
                    data: 'return_date', 
                    name: 'return_date',
                    render: function(data) {
                        if (!data) return '-';
                        return moment(data).format('DD MMM YYYY');
                    }
                },
                { 
                    data: 'fine', 
                    name: 'fine',
                    className: 'text-end',
                    render: function(data) {
                        return data ? `<span class="fine-amount">Rp ${parseInt(data).toLocaleString('id-ID')}</span>` : '-';
                    }
                },
                { 
                    data: 'status', 
                    name: 'status',
                    className: 'text-center',
                    render: function(data) {
                        let statusText = '';
                        switch(data) {
                            case 'pending': statusText = 'Menunggu'; break;
                            case 'borrowed': statusText = 'Dipinjam'; break;
                            case 'returned': statusText = 'Dikembalikan'; break;
                            case 'rejected': statusText = 'Ditolak'; break;
                            case 'overdue': statusText = 'Terlambat'; break;
                            default: statusText = data || '-';
                        }
                        return `<span class="status-badge badge-${data || ''}">${statusText}</span>`;
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (!row.id) return '-';
                        return `
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-secondary view-detail" data-id="${row.id}" title="Lihat Detail">
                                    <i class="bx bx-show"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function(settings) {
                // Add hover effects to clickable elements
                $('.cursor-pointer').hover(
                    function() {
                        $(this).css('opacity', '0.8');
                    },
                    function() {
                        $(this).css('opacity', '1');
                    }
                );
            }
        });

        // Add event listeners for filters
        $('#date-range-filter, #status-filter').change(function() {
            historyTable.ajax.reload();
        });

        $('#search-history').keyup(function() {
            historyTable.search($(this).val()).draw();
        });

        $('#reset-filters').click(function() {
            $('#date-range-filter').val('');
            $('#status-filter').val('');
            $('#search-history').val('');
            historyTable.search('').draw();
        });
    }

    // Load fine settings
    function loadFineSettings() {
        $.ajax({
            url: "{{ route('fine.get') }}",
            type: "GET",
            success: function(data) {
                if ($('#fine_amount').length) {
                    $('#fine_amount').val(data.fine_amount);
                }
                if ($('#grace_period').length) {
                    $('#grace_period').val(data.grace_period);
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal memuat pengaturan denda',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Show return modal
    $(document).on('click', '.process-return', function() {
        var loanId = $(this).data('id');
        
        $.ajax({
            url: "/loans/" + loanId,
            type: "GET",
            beforeSend: function() {
                // Show loading indicator
                $('#returnModal .modal-body').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data peminjaman...</p>
                    </div>
                `);
            },
            success: function(data) {
                // Restore form content
                $('#returnModal .modal-body').html(`
                    <div class="row g-3">
                        <input type="hidden" id="loan_id" name="loan_id" value="${data.id || ''}">
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
                `);
                
                // Set form values
                $('#loan_id').val(data.id || '');
                $('#loan_date').val(data.loan_date ? moment(data.loan_date).format('DD MMMM YYYY') : '-');
                $('#due_date').val(data.due_date ? moment(data.due_date).format('DD MMMM YYYY') : '-');
                $('#return_date').val(new Date().toISOString().split('T')[0]);
                
                // Store original due date for calculation
                $('#due_date').data('original-date', data.due_date);
                
                // Calculate fine if overdue
                if (data.due_date) {
                    calculateFine(data.due_date);
                }
                
                $('#returnModal').modal('show');
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal memuat data peminjaman',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    // Handle return date change
    $(document).on('change', '#return_date', function() {
        var dueDate = $('#due_date').data('original-date');
        if (dueDate) {
            calculateFine(dueDate);
        }
    });

    function calculateFine(dueDate) {
        var returnDate = $('#return_date').val();
        if (!returnDate) return;
        
        var returnDateObj = new Date(returnDate);
        var dueDateObj = new Date(dueDate);
        
        if (returnDateObj > dueDateObj) {
            var diffDays = Math.ceil((returnDateObj - dueDateObj) / (1000 * 60 * 60 * 24));
            $.ajax({
                url: "{{ route('fine.get') }}",
                type: "GET",
                success: function(data) {
                    var fine = diffDays * data.fine_amount;
                    $('#fine').val('Rp ' + fine.toLocaleString('id-ID'));
                },
                error: function() {
                    $('#fine').val('Rp 0');
                }
            });
        } else {
            $('#fine').val('Rp 0');
        }
    }

    // Submit return form
    $('#returnForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
        
        $.ajax({
            url: "/loans/" + ($('#loan_id').val() || '') + "/return",
            type: "POST",
            data: form.serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Pengembalian berhasil diproses',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                $('#returnModal').modal('hide');
                if (typeof pinjamTable !== 'undefined') {
                    pinjamTable.ajax.reload();
                }
                if (typeof historyTable !== 'undefined') {
                    historyTable.ajax.reload();
                }
                 if (typeof historyTable !== 'undefined') {
                    historyTable.ajax.reload();
                }
            },
            error: function(xhr) {
                let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat memproses pengembalian';
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: errorMessage,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> Simpan');
            }
        });
    });

    // Load and handle fine settings
    loadFineSettings();
    
    if ($('#fineSettingForm').length) {
        $('#fineSettingForm').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var submitBtn = form.find('button[type="submit"]');
            
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');
            
            $.ajax({
                url: "{{ route('fine.update') }}",
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Pengaturan denda berhasil disimpan',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#fineSettingModal').modal('hide');
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat menyimpan pengaturan';
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMessage,
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html('<i class="bx bx-save me-1"></i> Simpan Pengaturan');
                }
            });
        });
    }

    // Show detail modal
   $(document).on('click', '.view-detail', function() {
    var loanId = $(this).data('id');
        // Show the modal immediately with loading state
        $('#detailModal').modal('show');
        $('#detailModal .modal-body').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat detail peminjaman...</p>
            </div>
        `);
        
        $.ajax({
            url: "/loans/" + loanId,
            type: "GET",
            success: function(data) {
                // Check if modal still exists (user hasn't closed it)
                if (!$('#detailModal').length) return;
                
                // Populate modal with data
                let modalContent = `
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Detail Buku</h5>
                            <hr>
                            <p><strong>Judul:</strong> ${data.book?.title || '-'}</p>
                            <p><strong>Kode:</strong> ${data.book?.code || '-'}</p>
                            <p><strong>ISBN:</strong> ${data.book?.isbn || '-'}</p>
                            <p><strong>Pengarang:</strong> ${data.book?.author || '-'}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Detail Peminjam</h5>
                            <hr>
                            <p><strong>Nama:</strong> ${data.member?.name || '-'}</p>
                            <p><strong>ID Member:</strong> ${data.member?.member_id || '-'}</p>
                            <p><strong>Email:</strong> ${data.member?.email || '-'}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Detail Peminjaman</h5>
                            <hr>
                            <p><strong>Tanggal Pinjam:</strong> ${data.loan_date ? moment(data.loan_date).format('DD MMMM YYYY') : '-'}</p>
                            <p><strong>Jatuh Tempo:</strong> ${data.due_date ? moment(data.due_date).format('DD MMMM YYYY') : '-'}</p>
                            <p><strong>Tanggal Kembali:</strong> ${data.return_date ? moment(data.return_date).format('DD MMMM YYYY') : '-'}</p>
                `;
                
                // Calculate duration
                if (data.loan_date) {
                    const loanDate = moment(data.loan_date);
                    const returnDate = data.return_date ? moment(data.return_date) : moment();
                    const duration = returnDate.diff(loanDate, 'days') + 1;
                    modalContent += `<p><strong>Durasi:</strong> ${duration} hari</p>`;
                }
                
                // Status with badge
                let statusText = '';
                switch(data.status) {
                    case 'pending': statusText = 'Menunggu'; break;
                    case 'borrowed': statusText = 'Dipinjam'; break;
                    case 'returned': statusText = 'Dikembalikan'; break;
                    case 'rejected': statusText = 'Ditolak'; break;
                    case 'overdue': statusText = 'Terlambat'; break;
                    default: statusText = data.status || '-';
                }
                modalContent += `<p><strong>Status:</strong> <span class="badge badge-${data.status || ''}">${statusText}</span></p>`;
                
                // Fine and notes
                modalContent += `
                            <p><strong>Denda:</strong> ${data.fine ? 'Rp ' + parseInt(data.fine).toLocaleString('id-ID') : 'Rp 0'}</p>
                            <p><strong>Catatan:</strong> ${data.notes || '-'}</p>
                        </div>
                    </div>
                `;
                
                $('#detailModal .modal-body').html(modalContent);
            },
            error: function(xhr) {
                // Check if modal still exists (user hasn't closed it)
                if (!$('#detailModal').length) return;
                
                $('#detailModal .modal-body').html(`
                    <div class="alert alert-danger">
                        Gagal memuat detail peminjaman. Silakan coba lagi.
                    </div>
                `);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal memuat detail peminjaman',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });
    // Print receipt
    if ($('#print-receipt').length) {
        $('#print-receipt').click(function() {
            Swal.fire({
                icon: 'info',
                title: 'Cetak Bukti',
                text: 'Fitur cetak bukti akan diimplementasikan',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }
});

// Show book detail
function showBookDetail(bookId) {
    if (!bookId) return;
    
    Swal.fire({
        title: 'Memuat detail buku...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            
            $.ajax({
                url: "/books/" + bookId,
                type: "GET",
                success: function(data) {
                    Swal.fire({
                        title: data.title || 'Detail Buku',
                        html: `
                            <div class="text-start">
                                <p><strong>Kode:</strong> ${data.code || '-'}</p>
                                <p><strong>ISBN:</strong> ${data.isbn || '-'}</p>
                                <p><strong>Pengarang:</strong> ${data.author || '-'}</p>
                                <p><strong>Penerbit:</strong> ${data.publisher || '-'}</p>
                                <p><strong>Tahun:</strong> ${data.year || '-'}</p>
                                <p><strong>Kategori:</strong> ${data.category || '-'}</p>
                            </div>
                        `,
                        showConfirmButton: true
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat detail buku',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
}

// Show member detail
function showMemberDetail(memberId) {
    if (!memberId) return;
    
    Swal.fire({
        title: 'Memuat detail member...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
            
            $.ajax({
                url: "/members/" + memberId,
                type: "GET",
                success: function(data) {
                    Swal.fire({
                        title: data.name || 'Detail Member',
                        html: `
                            <div class="text-start">
                                <p><strong>ID Member:</strong> ${data.member_id || '-'}</p>
                                <p><strong>Email:</strong> ${data.email || '-'}</p>
                                <p><strong>Telepon:</strong> ${data.phone || '-'}</p>
                                <p><strong>Alamat:</strong> ${data.address || '-'}</p>
                                <p><strong>Status:</strong> ${data.status || '-'}</p>
                            </div>
                        `,
                        showConfirmButton: true
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat detail member',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    });
}
</script>
@endpush