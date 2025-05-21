@extends('main')

@section('content')

<div class="page-wrapper">
    <div class="page-content">
        {{-- card --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="my-1 text-info">{{ \App\Models\Loan::count() }}</h4>
                                <p class="mb-0 text-secondary">Total Peminjaman</p>

                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i
                                    class="bx bxs-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="my-1 text-danger">{{ \App\Models\Returns::count() }}</h4>
                                <p class="mb-0 text-secondary">Total Pengembalian</p>
                                {{-- <p class="mb-0 font-13">+5.4% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i
                                    class="bx bxs-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="my-1 text-success">{{ \App\Models\Book::count() }}</h4>
                                <p class="mb-0 text-secondary">Total Buku</p>
                                {{-- <p class="mb-0 font-13">-4.5% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                    class="bx bxs-bar-chart-alt-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="my-1 text-warning">{{ \App\Models\member::count() }}</h4>
                                <p class="mb-0 text-secondary">Total Member</p>
                                {{-- <p class="mb-0 font-13">+8.4% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i
                                    class="bx bxs-group"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <p class="font-weight-bold mb-1 text-secondary">Grafik Peminjaman</p>
                        <div class="d-flex align-items-center mb-4">
                            <div>
                                <h4 class="mb-0">{{ array_sum($counts) }}</h4>
                            </div>
                            <div class="ms-2">
                                <p class="mb-0 align-self-center font-weight-bold text-success">Peminjaman <i
                                        class="bx bxs-up-arrow-alt"></i></p>
                            </div>
                        </div>
                        <div class="chart-container-0 mt-5">
                            <canvas id="chart3" data-labels="{{ json_encode($labels) }}"
                                data-counts="{{ json_encode($counts) }}" width="400" height="320"
                                style="display: block; box-sizing: border-box;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-4">
                <div class="card radius-10 w-100">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Grafik Pengembalian</h6>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-horizontal-rounded font-22 text-option"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container-1 mt-3">
                            <canvas id="chart4" width="400" height="260" data-labels="{{ json_encode($labelReturn) }}"
                                data-counts="{{ json_encode($countReturn) }}"
                                style="display: block; box-sizing: border-box;"></canvas>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li
                            class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                            Pending <span class="badge bg-gradient-quepal rounded-pill">{{ $pending }}</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            Dipinjam <span class="badge bg-gradient-ibiza rounded-pill">{{ $borrowed }}</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            Ditolak <span class="badge bg-gradient-deepblue rounded-pill">{{ $rejected }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        {{-- <div class="col d-flex">
            <div class="card radius-10 w-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Grafik Pengembalian</h6>
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
                    <div class="chart-container-0">
                        <canvas id="chart5" width="784" height="320" data-labels="{{ json_encode($labelReturn) }}"
                            data-counts="{{ json_encode($countReturn) }}"
                            style="display: block; box-sizing: border-box; height: 320px; width: 784px;">
                        </canvas>
                    </div>
                </div>
                <div class="row row-group border-top g-0">
                    <div class="col">
                        <div class="p-3 text-center">
                            <h4 class="mb-0 text-danger">$45,216</h4>
                            <p class="mb-0">Clothing</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 text-center">
                            <h4 class="mb-0 text-success">$68,154</h4>
                            <p class="mb-0">Electronic</p>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div> --}}

        {{-- <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Sales Overview</h6>
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
                        <div class="chart-container-0">
                            <canvas id="chart1" width="784" height="320"
                                style="display: block; box-sizing: border-box; height: 320px; width: 784px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card radius-10">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Order Status</h6>
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
                        <div class="chart-container-0">
                            <canvas id="chart2" width="784" height="320"
                                style="display: block; box-sizing: border-box; height: 320px; width: 784px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    const chartElement = document.getElementById("chart5");
    if (!chartElement) {
        console.error("Element #chart5 tidak ditemukan");
        return;
    }

    const labels = JSON.parse(chartElement.getAttribute("data-labels") || "[]");
    const counts = JSON.parse(chartElement.getAttribute("data-counts") || "[]");

    const ctx = chartElement.getContext('2d');

    const gradientStroke1 = ctx.createLinearGradient(0, 0, 0, 300);
    gradientStroke1.addColorStop(0, '#f54ea2');
    gradientStroke1.addColorStop(1, '#ff7676');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Status Pengembalian',
                data: counts,
                borderColor: gradientStroke1,
                backgroundColor: gradientStroke1,
                hoverBackgroundColor: gradientStroke1,
                pointRadius: 0,
                fill: false,
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            barPercentage: 0.5,
            categoryPercentage: 0.8,
            plugins: {
                legend: {
                    display: true,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5  // buat interval sumbu Y kelipatan 5
                    }
                }
            }
        }
    });
});
</script>




@endsection