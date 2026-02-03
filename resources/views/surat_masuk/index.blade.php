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
                            <button id="openDateRange"
                                class="btn bg-secondary-subtle text-dark rounded px-3 d-flex align-items-center gap-2">

                                <i class="bi bi-calendar-event-fill"></i>

                                <span id="dateRangeLabel">Rentang Tanggal</span>

                                <!-- RESET (X) -->
                                <i id="clearDateRange" class="bi bi-x-circle-fill text-danger d-none"
                                    style="cursor: pointer;"></i>
                            </button>

                            <input type="text" id="dateRange" class="d-none">

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
                            Semua ({{ $totalSurat }})
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="Pending">
                            Baru ({{ $statusCounts['Pending'] ?? 0 }})
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="Disposisi">
                            Disposisi ({{ $statusCounts['Disposisi'] ?? 0 }})
                        </span>

                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 status-btn" data-status="Selesai">
                            Selesai ({{ $statusCounts['Selesai'] ?? 0 }})
                        </span>
                    </div>

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
                                    {{-- <tr data-date="{{ $item->tanggal_surat }}"> --}}
                                    <tr data-date="{{ $item->tanggal_surat }}"
                                        data-status="{{ strtolower($item->status) }}">
                                        <td>{{ $item->nomor_surat }}</td>
                                        <td>{{ $item->pengirim->name ?? '-' }}</td>
                                        <td>{{ $item->perihal }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}</td>
                                        @php
                                            $status = strtolower(trim($item->status));

                                            $statusLabel = [
                                                'pending' => 'PENDING',
                                                'disposisi' => 'DISPOSISI',
                                                'selesai' => 'SELESAI',
                                            ];

                                            $statusClass = [
                                                'pending' => 'bg-warning-subtle text-warning',
                                                'disposisi' => 'bg-info-subtle text-info',
                                                'selesai' => 'bg-success-subtle text-success',
                                            ];
                                        @endphp

                                        <td>
                                            <span class="badge {{ $statusClass[$status] ?? 'bg-secondary text-white' }}">
                                                {{ $statusLabel[$status] ?? strtoupper($item->status) }}
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

            const tableBody = document.getElementById('surat-table');
            const searchInput = document.getElementById('search');
            const statusButtons = document.querySelectorAll('.status-btn');

            let timeout = null;
            let currentStatus = '';

            /* ===============================
               FETCH TABLE (AJAX GLOBAL)
            =============================== */
            function fetchTable() {
                const search = searchInput?.value ?? '';

                fetch(
                        `{{ route('surat_masuk.search') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(currentStatus)}`
                        )
                    .then(res => res.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                        filterByDateRange(); // tetap jalan
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
                if (!picker || !$('#dateRange').val()) {
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
               DATE PICKER INIT
            =============================== */
            if (typeof $ !== 'undefined' && $.fn.daterangepicker) {

                const dateInput = $('#dateRange');
                const label = document.getElementById('dateRangeLabel');
                const clearBtn = document.getElementById('clearDateRange');
                const openBtn = document.getElementById('openDateRange');

                dateInput.daterangepicker({
                    autoUpdateInput: false,
                    opens: 'left',
                    locale: {
                        format: 'DD MMM YYYY',
                        applyLabel: 'Terapkan',
                        cancelLabel: 'Batal'
                    }
                });

                openBtn?.addEventListener('click', e => {
                    if (e.target !== clearBtn) dateInput.trigger('click');
                });

                dateInput.on('apply.daterangepicker', function(ev, picker) {
                    label.textContent =
                        picker.startDate.format('DD MMM YYYY') +
                        ' - ' +
                        picker.endDate.format('DD MMM YYYY');

                    clearBtn.classList.remove('d-none');
                    filterByDateRange();
                });

                clearBtn?.addEventListener('click', e => {
                    e.stopPropagation();
                    dateInput.val('');
                    label.textContent = 'Rentang Tanggal';
                    clearBtn.classList.add('d-none');
                    filterByDateRange();
                });
            }

        });
    </script>
