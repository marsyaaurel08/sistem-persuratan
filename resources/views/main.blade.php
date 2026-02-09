@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    {{--
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>
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
                    {{-- <div class="dropdown">
                        <button
                            class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between rounded-pill"
                            style="min-width: 180px; height: 38px;" type="button" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-expanded="false">
                            <i class="feather-layers me-2"></i>
                            <span>Semua Divisi</span>
                            <i class="feather-chevron-down ms-2"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end p-3 shadow-sm" style="min-width: 240px;">
                            <!-- Checkbox pilih semua -->
                            <div class="form-check mb-2 border-bottom pb-2">
                                <input class="form-check-input" type="checkbox" id="pilihSemuaDivisi" checked>
                                <label class="form-check-label fw-bold" for="pilihSemuaDivisi">
                                    Pilih Semua
                                </label>
                            </div>

                            <!-- Daftar divisi -->
                            @foreach ($divisi as $item)
                                <div class="form-check mb-1">
                                    <input class="form-check-input divisi-checkbox" type="checkbox"
                                        id="divisi{{ $loop->index }}" value="{{ $item->divisi }}" checked>
                                    <label class="form-check-label" for="divisi{{ $loop->index }}">
                                        {{ $item->divisi }}
                                    </label>
                                </div>
                            @endforeach

                            <!-- Tombol aksi -->
                            <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                                <button class="btn btn-sm btn-light px-3 py-1 rounded-pill" id="resetDivisi">
                                    <i class="feather-x me-1"></i> Reset
                                </button>
                                <button class="btn btn-sm btn-primary px-3 py-1 rounded-pill" id="applyDivisi">
                                    <i class="feather-check me-1"></i> Terapkan
                                </button>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Dropdown Rentang Tanggal -->
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

                    <!-- Button Perbarui Data -->
                    {{-- <button class="btn d-flex align-items-center rounded-pill"
                        style="background-color: #000B58; color: #fff;" id="refreshDataBtn">
                        <i class="feather-refresh-ccw me-2"></i>
                        <span>Perbarui Data</span>
                    </button> --}}

                </div>
            </div>
        </div>
    </div>
    <div class="dashboard-wrapper">

        <!-- Row Statistik -->
        <div class="row g-3">
            <!-- Card 1: Surat Masuk -->
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

            <!-- Card 2: Surat Keluar -->
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

            <!-- Card 3: Surat Laporan -->
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

        <!-- Row Grafik -->
        <div class="row g-2 mt-3">
            <!-- Line Chart -->
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

            <!-- Pie Chart -->
            {{-- <div class="col-xxl-4 col-xl-4 col-lg-12 col-md-12">
                <div class="card p-2" style="height: 280px;">
                    <div class="card-body d-flex flex-column h-100">
                        <h5 class="fs-14 fw-semibold mb-2">Orders Distribution</h5>
                        <div class="flex-grow-1 d-flex justify-content-center align-items-center">
                            <canvas id="pieChart" style="width:100%; height:100%; max-height: 180px;"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Row Aktivitas Terbaru -->
        <div class="row g-2 mt-3">
            <div class="col-12">
                <div class="card stretch stretch-full p-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fs-14 fw-semibold mb-0">Aktivitas Terbaru</h5>

                            <!-- Search Input -->
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
                                        {{-- <th>Status</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($aktivitas as $item)
                                        <tr data-date="{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('Y-m-d') }}"
                                            data-divisi="{{ $item->lokasi }}"> <!-- gunakan lokasi sebagai divisi -->
                                            <td>{{ $item->nomor_surat }}</td>
                                            <td>{{ $item->perihal }}</td>
                                            <td>{{ $item->lokasi }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                                            {{-- <td>
                                                @php
                                                    $badge = [
                                                        'Selesai' => 'badge-success',
                                                        'Pending' => 'badge-warning',
                                                        'Disposisi' => 'badge-info'
                                                    ][$item->status] ?? 'badge-secondary';
                                                @endphp
                                                <span class="badge-custom {{ $badge }}">{{ $item->status }}</span>
                                            </td> --}}
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

    <!-- Styling tambahan -->
    <style>
        .avatar-lg {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
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
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>

    <script>
        $(function () {
            const $dateInput = $('#dateRange');
            const $clearBtn = $('#clearDateRange');
            const $checkboxDivisi = $('.divisi-checkbox');
            const $pilihSemua = $('#pilihSemuaDivisi');
            const $applyBtn = $('#applyDivisi');
            const $tableBody = $('#aktivitasTable tbody');
            const $divisiButtonText = $('.dropdown button span'); // span di tombol dropdown divisi

            let selectedDivisi = [];
            let selectedTanggal = [];

            // ===== Daterangepicker =====
            $dateInput.daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD MMM YYYY',
                    applyLabel: 'Terapkan',
                    cancelLabel: 'Batal',
                    daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                },
                opens: 'left'
            });

            // ===== Update tombol Apply dan label divisi =====
            function updateDivisiLabel() {
                const checkedDivisi = $checkboxDivisi.toArray().filter(cb => cb.checked).length;
                $divisiButtonText.text(`${checkedDivisi} Divisi Terpilih`);
                $applyBtn.prop('disabled', checkedDivisi === 0);
            }

            // ===== Event checkbox divisi =====
            $checkboxDivisi.on('change', function () {
                const allChecked = $checkboxDivisi.toArray().every(cb => cb.checked);
                $pilihSemua.prop('checked', allChecked);
                updateDivisiLabel();
            });

            // ===== Event pilih semua =====
            $pilihSemua.on('change', function () {
                $checkboxDivisi.prop('checked', this.checked);
                updateDivisiLabel();
            });

            // ===== Event tombol Apply =====
            $applyBtn.on('click', function () {
                selectedDivisi = $checkboxDivisi.toArray()
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                // tutup dropdown secara manual
                $(this).closest('.dropdown-menu').removeClass('show');

                applyFilter();
            });

            // ===== Event pilih tanggal =====
            $dateInput.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
                $clearBtn.show();
                selectedTanggal = [picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD')];
                applyFilter();
            });

            $clearBtn.on('click', function () {
                $(this).hide();
                $dateInput.val('');
                selectedTanggal = [];
                applyFilter();
            });

            // ===== Fungsi AJAX Filter =====
            function applyFilter() {
                if (selectedDivisi.length === 0) {
                    // Kosongkan tabel & chart jika tidak ada divisi yang dicentang
                    $tableBody.html('<tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data</td></tr>');

                    // Kosongkan statistik
                    $('.card:contains("Total Surat Masuk") .display-5').text('0');
                    $('.card:contains("Total Surat Keluar") .display-5').text('0');
                    $('.card:contains("Menunggu Respon") .display-5').text('0');
                    $('.card:contains("Waktu Respon") .display-5').text('0');

                    // Destroy chart lama
                    if (window.lineChart) window.lineChart.destroy();
                    if (window.pieChart) window.pieChart.destroy();
                    return;
                }

                $.ajax({
                    url: "{{ route('dashboard.filter') }}",
                    type: 'GET',
                    data: { divisi: selectedDivisi, tanggal: selectedTanggal },
                    success: function (res) {
                        // Update Statistik
                        $('.card:contains("Total Surat Masuk") .display-5').text(res.totalMasuk);
                        $('.card:contains("Total Surat Keluar") .display-5').text(res.totalKeluar);
                        $('.card:contains("Menunggu Respon") .display-5').text(res.menungguRespon);
                        $('.card:contains("Waktu Respon") .display-5').text(res.waktuRespon);

                        // Update Tabel
                        $tableBody.empty();
                        if (res.aktivitas.length) {
                            res.aktivitas.forEach(a => {
                                const badgeClass = a.status === 'Selesai' ? 'badge-success' : a.status === 'Pending' ? 'badge-warning' : 'badge-info';
                                $tableBody.append(`
                                            <tr>
                                                <td>${a.nomor_surat}</td>
                                                <td>${a.perihal}</td>
                                                <td>${a.lokasi}</td>
                                                <td>${moment(a.tanggal_surat).format('DD MMM YYYY')}</td>
                                                <td><span class="badge-custom ${badgeClass}">${a.status}</span></td>
                                            </tr>
                                        `);
                            });
                        } else {
                            $tableBody.html('<tr><td colspan="5" class="text-center text-muted py-3">Tidak ada data</td></tr>');
                        }

                        // Update Chart
                        if (window.lineChart) window.lineChart.destroy();
                        if (window.pieChart) window.pieChart.destroy();

                        const ctxLine = document.getElementById('lineChart');
                        const ctxPie = document.getElementById('pieChart');

                        ctxLine.width = ctxLine.clientWidth;
                        ctxLine.height = ctxLine.clientHeight;
                        ctxPie.width = ctxPie.clientWidth;
                        ctxPie.height = ctxPie.clientHeight;

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

                        window.pieChart = new Chart(ctxPie, {
                            type: 'pie',
                            data: {
                                labels: res.pieLabels,
                                datasets: [{
                                    data: res.pieValues,
                                    backgroundColor: ['#000B58', '#8BBCE7', '#FFEB3B', '#4CAF50', '#F44336']
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 12 } } },
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

                        setTimeout(() => {
                            window.lineChart.resize();
                            window.pieChart.resize();
                        }, 100);
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            }

            // Inisialisasi label & tombol apply
            updateDivisiLabel();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctxLine = document.getElementById('lineChart');

            if (ctxLine) {
                // === LINE CHART (Tren Surat) ===
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
            }
        });
    </script>

@endpush