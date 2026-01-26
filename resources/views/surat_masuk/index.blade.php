@extends('layout.app')

@section('content')
    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Surat Masuk</h5>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- SUMMARY CARD -->
        <div class="row mb-4 mt-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center gap-4">
                        <!-- ICON BOX -->
                        <div
                            class="d-flex align-items-center justify-content-center
               bg-primary-subtle text-primary
               rounded-3 p-3 fs-2">
                            <i class="bi bi-envelope-fill fs-2"></i>
                        </div>
                        <!-- TEXT -->
                        <div>
                            <div class="text-muted fs-6">Total Surat Masuk</div>
                            <div class="fw-bold fs-2">{{ $totalSurat }}</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center gap-4">
                        <!-- ICON BOX -->
                        <div
                            class="d-flex align-items-center justify-content-center
                            bg-warning-subtle text-warning
                            rounded-3 p-3 fs-2">
                            <i class="bi bi-clipboard-fill fs-2"></i>
                        </div>
                        <!-- TEXT -->
                        <div>
                            <div class="text-muted fs-6">Belum Disposisi</div>
                            <div class="fw-bold fs-2">{{ $belumDisposisi }}</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex align-items-center gap-4">
                        <!-- ICON BOX -->
                        <div
                            class="d-flex align-items-center justify-content-center
                            bg-success-subtle text-success
                            rounded-3 p-3 fs-2">
                            <i class="bi bi-check-circle-fill fs-2"></i>
                        </div>
                        <!-- TEXT -->
                        <div>
                            <div class="text-muted fs-6">Selesai Bulan Ini</div>
                            <div class="fw-bold fs-2">{{ $selesaiBulanIni }}</div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- HEADER: SEARCH & ACTION -->
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">

                        <!-- SEARCH -->
                        <div style="max-width: 500px; width: 100%;">
                            <div class="input-group rounded-pill overflow-hidden border border-secondary-subtle">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="search" class="form-control border-0"
                                    placeholder="Cari nomor surat / pengirim / perihal ... ">
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="d-flex gap-2">
                            <!-- RENTANG TANGGAL -->
                            {{-- <button class="btn bg-secondary-subtle text-dark rounded px-3">
                                <i class="bi bi-calendar-event-fill me-1 text-dark"></i>
                                Rentang Tanggal
                            </button> --}}
                            <!-- RENTANG TANGGAL -->
                            <button id="openDateRange"
                                class="btn bg-secondary-subtle text-dark rounded px-3 d-flex align-items-center gap-2">

                                <i class="bi bi-calendar-event-fill"></i>

                                <span id="dateRangeLabel">Rentang Tanggal</span>

                                <!-- RESET (X) -->
                                <i id="clearDateRange" class="bi bi-x-circle-fill text-danger d-none"
                                    style="cursor: pointer;"></i>
                            </button>

                            <input type="text" id="dateRange" class="d-none">

                            {{-- <button type="button" id="openDateRange"
                                class="btn bg-secondary-subtle text-dark rounded px-3">
                                <i class="bi bi-calendar-event-fill me-1 text-dark"></i>
                                Rentang Tanggal
                            </button>

                            <!-- INPUT DATE RANGE (HIDDEN) -->
                            <input type="text" id="dateRange" class="form-control d-none">

                            <button id="clearDateRange" class="btn btn-light d-none">
                                Reset
                            </button> --}}

                            <!-- TAMBAH SURAT -->
                            <button class="btn bg-secondary-subtle text-dark rounded px-3"
                                onclick="window.location='{{ url('/upload_surat') }}'">
                                <i class="bi bi-plus-circle-fill me-1 text-dark"></i>
                                Tambah Surat
                            </button>
                        </div>
                    </div>

                    <!-- FILTER STATUS -->
                    <div class="d-flex flex-wrap gap-2 mb-3" id="statusFilter">
                        <span class="fw-semibold me-2">Status :</span>

                        <span class="badge rounded-pill bg-primary px-3 py-2 status-btn" data-status="">
                            Semua
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="pending">
                            Baru
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="disposisi">
                            Disposisi
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="selesai">
                            Selesai
                        </span>
                    </div>
                    {{-- <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="input-group-text bg-transparent border-0 fw-semibold">
                            Status :
                        </span>
                        <span class="badge rounded-pill bg-primary px-3 py-2">
                            Semua
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Baru (10)
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Dalam Proses (5)
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Disposisi (7)
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Selesai
                        </span>
                    </div> --}}

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="text-muted fs-6 fw-medium">
                                    <th>No. Surat</th>
                                    <th>Pengirim</th>
                                    <th>Perihal</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="fs-6" id="surat-table">
                                @forelse ($suratMasuk as $item)
                                    <tr data-date="{{ $item->tanggal_surat }}">
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->pengirim->name ?? '-' }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                                        @php
                                            $statusLabel = [
                                                'Pending' => 'Baru',
                                                'Disposisi' => 'Disposisi',
                                                'Selesai' => 'Selesai',
                                            ];

                                            $statusClass = [
                                                'Pending' => 'bg-warning-subtle text-warning',
                                                'Disposisi' => 'bg-info-subtle text-info',
                                                'Selesai' => 'bg-success-subtle text-success',
                                            ];
                                        @endphp

                                        <td>
                                            <span
                                                class="badge {{ $statusClass[strtolower($item->status)] ?? 'bg-secondary' }}">
                                                {{ $statusLabel[strtolower($item->status)] ?? $item->status }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            @if ($item->status == 'Pending')
                                                <span class="badge bg-warning-subtle text-warning">PENDING</span>
                                            @elseif ($item->status == 'Disposisi')
                                                <span class="badge bg-info-subtle text-info">DISPOSISI</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success">SELESAI</span>
                                            @endif
                                        </td> --}}
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Tidak ada surat masuk
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('search');
            const tableBody = document.getElementById('surat-table');
            let timeout = null;

            /* ===============================
               FILTER BY DATE (GLOBAL)
            =============================== */
            function filterByDateRange() {
                if (typeof $ === 'undefined') return;

                const dateInput = $('#dateRange');
                const picker = dateInput.data('daterangepicker');

                if (!picker || !dateInput.val()) {
                    $('#surat-table tr').show();
                    return;
                }

                const start = picker.startDate;
                const end = picker.endDate;

                $('#surat-table tr').each(function() {
                    const rowDateStr = $(this).data('date');
                    if (!rowDateStr) return;

                    const rowDate = moment(rowDateStr, 'YYYY-MM-DD');
                    const show =
                        rowDate.isSameOrAfter(start, 'day') &&
                        rowDate.isSameOrBefore(end, 'day');

                    $(this).toggle(show);
                });
            }

            /* ===============================
               LIVE SEARCH (AJAX)
            =============================== */
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);

                    timeout = setTimeout(() => {
                        fetch(`{{ route('surat_masuk.search') }}?search=${this.value}`)
                            .then(res => res.text())
                            .then(html => {
                                tableBody.innerHTML = html;

                                // 🔥 PENTING: filter ulang setelah AJAX
                                filterByDateRange();
                            });
                    }, 300);
                });
            }

            /* ===============================
               DATE RANGE PICKER
            =============================== */
            if (typeof $ !== 'undefined' && $.fn.daterangepicker) {

                const openBtn = document.getElementById('openDateRange');
                const label = document.getElementById('dateRangeLabel');
                const clearBtn = document.getElementById('clearDateRange');
                const dateInput = $('#dateRange');

                dateInput.daterangepicker({
                    autoUpdateInput: false,
                    opens: 'left',
                    drops: 'down',
                    parentEl: 'body',
                    locale: {
                        format: 'DD MMM YYYY',
                        applyLabel: 'Terapkan',
                        cancelLabel: 'Batal',
                        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                        monthNames: [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ]
                    }
                });

                // buka kalender
                openBtn?.addEventListener('click', function(e) {
                    if (e.target === clearBtn) return;
                    dateInput.trigger('click');
                });

                // apply
                dateInput.on('apply.daterangepicker', function(ev, picker) {
                    label.textContent =
                        picker.startDate.format('DD MMM YYYY') +
                        ' - ' +
                        picker.endDate.format('DD MMM YYYY');

                    clearBtn.classList.remove('d-none');
                    filterByDateRange();
                });

                // reset (X)
                clearBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dateInput.val('');
                    label.textContent = 'Rentang Tanggal';
                    clearBtn.classList.add('d-none');
                    filterByDateRange();
                });
            }
        });
    </script>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const tableBody = document.getElementById('surat-table');

            let timeout = null;

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    const query = this.value;

                    fetch(`{{ route('surat_masuk.search') }}?search=${query}`)
                        .then(response => response.text())
                        .then(html => {
                            tableBody.innerHTML = html;
                        });
                }, 300); // debounce 300ms
            });
        });
    </script>

    <!-- Date Range Picker with Filtering -->
    <script>
        $(function () {
            if (!$.fn.daterangepicker) {
                console.error('daterangepicker plugin not loaded');
                return;
            }

            const $dateInput = $('#dateRange');
            const $clearBtn = $('#clearDateRange');
            const $tableRows = $('#arsipTable tbody tr');

            $dateInput.daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'DD MMM YYYY',
                    applyLabel: 'Terapkan',
                    cancelLabel: 'Batal',
                    daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                },
                opens: 'left'
            });

            // Fungsi untuk filter berdasarkan tanggal
            function filterByDateRange() {
                const dateStr = $dateInput.val();
                if (!dateStr) {
                    $tableRows.show();
                    return;
                }

                const picker = $dateInput.data('daterangepicker');
                const startDate = picker.startDate;
                const endDate = picker.endDate;

                $tableRows.each(function () {
                    const rowDateStr = $(this).attr('data-date');
                    if (!rowDateStr) {
                        $(this).hide();
                        return;
                    }

                    const rowDate = moment(rowDateStr, 'YYYY-MM-DD');
                    const isInRange = rowDate.isSameOrAfter(startDate, 'day') &&
                        rowDate.isSameOrBefore(endDate, 'day');
                    $(this).toggle(isInRange);
                });
            }

            $dateInput.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY'));
                $clearBtn.show();
                filterByDateRange();
            });

            $dateInput.on('cancel.daterangepicker', function () {
                $(this).val('');
                $clearBtn.hide();
                filterByDateRange();
            });

            $clearBtn.on('click', function () {
                $dateInput.val('');
                $(this).hide();
                filterByDateRange();
            });
        });
    </script> --}}
