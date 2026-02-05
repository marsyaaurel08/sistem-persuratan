@extends('layout.app')
@section('title', 'Surat Keluar')
@section('content')
    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Surat Keluar</h5>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mb-2 mt-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3 py-2">

                    <!-- TEXT -->
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-envelope-fill fs-4 text-secondary"></i>
                        <div class="text-muted fs-5 fw-medium">
                            Total Surat Terkirim
                        </div>
                        <div class="fw-bold fs-5">
                            {{ $totalSurat }}
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
                                    placeholder="Cari nomor surat / perihal / penerima ...">
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="d-flex gap-2">
                            <!-- RENTANG TANGGAL -->
                            <button id="openDateRange"
                                class="btn bg-secondary-subtle text-dark rounded px-3 d-flex align-items-center gap-2">

                                <i class="bi bi-calendar-event-fill"></i>
                                <span id="dateRangeLabel">Rentang Tanggal</span>

                                <i id="clearDateIcon" class="bi bi-x-circle-fill text-danger d-none"
                                    style="cursor: pointer;"></i>
                            </button>

                            <input type="text" id="dateRange" class="position-absolute opacity-0"
                                style="pointer-events: none;">

                            <!-- TAMBAH SURAT -->
                            <button class="btn bg-secondary-subtle text-dark rounded px-3">
                                <i class="bi bi-plus-circle-fill me-1 text-dark"></i>
                                Tambah Surat
                            </button>
                        </div>
                    </div>

                    <!-- FILTER STATUS -->
                    <div class="d-flex flex-wrap gap-2 mb-3" id="statusFilter">
                        <span class="fw-semibold me-2">Status :</span>

                        <span class="badge rounded-pill bg-primary px-3 py-2 status-btn" data-status="">
                            Semua ({{ $totalSurat }})
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="Pending">
                            Baru ({{ $statusCounts['pending'] ?? 0 }})
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="Disposisi">
                            Disposisi ({{ $statusCounts['disposisi'] ?? 0 }})
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="Selesai">
                            Selesai ({{ $statusCounts['selesai'] ?? 0 }})
                        </span>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="text-muted fs-6 fw-medium">
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Penerima</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody class="fs-6" id="surat-table">
                                @forelse ($suratKeluar as $item)
                                    <tr data-date="{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('Y-m-d') }}"
                                        data-status="{{ strtolower($item->status) }}">
                                        <td>{{ $item->nomor_surat }}</td>

                                        <td>{{ $item->perihal }}</td>

                                        <td>{{ $item->penerima?->name ?? '-' }}</td>

                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>

                                        @php
                                            $status = strtolower(trim($item->status));

                                            $statusMap = [
                                                'pending' => [
                                                    'label' => 'Pending',
                                                    'class' => 'bg-warning-subtle text-warning',
                                                ],
                                                'disposisi' => [
                                                    'label' => 'Disposisi',
                                                    'class' => 'bg-info-subtle text-info',
                                                ],
                                                'selesai' => [
                                                    'label' => 'Selesai',
                                                    'class' => 'bg-success-subtle text-success',
                                                ],
                                            ];

                                            $badgeClass =
                                                $statusMap[$status]['class'] ?? 'bg-secondary-subtle text-secondary';
                                            $badgeLabel = $statusMap[$status]['label'] ?? ucfirst($item->status);
                                        @endphp

                                        <td>
                                            <span class="badge-custom {{ $badgeClass }}">
                                                {{ $badgeLabel }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Belum ada surat keluar
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

    @push('styles')
        <style>
            .badge-custom {
                display: inline-block;
                padding: 0.35em 0.65em;
                font-size: 0.85em;
                font-weight: 500;
                border-radius: 0.75rem;
                /* bulat lembut */
                text-align: center;
                vertical-align: middle;
            }

            /* Bisa pakai kelas bg-*-subtle Bootstrap, tapi biar konsisten bisa ditambahin style */
            .bg-warning-subtle {
                background-color: #fff3cd !important;
                color: #f7bb16e7 !important;
            }

            .bg-info-subtle {
                background-color: #b2f1ffde !important;
                color: #2896ac !important;
            }

            .bg-success-subtle {
                background-color: #d1f7b7c0 !important;
                color: #30b616 !important;
            }

            .bg-secondary-subtle {
                background-color: #e2e3e5 !important;
                color: #41464b !important;
            }
        </style>
    @endpush

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const tableBody = document.getElementById('surat-table');
            const searchInput = document.getElementById('search');
            const statusButtons = document.querySelectorAll('.status-btn');

            let timeout = null;
            let currentStatus = '';
            let isDateActive = false;

            /* ===============================
               FETCH TABLE (AJAX GLOBAL)
            =============================== */
            function fetchTable() {
                const search = searchInput?.value ?? '';

                fetch(
                        `{{ route('surat_keluar.search') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(currentStatus)}`
                    )
                    .then(res => res.text())
                    .then(html => {
                        tableBody.innerHTML = html;

                        if (isDateActive) {
                            filterByDateRange();
                        }
                    });
            }

            /* ===============================
               FILTER STATUS (BADGE)
            =============================== */
            statusButtons.forEach(btn => {
                btn.addEventListener('click', function() {

                    statusButtons.forEach(b => {
                        b.classList.remove('bg-primary', 'text-white');
                        b.classList.add('bg-light', 'text-dark');
                    });

                    this.classList.remove('bg-light', 'text-dark');
                    this.classList.add('bg-primary', 'text-white');

                    currentStatus = this.dataset.status;
                    fetchTable();
                });
            });

            /* ===============================
               LIVE SEARCH (DEBOUNCE)
            =============================== */
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(fetchTable, 300);
                });
            }

            /* ===============================
               FILTER DATE (CLIENT SIDE)
            =============================== */
            function filterByDateRange() {
                if (typeof $ === 'undefined') return;

                const picker = $('#dateRange').data('daterangepicker');
                const hasValue = $('#dateRange').val();

                if (!picker || !hasValue) return;

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
               DATE PICKER INIT
            =============================== */
            if (typeof $ === 'undefined' || !$.fn.daterangepicker) return;

            const dateInput = $('#dateRange');
            const label = document.getElementById('dateRangeLabel');
            const openBtn = document.getElementById('openDateRange');
            const clearIcon = document.getElementById('clearDateIcon');

            dateInput.daterangepicker({
                autoUpdateInput: true,
                opens: 'left',
                locale: {
                    format: 'DD MMM YYYY',
                    applyLabel: 'Terapkan',
                    cancelLabel: 'Batal'
                }
            });

            /* BUKA KALENDER */
            openBtn.addEventListener('click', () => {
                dateInput.trigger('click');
            });

            /* APPLY RANGE */
            dateInput.on('apply.daterangepicker', function(ev, picker) {
                isDateActive = true;

                label.textContent =
                    picker.startDate.format('DD MMM YYYY') +
                    ' - ' +
                    picker.endDate.format('DD MMM YYYY');

                clearIcon.classList.remove('d-none');
                filterByDateRange();
            });

            /* CLEAR RANGE */
            clearIcon.addEventListener('click', function(e) {
                e.stopPropagation();

                isDateActive = false;
                dateInput.val('');
                label.textContent = 'Rentang Tanggal';
                clearIcon.classList.add('d-none');

                fetchTable();
            });

        });
    </script>
