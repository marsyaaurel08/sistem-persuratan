@extends('layout.app')

@section('title', 'Arsip')

@section('content')
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>

    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Arsip</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">
                    <div class="input-group" style="min-width: 300px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill" id="search-icon">
                            <i class="feather-search"></i>
                        </span>
                        <input type="text" id="searchTable" class="form-control rounded-end-pill"
                            placeholder="Cari surat..." style="font-size: small">
                    </div>

                    <div class="input-group" style="min-width: 300px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i
                                class="feather-calendar"></i></span>
                        <input type="text" id="dateRange" class="form-control rounded-end-pill"
                            placeholder="Pilih Rentang Tanggal" readonly style="cursor: pointer; font-size: small;">
                        <button class="btn btn-light border rounded" type="button" id="clearDateRange" title="Reset tanggal"
                            style="display: none;">
                            <i class="feather-x"></i>
                        </button>
                    </div>

                    <button class="btn btn-white border shadow-sm rounded-pill px-3">
                        <a href="{{ url('/upload_berkas') }}" class="text-decoration-none text-dark">
                            <i class="feather-upload me-1"></i> Upload
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @if($folders && count($folders) > 0)
            @foreach($folders as $folder)
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm stretch stretch-full h-100 mb-0 folder-card"
                        data-divisi="{{ $folder['name'] }}" style="cursor: pointer;">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="p-2 rounded" style="background-color: {{ $folder['color'] }}20;">
                                    <i class="feather-folder" style="color: {{ $folder['color'] }}; font-size: 20px;"></i>
                                </div>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">{{ $folder['name'] }}</h6>
                            <small class="text-muted">{{ $folder['count'] }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="feather-info me-2"></i> Tidak ada arsip untuk ditampilkan
                </div>
            </div>
        @endif
    </div>

    <div class="row g-2">
        <div class="col-12">
            <div class="card stretch stretch-full p-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fs-14 fw-semibold mb-0"><i class="feather-file-text me-2 text-primary"></i>Arsip Terbaru
                        </h5>
                    </div>

                    <div id="bulkActionBar" class="alert alert-light border-primary d-flex align-items-center gap-3 mb-3"
                        style="display:none;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>

                        <strong><span id="selectedCount">0</span> Dokumen Dipilih</strong>

                        <div class="vr"></div>

                        <button class="btn btn-sm btn-light">
                            <i class="feather-download me-1"></i> Unduh
                        </button>

                        <button class="btn btn-sm btn-light">
                            <i class="feather-rotate-ccw me-1"></i> Pulihkan
                        </button>

                        <button class="btn btn-sm btn-danger">
                            <i class="feather-trash me-1"></i> Hapus
                        </button>

                        <button class="btn-close ms-auto"></button>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle small" id="arsipTable">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th style="width:40px;"></th>
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Penerima</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($arsip as $item)
                                                        <tr
                                                            data-date="{{ $item->tanggal_arsip ? \Carbon\Carbon::parse($item->tanggal_arsip)->format('Y-m-d') : '' }}">
                                                            <td>
                                                                <input type="checkbox" class="row-checkbox" value="{{ $item->id }}">
                                                            </td>
                                                            <td class="fw-bold text-dark">
                                                                {{ $item->jenis_surat === 'Masuk'
                                    ? (optional($item->suratMasuk)->nomor_surat ?? '-')
                                    : (optional($item->suratKeluar)->nomor_surat ?? '-') }}
                                                            </td>
                                                            <td>
                                                                {{ $item->jenis_surat === 'Masuk'
                                    ? (optional($item->suratMasuk)->perihal ?? '-')
                                    : (optional($item->suratKeluar)->perihal ?? '-') }}
                                                            </td>
                                                            <td>
                                                                {{ $item->jenis_surat === 'Masuk'
                                    ? (optional($item->suratMasuk)->penerima_divisi ?? '-')
                                    : (optional($item->suratKeluar)->pengirim_divisi ?? '-') }}
                                                            </td>
                                                            <td>
                                                                {{ $item->tanggal_arsip ? \Carbon\Carbon::parse($item->tanggal_arsip)->format('d M Y') : '-' }}
                                                            </td>
                                                        </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-2 d-flex justify-content-center">
                        {{ $arsip->links() }}
                    </div>

                    @push('styles')
                        <style>
                            .pagination {
                                color: #000 !important;
                                /* teks hitam */
                            }

                            .pagination .page-item .page-link {
                                color: #000;
                                /* teks link hitam */
                                border: 1px solid #dee2e6;
                                /* optional: border standar */
                            }

                            .pagination .page-item.active .page-link {
                                background-color: #f8f9fa;
                                /* latar active page */
                                border-color: #dee2e6;
                                color: #000;
                            }
                        </style>
                    @endpush
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Detail Divisi -->
<div class="modal fade" id="folderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Dokumen Divisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm small">
                        <thead>
                            <tr>
                                <th>No. Surat</th>
                                <th>Perihal</th>
                                <th>Penerima</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody id="modalTableBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const folderCards = document.querySelectorAll('.folder-card');
            const modal = new bootstrap.Modal(document.getElementById('folderModal'));

            folderCards.forEach(card => {
                card.addEventListener('click', function () {
                    const divisi = this.getAttribute('data-divisi');
                    const rows = document.querySelectorAll('#arsipTable tbody tr');
                    const modalTableBody = document.getElementById('modalTableBody');
                    const modalTitle = document.getElementById('modalTitle');

                    modalTitle.textContent = `Dokumen - ${divisi}`;
                    modalTableBody.innerHTML = '';

                    rows.forEach(row => {
                        const penerima = row.querySelector('td:nth-child(4)').textContent.trim();
                        if (penerima === divisi) {
                            const clone = row.cloneNode(true);
                            clone.querySelector('td:first-child').remove(); // hapus checkbox
                            modalTableBody.appendChild(clone);
                        }
                    });

                    modal.show();
                });
            });
        });
    </script>

    <!-- Search Table -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchTable');
            if (!searchInput) return;
            searchInput.addEventListener('keyup', function () {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#arsipTable tbody tr');
                rows.forEach(row => {
                    row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
                });
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
    </script>

    <!-- Checkbox & Bulk Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bulkBar = document.getElementById('bulkActionBar');
            const selectedCount = document.getElementById('selectedCount');
            const selectAll = document.getElementById('selectAll');
            const table = document.getElementById('arsipTable');

            function updateCount() {
                const checked = document.querySelectorAll('.row-checkbox:checked').length;
                const total = document.querySelectorAll('.row-checkbox').length;
                selectedCount.textContent = checked;
                if (bulkBar) bulkBar.style.display = checked ? 'flex' : 'none';
                if (selectAll) {
                    selectAll.checked = total > 0 && checked === total;
                    selectAll.indeterminate = checked > 0 && checked < total;
                }
            }

            if (table) {
                table.addEventListener('change', function (e) {
                    if (e.target && e.target.classList && e.target.classList.contains('row-checkbox')) {
                        updateCount();
                    }
                });
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    const all = document.querySelectorAll('.row-checkbox');
                    all.forEach(cb => cb.checked = this.checked);
                    updateCount();
                });
            }

            updateCount();
        });
    </script>
@endpush