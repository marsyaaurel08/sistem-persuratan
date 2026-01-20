@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Row 4 Card Dashboard -->
    <div class="page-header rounded">
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
                        <a class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between rounded-pill"
                            style="min-width: 180px; height: 38px;" data-bs-toggle="dropdown" data-bs-auto-close="outside">
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
                        <a class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between rounded-pill"
                            style="min-width: 180px; height: 38px;" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="feather-calendar me-2"></i>
                            <span>Rentang Tanggal</span>
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
                    <button class="btn d-flex align-items-center rounded-pill"
                        style="background-color: #000B58; color: #fff;">
                        <i class="feather-refresh-ccw me-2"></i>
                        <span>Perbarui Data</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="avatar-text avatar-lg rounded-3 border-0"
                            style="background-color: #e0f7fa; color: #00bcd4; width: 60px; height: 60px; font-size: 28px;">
                            <i class="feather-mail"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="fs-13 fw-bold text-muted mb-0">Total Surat Masuk</h3>
                        </div>
                    </div>
                    <div class="display-5 fw-bold text-dark mt-2">{{ $totalMasuk }}</div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="avatar-text avatar-lg rounded-3 border-0"
                            style="background-color: #fff3e0; color: #ff9800; width: 60px; height: 60px; font-size: 28px;">
                            <i class="feather-external-link"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="fs-13 fw-bold text-muted mb-0">Total Surat Keluar</h3>
                        </div>
                    </div>
                    <div class="display-5 fw-bold text-dark mt-2">{{ $totalKeluar }}</div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="avatar-text avatar-lg rounded-3 border-0"
                            style="background-color: #fffde7; color: #fbc02d; width: 60px; height: 60px; font-size: 28px;">
                            <i class="feather-clock"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="fs-13 fw-bold text-muted mb-0">Menunggu Respon</h3>
                        </div>
                    </div>
                    <div class="display-5 fw-bold text-dark mt-2">{{ $menungguRespon }}</div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full border-0 shadow-sm rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="avatar-text avatar-lg rounded-3 border-0"
                            style="background-color: #e8f5e9; color: #4caf50; width: 60px; height: 60px; font-size: 28px;">
                            <i class="feather-activity"></i>
                        </div>
                        <div class="text-start">
                            <h3 class="fs-13 fw-bold text-muted mb-0">Waktu Respon</h3>
                        </div>
                    </div>
                    <div class="d-flex align-items-baseline justify-content-center gap-2 mt-2">
                        <span class="display-5 fw-bold text-dark">{{ $waktuRespon }}</span>
                        <span class="fs-14 fw-bold text-muted">Hari</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styling tambahan untuk ukuran ikon dan angka */
        .avatar-lg {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            /* Mencegah ikon mengecil jika teks panjang */
        }

        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .display-5 {
            font-size: 3rem;
            /* Memperbesar angka utama */
        }
    </style>

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
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill py-2 ps-3">
                                <i class="feather-search text-muted"></i>
                            </span>
                            <input type="text" id="searchTable"
                                class="form-control border-start-0 rounded-end-pill py-2 shadow-none"
                                placeholder="Cari aktivitas..." style="font-size: 13px;">
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
                                @foreach($aktivitas as $item)
                                    <tr>
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                                        <td>
                                            @php
                                                $badge = [
                                                    'Selesai' => 'badge-success',
                                                    'Pending' => 'badge-warning',
                                                    'Disposisi' => 'badge-info'
                                                ][$item->status] ?? 'badge-secondary';
                                            @endphp
                                            <span class="badge-custom {{ $badge }}">{{ $item->status }}</span>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Ambil data dari controller (Laravel kirim ke Blade)
        const monthLabels = @json($months);
        const lineData = @json($chartData);
        const pieLabels = @json($pieLabels);
        const pieValues = @json($pieValues);

        // =============================
        // LINE CHART (Tren Surat)
        // =============================
        const ctxLine = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Total Surat',
                    data: lineData,
                    borderColor: '#000B58',
                    backgroundColor: 'rgba(0,11,88,0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // =============================
        // PIE CHART (Status Surat)
        // =============================
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieValues,
                    backgroundColor: ['#000B58', '#8BBCE7', '#FFEB3B', '#4CAF50', '#F44336']
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
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 12,
                            padding: 10,
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const value = context.raw;
                                const percent = ((value / total) * 100).toFixed(1);
                                return `${context.label}: ${value} (${percent}%)`;
                            }
                        }
                    }
                }
            }
        });

        // =============================
        // SEARCH TABLE (Aktivitas)
        // =============================
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