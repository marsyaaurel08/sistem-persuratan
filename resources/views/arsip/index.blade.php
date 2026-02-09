@extends('layout.app')

@section('title', 'Arsip')

@section('content')
    {{-- Vendor Scripts --}}
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>

    {{-- Page Header --}}
    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Arsip</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto">
            <div class="d-flex align-items-center gap-2">
                {{-- Search --}}
                <div class="input-group" style="min-width: 300px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                        <i class="feather-search"></i>
                    </span>
                    <input type="text" id="searchTable" class="form-control rounded-end-pill" placeholder="Cari surat..."
                        style="font-size: small">
                </div>

                {{-- Date Range --}}
                <div class="input-group" style="min-width: 300px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                        <i class="feather-calendar"></i>
                    </span>
                    <input type="text" id="dateRange" class="form-control rounded-end-pill"
                        placeholder="Pilih Rentang Tanggal" readonly style="cursor: pointer; font-size: small;">
                    <button class="btn btn-light border rounded" type="button" id="clearDateRange" title="Reset tanggal"
                        style="display: none;">
                        <i class="feather-x"></i>
                    </button>
                </div>

                {{-- Upload --}}
                <a href="{{ route('arsip.create') }}" class="btn btn-white border shadow-sm rounded-pill px-3">
                    <i class="feather-upload me-1"></i> Upload
                </a>
            </div>
        </div>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Division Folder Cards --}}
    {{-- <div class="row g-3 mb-4">
        @if($folders && count($folders) > 0)
        @foreach($folders as $folder)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stretch stretch-full h-100 mb-0 folder-card"
                data-divisi="{{ $folder['name'] }}" style="cursor: pointer; transition: transform 0.2s;"
                onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="p-2 rounded" style="background-color: {{ $folder['color'] }}20;">
                            <i class="feather-folder" style="color: {{ $folder['color'] }}; font-size: 28px;"></i>
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
            <div class="alert alert-info text-center">
                <i class="feather-info me-2"></i> Belum ada arsip
            </div>
        </div>
        @endif
    </div> --}}

    {{-- Table Arsip --}}
    <div class="row g-2 mt-4">
        <div class="col-12">
            <div class="card p-2">
                <div class="card-body">
                    <h5 class="fs-14 fw-semibold mb-3">
                        <i class="feather-file-text me-2 text-primary"></i> Arsip Terbaru
                    </h5>

                    {{-- Bulk Action --}}
                    <div id="bulkActionBar" class="alert alert-light border-primary d-flex align-items-center gap-3 mb-3"
                        style="display: none;">
                        <input type="checkbox" id="selectAll">
                        <strong><span id="selectedCount">0</span> Dokumen Dipilih</strong>
                        <div class="vr"></div>
                        <button class="btn btn-sm btn-light"><i class="feather-download"></i> Unduh</button>
                        <button class="btn btn-sm btn-light"><i class="feather-rotate-ccw"></i> Pulihkan</button>
                        <button class="btn btn-sm btn-danger"><i class="feather-trash"></i> Hapus</button>
                        <button class="btn-close ms-auto"></button>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle small" id="arsipTable">
                            <thead class="text-uppercase text-muted small">
                                <tr>
                                    <th width="40"></th>
                                    <th>Kode Arsip</th>
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    {{-- <th>Divisi</th> --}}
                                    <th>Tanggal</th>
                                    <th>Pengarsip</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arsip as $item)
                                    @php
                                        $tanggalDisplay = $item->tanggal_arsip?->format('d M Y');
                                        $pengarsip = $item->pengarsip->nama ?? '-';
                                    @endphp

                                    <tr data-kode="{{ $item->kode_arsip }}" data-no="{{ $item->nomor_surat }}"
                                        data-perihal="{{ $item->perihal }}" data-divisi="{{ $item->divisi }}"
                                        data-tanggal="{{ $tanggalDisplay }}" data-pengarsip="{{ $pengarsip }}" data-files='@json(
                                            $item->files->map(fn($f) => [
                                                "id" => $f->id,
                                                "nama_file" => $f->nama_file
                                            ])
                                        )'>
                                        <td>
                                            <input type="checkbox" class="row-checkbox" value="{{ $item->id }}">
                                        </td>

                                        <td class="text-nowrap">
                                            <span class="badge bg-light text-dark border">
                                                {{ $item->kode_arsip }}
                                            </span>
                                        </td>

                                        <td class="fw-bold">
                                            {{ $item->nomor_surat ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $item->perihal ?? '-' }}
                                        </td>

                                        {{-- <td>
                                            <span class="badge bg-secondary-subtle text-dark">
                                                {{ $item->divisi ?? '-' }}
                                            </span>
                                        </td> --}}

                                        <td>
                                            {{ $tanggalDisplay ?? '-' }}
                                        </td>

                                        <td>
                                            <small class="text-muted">
                                                {{ $item->pengarsip->name ?? '-' }}
                                            </small>
                                        </td>

                                        <td>
                                            @if ($item->files->count())
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach ($item->files as $file)
                                                        <a href="{{ route('arsip.download', $file->id) }}"
                                                            class="badge bg-light text-primary border d-inline-flex align-items-center">
                                                            <i class="feather-download me-1" style="font-size: 11px;"></i>
                                                            <span class="text-truncate" style="max-width: 140px;">
                                                                {{ $file->nama_file }}
                                                            </span>
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if (!request()->hasAny(['tanggal_arsip', 'search']))
                        <div class="mt-2 d-flex justify-content-center">
                            {{ $arsip->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Modal Detail Divisi --}}
<div class="modal fade" id="folderModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Dokumen Divisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm small">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Arsip</th>
                                <th>No. Surat</th>
                                <th>Perihal</th>
                                <th>Tanggal</th>
                                <th>File</th>
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

    {{-- Folder Card Click Handler --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const folderCards = document.querySelectorAll('.folder-card');
            const rows = document.querySelectorAll('#arsipTable tbody tr');

            folderCards.forEach(card => {
                card.addEventListener('click', function () {
                    const divisi = this.getAttribute('data-divisi');
                    showDivisiModal(divisi);
                });
            });

            function showDivisiModal(divisi) {
                const modalTableBody = document.getElementById('modalTableBody');
                const modalTitle = document.getElementById('modalTitle');
                const m = new bootstrap.Modal(document.getElementById('folderModal'));

                modalTitle.textContent = `Arsip Divisi: ${divisi}`;
                modalTableBody.innerHTML = '';

                rows.forEach(row => {
                    if (row.dataset.divisi !== divisi) return;

                    const kodeArsip = row.dataset.kode || '-';
                    const noSurat = row.dataset.no || '-';
                    const perihal = row.dataset.perihal || '-';
                    const tanggal = row.dataset.tanggal || '-';
                    const filesData = row.dataset.files ? JSON.parse(row.dataset.files) : [];

                    const tr = document.createElement('tr');
                    const tdKode = document.createElement('td');
                    tdKode.innerHTML = `<span class="badge bg-light text-dark">${kodeArsip}</span>`;
                    const tdNo = document.createElement('td'); tdNo.textContent = noSurat;
                    const tdPer = document.createElement('td'); tdPer.textContent = perihal;
                    const tdTgl = document.createElement('td'); tdTgl.textContent = tanggal;
                    const tdFiles = document.createElement('td');

                    if (filesData.length > 0) {
                        const btnGroup = document.createElement('div');
                        btnGroup.className = 'd-flex flex-wrap gap-1';
                        filesData.forEach(f => {
                            const a = document.createElement('a');
                            a.href = `/arsip/download/${f.id}`;
                            a.className = 'btn btn-sm btn-outline-primary';
                            a.innerHTML = `<i class="feather-download me-1"></i>${f.nama_file}`;
                            btnGroup.appendChild(a);
                        });
                        tdFiles.appendChild(btnGroup);
                    } else {
                        tdFiles.innerHTML = '<span class="text-muted">Tidak ada file</span>';
                    }

                    tr.appendChild(tdKode);
                    tr.appendChild(tdNo);
                    tr.appendChild(tdPer);
                    tr.appendChild(tdTgl);
                    tr.appendChild(tdFiles);
                    modalTableBody.appendChild(tr);
                });

                m.show();
            }
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
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchTable');
            const dateInput = document.getElementById('dateRange');
            const pagination = document.querySelector('.pagination')?.parentElement;

            function togglePagination() {
                const hasSearch = searchInput && searchInput.value.trim() !== '';
                const hasDateFilter = dateInput && dateInput.value.trim() !== '';

                if (pagination) {
                    pagination.style.display = (hasSearch || hasDateFilter) ? 'none' : 'block';
                }
            }

            if (searchInput) searchInput.addEventListener('keyup', togglePagination);
            if (dateInput) dateInput.addEventListener('change', togglePagination);
        });

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
                document.getElementById('dateRange').dispatchEvent(new Event('change'));
            });

            $dateInput.on('cancel.daterangepicker', function () {
                $(this).val('');
                $clearBtn.hide();
                filterByDateRange();
                document.getElementById('dateRange').dispatchEvent(new Event('change'));
            });

            $clearBtn.on('click', function () {
                $dateInput.val('');
                $(this).hide();
                filterByDateRange();
                document.getElementById('dateRange').dispatchEvent(new Event('change'));
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