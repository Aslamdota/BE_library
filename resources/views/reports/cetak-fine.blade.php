<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Denda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            padding: 30px;
        }

        .receipt {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            width: 21cm;
            min-height: 29.7cm;
            margin: auto;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
        }

        .receipt h5 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .receipt .text-muted {
            font-size: 0.9rem;
        }

        .library-logo {
            width: 60px;
            margin-bottom: 10px;
        }

        .btn-print {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
            width: 100%;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                margin: 0;
                width: 100%;
                padding: 0;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <section class="content">
        <div class="container-fluid">
            <div class="receipt">
                <div class="text-center mb-4">
                    <img src="https://img.icons8.com/color/96/books.png" alt="Logo Perpustakaan" class="library-logo">
                    <h5>Perpustakaan Barokah</h5>
                    <div class="text-muted">Jl. Sukawening KM 04 Ciwidey, Bandung</div>
                    <div class="text-muted">+62 857 2181 9759</div>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <div class="fw-bold">Tanggal Cetak</div>
                        <div class="text-muted">{{ $now }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">{{ Auth::user()->role }}</div>
                        <div class="text-muted">{{ Auth::user()->name }}</div>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Laporan Semua Denda</h6>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Member</th>
                                <th width="10%">Buku</th>
                                <th width="10%">Tanggal Peminjaman</th>
                                <th width="10%">Jatuh Tempo</th>
                                <th width="10%">Status</th>
                                <th width="10%">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fines as $key => $fine)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $fine->member->name }}</td>
                                <td>{{ $fine->book->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($fine->loan_date)->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($fine->due_date)->translatedFormat('d F Y') }}</td>
                                <td>{{ $fine->status === 'overdue' ? 'Terlambat' : $fine->status }}</td>
                                <td>Rp {{ number_format($fine->fine, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Contoh detail pembayaran atau status -->
                <hr class="my-4">
                <div class="row">
                    <div class="col-md-6">
                        @foreach ($fines as $item)
                        <div><strong>Status Peminjaman:</strong> <span class="text-success">{{ $fine->status === 'overdue' ? 'Terlambat' : $fine->status }}<span></div>
                        @endforeach
                    </div>
                    
                </div>

            </div>
        </div>
    </section>

</body>
</html>

<script>
    window.print();
</script>