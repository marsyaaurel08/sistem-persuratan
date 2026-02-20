@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">

                    <!-- Filter tanggal FIX -->
                    <div class="input-group rounded-pill border border-secondary-subtle align-items-center"
                        style="width: 220px; height: 40px; overflow: hidden; font-size: small;">

                        <span
                            class="input-group-text bg-white border-0 d-flex align-items-center justify-content-center px-2 h-100">
                            <i class="feather-calendar"></i>
                        </span>

                        <input type="text" id="dateRange" class="form-control border-0 px-2 h-100"
                            placeholder="Pilih Tanggal" readonly
                            style="cursor: pointer; font-size: small; background-color: white; line-height: normal;">

                        <button class="btn btn-light border-0 d-flex align-items-center justify-content-center px-2 h-100"
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
                        <div class="display-5 fw-bold text-dark mt-2" id="totalMasuk">{{ $totalMasuk }}</div>
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
                        <div class="display-5 fw-bold text-dark mt-2" id="totalKeluar">{{ $totalKeluar }}</div>
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
                        <div class="display-5 fw-bold text-dark mt-2" id="totalLaporan">{{ $totalLaporan }}</div>
                    </div>
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

                        <div class="input-group rounded-pill border border-secondary-subtle align-items-center"
                            style="max-width: 250px; height: 40px; overflow: hidden; font-size: small;">

                            <span
                                class="input-group-text bg-white border-0 d-flex align-items-center justify-content-center px-2 h-100">
                                <i class="feather-search text-muted"></i>
                            </span>

                            <input type="text" id="searchTable" class="form-control border-0 px-2 h-100"
                                placeholder="Cari aktivitas..."
                                style="font-size: small; background-color: white; line-height: normal;">

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle" id="aktivitasTable">
                            <thead class="small">
                                <tr>
                                    <th>Kode Arsip</th>
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Tanggal</th>
                                    <th>Pengarsip</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @foreach ($aktivitas as $item)
                                    <tr class="data-row"
                                        data-date="{{ \Carbon\Carbon::parse($item['tanggal_arsip'])->format('Y-m-d') }}">
                                        <td class="text-nowrap">
                                            <span class="badge bg-light text-dark border">
                                                {{ $item['kode_arsip'] }}
                                            </span>
                                        </td>
                                        <td class="fw-bold">
                                            {{ $item['nomor_surat'] ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item['perihal'] ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item['tanggal_view'] ?? '-' }}
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $item['pengarsip'] ?? '-' }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr id="noDataRow" style="display: none;">
                                    <td colspan="100%" class="text-center text-muted py-3">
                                        Tidak ada data yang sesuai dengan filter atau pencarian.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%" height="600px" id="previewFrame"></iframe>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .main-content {
            height: auto !important;
            overflow: visible !important;
        }

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

        .input-group-text,
        .input-group .form-control {
            border: 1px solid #ced4da;
        }

        .input-group .form-control:focus {
            box-shadow: none;
        }

        .input-group {
            border-radius: 50px;
            overflow: hidden;
        }

        .input-group-text {
            background-color: #fff;
            /* samakan dengan input */
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        /* Focus effect satu kesatuan */
        .input-group:focus-within {
            border-color: #3473d8;
            box-shadow: 0 0 0 2px rgba(10, 59, 139, 0.514);
        }

        #clearDateRange:hover,
        #clearDateRange:focus,
        #clearDateRange:active {
            background-color: #f8f9fa !important;
            box-shadow: none !important;
            outline: none !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>

    <script>
        const downloadBase = "{{ url('arsip/download') }}";
    </script>
    <script>
        function filterSearch() {
            const keyword = $('#searchTable').val().toLowerCase();
            let visibleCount = 0;

            $('#aktivitasTable tbody tr.data-row').each(function() {
                const rowText = $(this).text().toLowerCase();
                const match = rowText.includes(keyword);

                $(this).toggle(match);

                if (match) visibleCount++;
            });

            $('#noDataRow').toggle(visibleCount === 0);
        }
    </script>
    <script>
        $(function() {
            const $dateInput = $('#dateRange');
            const $clearBtn = $('#clearDateRange');
            const $tableBody = $('#aktivitasTable tbody');
            const ctxLine = document.getElementById('lineChart');

            let selectedTanggal = [];
            let fp; // simpan instance supaya bisa destroy & reinit

            // === Inisialisasi Flatpickr (Range Mode) ===
            function initFlatpickr() {
                fp = flatpickr($dateInput[0], {
                    mode: "range",
                    locale: "id",
                    dateFormat: "d M Y",
                    onChange: function(selectedDates) {
                        if (selectedDates.length === 2) {
                            const start = formatDate(selectedDates[0]);
                            const end = formatDate(selectedDates[1]);
                            selectedTanggal = [start, end];
                            $clearBtn.show();
                            applyFilter();
                        }
                    }
                });
            }
            initFlatpickr();

            $('#searchTable').on('keyup', function() {
                filterSearch();
            });

            // Format tanggal YYYY-MM-DD
            function formatDate(date) {
                const d = new Date(date);
                const m = (d.getMonth() + 1).toString().padStart(2, "0");
                const day = d.getDate().toString().padStart(2, "0");
                return `${d.getFullYear()}-${m}-${day}`;
            }

            // === PERBAIKAN: Tombol Reset Tanggal ===
            $clearBtn.on('click', function() {
                // Hapus input dan sembunyikan tombol X
                $dateInput.val('');
                $(this).hide();
                selectedTanggal = [];

                // Hancurkan flatpickr lama dan buat ulang biar highlight hilang
                if (fp) {
                    fp.destroy();
                }
                initFlatpickr();

                // Ambil ulang data dashboard tanpa filter
                $.ajax({
                    url: "{{ route('dashboard.filter') }}",
                    type: 'GET',
                    data: {}, // kosong total, jangan kirim tanggal
                    success: function(res) {
                        // Update statistik dan grafik
                        $('#totalMasuk').text(res.totalMasuk);
                        $('#totalKeluar').text(res.totalKeluar);
                        $('#totalLaporan').text(res.totalLaporan);

                        // Update tabel aktivitas
                        const $tableBody = $('#aktivitasTable tbody');
                        $tableBody.empty();

                        if (res.aktivitas && res.aktivitas.length) {
                            res.aktivitas.forEach(a => {
                                $tableBody.append(`
                                    <tr class="data-row" data-date="${a.tanggal_arsip}">
                                        <td class="text-nowrap">
                                            <span class="badge bg-light text-dark border">${a.kode_arsip}</span>
                                        </td>
                                        <td class="fw-bold">${a.nomor_surat ?? '-'}</td>
                                        <td>${a.perihal ?? '-'}</td>
                                        <td>${a.tanggal_view ?? '-'}</td>
                                        <td><small class="text-muted">${a.pengarsip ?? '-'}</small></td>
                                    </tr>
                                `);
                            });
                        } else {
                            // $tableBody.html(
                            //     '<tr><td colspan="6" class="text-center text-muted py-3">Tidak ada data</td></tr>'
                            // );
                            $tableBody.empty();

                            if (res.aktivitas && res.aktivitas.length) {
                                res.aktivitas.forEach(a => {
                                    $tableBody.append(`
            <tr class="data-row" data-date="${a.tanggal_arsip}">
                <td class="text-nowrap">
                    <span class="badge bg-light text-dark border">
                        ${a.kode_arsip}
                    </span>
                </td>
                <td class="fw-bold">${a.nomor_surat ?? '-'}</td>
                <td>${a.perihal ?? '-'}</td>
                <td>${a.tanggal_view ?? '-'}</td>
                <td><small class="text-muted">${a.pengarsip ?? '-'}</small></td>
            </tr>
        `);
                                });
                            }

                            // 🔥 Tambahkan kembali noDataRow setelah append
                            $tableBody.append(`
    <tr id="noDataRow" style="display: none;">
        <td colspan="100%" class="text-center text-muted py-3">
            Tidak ada data yang sesuai dengan filter atau pencarian.
        </td>
    </tr>
`);

                            // filterSearch();
                        }

                        filterSearch();

                        // Update chart
                        if (window.lineChart) window.lineChart.destroy();

                        const ctxLine = document.getElementById('lineChart');
                        const parentCard = $(ctxLine).closest('.card')[0];
                        ctxLine.width = parentCard.clientWidth;
                        ctxLine.height = parentCard.clientHeight - 60;

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
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // === Fungsi Filter dengan AJAX ===
            function applyFilter() {
                $.ajax({
                    url: "{{ route('dashboard.filter') }}",
                    type: 'GET',
                    data: selectedTanggal.length ? {
                        tanggal: selectedTanggal
                    } : {},
                    success: function(res) {
                        // 🔹 Update KPI
                        $('#totalMasuk').text(res.totalMasuk);
                        $('#totalKeluar').text(res.totalKeluar);
                        $('#totalLaporan').text(res.totalLaporan);

                        // 🔹 Update Tabel
                        $tableBody.empty();
                        if (res.aktivitas && res.aktivitas.length) {
                            res.aktivitas.forEach(a => {
                                let filesHtml = '';
                                if (a.files && a.files.length) {
                                    filesHtml = '<div class="d-flex flex-wrap gap-1"></div>';
                                } else {
                                    filesHtml = '<span class="text-muted">-</span>';
                                }

                                $tableBody.append(`
                                    <tr class="data-row" data-date="${a.tanggal_arsip}">
                                        <td class="text-nowrap">
                                            <span class="badge bg-light text-dark border">
                                                ${a.kode_arsip}
                                            </span>
                                        </td>
                                        <td class="fw-bold">${a.nomor_surat ?? '-'}</td>
                                        <td>${a.perihal ?? '-'}</td>
                                        <td>${a.tanggal_view ?? '-'}</td>
                                        <td><small class="text-muted">${a.pengarsip ?? '-'}</small></td>
                                        <td>${filesHtml}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            $tableBody.empty();

                            if (res.aktivitas && res.aktivitas.length) {
                                res.aktivitas.forEach(a => {
                                    $tableBody.append(`
            <tr class="data-row" data-date="${a.tanggal_arsip}">
                <td class="text-nowrap">
                    <span class="badge bg-light text-dark border">
                        ${a.kode_arsip}
                    </span>
                </td>
                <td class="fw-bold">${a.nomor_surat ?? '-'}</td>
                <td>${a.perihal ?? '-'}</td>
                <td>${a.tanggal_view ?? '-'}</td>
                <td><small class="text-muted">${a.pengarsip ?? '-'}</small></td>
            </tr>
        `);
                                });
                            }

                            // 🔥 Tambahkan kembali noDataRow setelah append
                            $tableBody.append(`
    <tr id="noDataRow" style="display: none;">
        <td colspan="100%" class="text-center text-muted py-3">
            Tidak ada data yang sesuai dengan filter atau pencarian.
        </td>
    </tr>
`);

                            // filterSearch();
                            // $tableBody.html(
                            //     '<tr><td colspan="6" class="text-center text-muted py-3">Tidak ada data</td></tr>'
                            // );
                        }

                        filterSearch();

                        // 🔹 Update Grafik
                        if (window.lineChart) window.lineChart.destroy();

                        const parentCard = $(ctxLine).closest('.card')[0];
                        ctxLine.width = parentCard.clientWidth;
                        ctxLine.height = parentCard.clientHeight - 60;

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
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    },
                    error: function(xhr) {
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
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                window.addEventListener('resize', () => {
                    if (window.lineChart) window.lineChart.resize();
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.preview-btn');
                if (!btn) return;

                const iframe = document.getElementById('previewFrame');
                iframe.src = btn.dataset.file;
            });

            const modal = document.getElementById('previewModal');
            modal.addEventListener('hidden.bs.modal', function() {
                document.getElementById('previewFrame').src = '';
            });

            // const previewButtons = document.querySelectorAll('.preview-btn');
            // const iframe = document.getElementById('previewFrame');

            previewButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const fileUrl = this.dataset.file;
                    console.log('Preview file URL:', fileUrl); // cek di console
                    iframe.src = fileUrl;
                });
            });

            // Clear iframe saat modal ditutup
            const modal = document.getElementById('previewModal');
            modal.addEventListener('hidden.bs.modal', function() {
                iframe.src = '';
            });
        });
    </script>
@endpush
