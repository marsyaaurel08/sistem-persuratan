@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Row 4 Card Dashboard -->
    <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Dashboard</h5>
                    </div>
                </div>

                <div class="page-header-right ms-auto">
                    <div class="page-header-right-items">
                        <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">

                            <!-- Dropdown Semua Divisi -->
                            <div class="dropdown">
                                <a class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between"
                                    style="min-width: 180px; height: 38px;" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside">
                                    <i class="feather-layers me-2"></i>
                                    <span>Semua Divisi</span>
                                    <i class="feather-chevron-down ms-2"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3">
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="divisi1" checked>
                                        <label class="form-check-label" for="divisi1">Divisi A</label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="divisi2" checked>
                                        <label class="form-check-label" for="divisi2">Divisi B</label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" id="divisi3">
                                        <label class="form-check-label" for="divisi3">Divisi C</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Dropdown Rentang Tanggal -->
                            <div class="dropdown">
                                <a class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between"
                                    style="min-width: 180px; height: 38px;" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside">
                                    <i class="feather-calendar me-2"></i>
                                    <span>01 Jan 2026 - 31 Jan 2026</span>
                                    <i class="feather-chevron-down ms-2"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3">
                                    <div class="form-check mb-1">
                                        <input type="text" class="form-control" placeholder="Pilih tanggal awal">
                                    </div>
                                    <div class="form-check mb-1">
                                        <input type="text" class="form-control" placeholder="Pilih tanggal akhir">
                                    </div>
                                    <div class="mt-2 d-flex justify-content-between">
                                        <button class="btn btn-sm btn-light">Reset</button>
                                        <button class="btn btn-sm btn-success">Terapkan</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Button Perbarui Data -->
                            <button class="btn d-flex align-items-center"
                                style="background-color: #000B58; color: #fff;">
                                <i class="feather-refresh-ccw me-2"></i>
                                <span>Perbarui Data</span>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
    <div class="row g-2">
        <!-- Card 1 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">45</span>/<span
                                        class="counter">76</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">Invoices Awaiting Payment</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);"
                                class="fs-11 fw-medium text-muted text-truncate-1-line">Invoices</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">$5,569</span>
                                <span class="fs-10 text-muted">(56%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 56%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-cast"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">48</span>/<span
                                        class="counter">86</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">Converted Leads</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-11 fw-medium text-muted text-truncate-1-line">Converted
                                Leads</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">52 Completed</span>
                                <span class="fs-10 text-muted">(63%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 63%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-users"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">32</span>/<span
                                        class="counter">50</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">New Customers</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-11 fw-medium text-muted text-truncate-1-line">New
                                Customers</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">32</span>
                                <span class="fs-10 text-muted">(64%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 64%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-shopping-cart"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">28</span>/<span
                                        class="counter">40</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">Orders Pending</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-11 fw-medium text-muted text-truncate-1-line">Orders
                                Pending</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">28</span>
                                <span class="fs-10 text-muted">(70%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row Grafik -->
    <div class="row g-2 mt-3">
        <!-- Line Chart Lebih Lebar -->
        <div class="col-xxl-8 col-xl-8 col-lg-12 col-md-12">
            <div class="card p-2" style="height: 280px;"> <!-- card tidak terlalu tinggi -->
                <div class="card-body d-flex flex-column h-100">
                    <h5 class="fs-14 fw-semibold mb-2">Sales Trend</h5>
                    <div class="flex-grow-1">
                        <canvas id="lineChart" style="width:100%; height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12">
            <div class="card p-2" style="height: 280px;">
                <div class="card-body d-flex flex-column h-100">
                    <h5 class="fs-14 fw-semibold mb-2">Orders Distribution</h5>
                    <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                        <canvas id="pieChart" style="width:100%; height:100%; max-height: 180px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Row Aktivitas Terbaru -->
    <div class="row g-2 mt-3">
        <div class="col-12">
            <div class="card stretch stretch-full p-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fs-14 fw-semibold mb-0">Aktivitas Terbaru</h5>

                        <!-- Search Input with Icon -->
                        <div class="input-group" style="max-width: 250px;">
                            <span class="input-group-text bg-white border-end-0 rounded-start" id="search-icon">
                                <i class="feather-search"></i>
                            </span>
                            <input type="text" id="searchTable" class="form-control rounded-end"
                                placeholder="Cari aktivitas...">
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle" id="aktivitasTable">
                            <thead>
                                <tr>
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Asal / Tujuan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001/INV/2026</td>
                                    <td>Pembayaran Invoice</td>
                                    <td>PT ABC / Finance</td>
                                    <td>19 Jan 2026</td>
                                    <td><span class="badge-custom badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td>002/INV/2026</td>
                                    <td>Order Barang</td>
                                    <td>PT XYZ / Warehouse</td>
                                    <td>18 Jan 2026</td>
                                    <td><span class="badge-custom badge-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>003/INV/2026</td>
                                    <td>Proposal Kerja Sama</td>
                                    <td>Marketing / PT DEF</td>
                                    <td>17 Jan 2026</td>
                                    <td><span class="badge-custom badge-danger">Ditolak</span></td>
                                </tr>
                                <tr>
                                    <td>004/INV/2026</td>
                                    <td>Follow Up Payment</td>
                                    <td>Finance / PT GHI</td>
                                    <td>16 Jan 2026</td>
                                    <td><span class="badge-custom badge-info">Proses</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Line Chart
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Sales',
                    data: [12, 19, 14, 21, 17, 23],
                    borderColor: '#000B58',
                    backgroundColor: 'rgba(0,11,88,0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Pie Chart
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Nota Dinas', 'Undangan', 'Lainnya'],
                datasets: [{
                    data: [31, 48, 21],
                    backgroundColor: ['#000B58', '#8BBCE7', '#FFEB3B']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        align: 'center',
                        labels: {
                            usePointStyle: true, // lingkaran
                            pointStyle: 'circle',
                            boxWidth: 12,
                            padding: 10,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.chart._metasets[context.datasetIndex].total;
                                let percentage = ((value / total) * 100).toFixed(0);
                                return `${label}: ${percentage} %`;
                            }
                        }
                    }
                }
            }
        });


    </script>
    <script>
        // Simple Search Table
        document.getElementById('searchTable').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#aktivitasTable tbody tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endpush