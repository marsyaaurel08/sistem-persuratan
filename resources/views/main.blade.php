@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">

                    <!-- Filter tanggal -->
                    <div class="input-group align-items-center border border-secondary-subtle rounded-pill"
                        style="width: 220px; height: 38px; overflow: hidden; font-size: small; background-color: white;">
                        <span
                            class="input-group-text bg-white border-0 px-2 d-flex align-items-center justify-content-center">
                            <i class="feather-calendar"></i>
                        </span>
                        <input type="text" id="dateRange" class="form-control border-0 bg-white px-2 h-100"
                            placeholder="Pilih Tanggal" readonly
                            style="cursor: pointer; font-size: small; line-height: normal;">
                        <button class="btn border-0 bg-white d-flex align-items-center justify-content-center px-2 h-100"
                            type="button" id="clearDateRange" title="Reset tanggal" style="display: none;">
                            <i class="feather-x"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-wrapper">
        <!-- Row Statistik -->
        <div class="row g-3">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
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

            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
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

            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                <div class="card stretch stretch-full border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="avatar-text avatar-lg rounded-3 border-0"
                                style="background-color: #e8f5e9; color: #4caf50; width: 60px; height: 60px; font-size: 28px;">
                                <i class="feather-file-text"></i>
                            </div>
                            <div class="text-start">
                                <h3 class="fs-13 fw-bold text-muted mb-0">Total Surat Laporan</h3>
                            </div>
                        </div>
                        <div class="display-5 fw-bold text-dark mt-2">0</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="row g-2 mt-3">
            <div class="col-12">
                <div class="card p-3" style="height: 420px;">
                    <div class="card-body d-flex flex-column h-100">
                        <h5 class="fs-16 fw-semibold mb-3">Tren Persuratan Berdasarkan Waktu</h5>
                        <div class="flex-grow-1">
                            <canvas id="lineChart" style="width:100%; height:100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="row g-2 mt-3">
            <div class="col-12">
                <div class="card stretch stretch-full p-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fs-14 fw-semibold mb-0">Aktivitas Terbaru</h5>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aktivitas as $item)
                                        <tr data-date="{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('Y-m-d') }}">
                                            <td>{{ $item->nomor_surat }}</td>
                                            <td>{{ $item->perihal }}</td>
                                            <td>{{ $item->lokasi }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-lg {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .display-5 {
            font-size: 3rem;
        }

        .dashboard-wrapper {
            padding: 10px 15px;
        }
    </style>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        $(function () {
            const $dateInput = $('#dateRange');
            const $clearBtn = $('#clearDateRange');
            const $tableBody = $('#aktivitasTable tbody');
            const ctxLine = document.getElementById('lineChart');

            let selectedTanggal = [];

            // === Inisialisasi Flatpickr (Range Mode) ===
            const fp = flatpickr($dateInput[0], {
                mode: "range",
                locale: "id",
                dateFormat: "d M Y",
                onChange: function (selectedDates) {
                    if (selectedDates.length === 2) {
                        const start = formatDate(selectedDates[0]);
                        const end = formatDate(selectedDates[1]);
                        selectedTanggal = [start, end];
                        $clearBtn.show();
                        applyFilter();
                    }
                }
            });

            // Format tanggal YYYY-MM-DD
            function formatDate(date) {
                const d = new Date(date);
                const m = (d.getMonth() + 1).toString().padStart(2, "0");
                const day = d.getDate().toString().padStart(2, "0");
                return `${d.getFullYear()}-${m}-${day}`;
            }

            // Tombol Reset
            $clearBtn.on('click', function () {
                fp.clear();
                $dateInput.val('');
                $(this).hide();
                selectedTanggal = [];
                applyFilter();
            });

            // === Fungsi Filter dengan AJAX ===
            function applyFilter() {
                $.ajax({
                    url: "{{ route('dashboard.filter') }}",
                    type: 'GET',
                    data: { tanggal: selectedTanggal },
                    success: function (res) {
                        // 🔹 Update KPI
                        $('.card:contains("Total Surat Masuk") .display-5').text(res.totalMasuk);
                        $('.card:contains("Total Surat Keluar") .display-5').text(res.totalKeluar);
                        $('.card:contains("Total Surat Laporan") .display-5').text(res.totalLaporan ?? 0);

                        // 🔹 Update Tabel
                        $tableBody.empty();
                        if (res.aktivitas && res.aktivitas.length) {
                            res.aktivitas.forEach(a => {
                                $tableBody.append(`
                                <tr>
                                    <td>${a.nomor_surat}</td>
                                    <td>${a.perihal}</td>
                                    <td>${a.lokasi}</td>
                                    <td>${moment(a.tanggal_surat).format('DD MMM YYYY')}</td>
                                </tr>
                            `);
                            });
                        } else {
                            $tableBody.html('<tr><td colspan="4" class="text-center text-muted py-3">Tidak ada data</td></tr>');
                        }

                        // 🔹 Update Grafik
                        if (window.lineChart) window.lineChart.destroy();

                        const parentCard = $(ctxLine).closest('.card')[0];
                        const chartWidth = parentCard.clientWidth;
                        const chartHeight = parentCard.clientHeight - 60; // biar proporsional

                        ctxLine.width = chartWidth;
                        ctxLine.height = chartHeight;

                        window.lineChart = new Chart(ctxLine, {
                            type: 'line',
                            data: {
                                labels: res.months,
                                datasets: [{
                                    label: 'Total Surat',
                                    data: res.chartData,
                                    borderColor: '#000B58',
                                    backgroundColor: 'rgba(0,11,88,0.2)',
                                    tension: 0.4,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: { y: { beginAtZero: true } }
                            }
                        });

                        // 🔹 Paksa resize setelah DOM reflow selesai
                        setTimeout(() => {
                            if (window.lineChart) {
                                window.lineChart.resize();
                            }
                        }, 300);
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            }

            // === Inisialisasi Chart Awal ===
            if (ctxLine) {
                const parentCard = $(ctxLine).closest('.card')[0];
                ctxLine.width = parentCard.clientWidth;
                ctxLine.height = parentCard.clientHeight - 60;

                window.lineChart = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: @json($months),
                        datasets: [{
                            label: 'Total Surat',
                            data: @json($chartData),
                            borderColor: '#000B58',
                            backgroundColor: 'rgba(0,11,88,0.2)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });

                // Auto-resize saat window berubah ukuran
                window.addEventListener('resize', () => {
                    if (window.lineChart) window.lineChart.resize();
                });
            }
        });
    </script>
@endpush