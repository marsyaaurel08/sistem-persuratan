@extends('layout.app')

@section('title', 'Arsip')

@section('content')
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
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                        <i class="feather-search"></i>
                    </span>
                    <input type="text" id="searchTable" class="form-control rounded-end-pill" placeholder="Cari surat..."
                        style="font-size: small">
                </div>

                {{-- Date Range --}}
                <div class="input-group rounded-pill border border-secondary-subtle align-items-center"
                    style="width: 300px; height: 44px; overflow: hidden; font-size: small;">
                    <span
                        class="input-group-text bg-white border-0 d-flex align-items-center justify-content-center px-2 h-100">
                        <i class="feather-calendar"></i>
                    </span>
                    <input type="text" id="dateRange" class="form-control border-0 px-2 h-100 d-flex align-items-center"
                        placeholder="Pilih Tanggal"
                        style="cursor: pointer; font-size: small; background-color: white; line-height: normal;">
                    <button class="btn btn-light border-0 d-flex align-items-center justify-content-center px-2 h-100"
                        type="button" id="clearDateRange" title="Reset tanggal" style="display: none;">
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
        @if ($folders && count($folders) > 0)
        @foreach ($folders as $folder)
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
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

                        <!-- JUDUL KIRI -->
                        <h5 class="fs-14 fw-semibold mb-0">
                            <i class="feather-file-text me-2 text-primary"></i> Data Arsip
                        </h5>

                        <!-- TAB KANAN -->
                        <div class="d-flex flex-wrap gap-2 align-items-center" id="arsipTab">
                            <span class="fw-semibold me-2">Jenis Arsip :</span>

                            <a href="{{ route('arsip.index') }}" class="badge rounded-pill px-3 py-2
                                               {{ $kategoriAktif == 'semua' ? 'bg-primary' : 'bg-light text-dark' }}">
                                Semua ({{ $countSemua }})
                            </a>

                            <a href="{{ route('arsip.index', ['kategori' => 'Masuk']) }}" class="badge rounded-pill px-3 py-2
                                               {{ $kategoriAktif == 'Masuk' ? 'bg-primary' : 'bg-light text-dark' }}">
                                Surat Masuk ({{ $countMasuk }})
                            </a>

                            <a href="{{ route('arsip.index', ['kategori' => 'Keluar']) }}" class="badge rounded-pill px-3 py-2
                                               {{ $kategoriAktif == 'Keluar' ? 'bg-primary' : 'bg-light text-dark' }}">
                                Surat Keluar ({{ $countKeluar }})
                            </a>

                            <a href="{{ route('arsip.index', ['kategori' => 'Laporan']) }}" class="badge rounded-pill px-3 py-2
                                               {{ $kategoriAktif == 'Laporan' ? 'bg-primary' : 'bg-light text-dark' }}">
                                Laporan ({{ $countLaporan }})
                            </a>
                        </div>




                    </div>

                    {{-- Bulk Action --}}
                    <div id="bulkActionBar"
                        class="alert alert-light border-primary d-flex align-items-center gap-3 mb-3 fade d-none">

                        {{-- <div id="bulkActionBar"
                            class="alert alert-light border-primary d-flex align-items-center gap-3 mb-3"
                            style="display: none;"> --}}
                            <input type="checkbox" id="selectAll">
                            <strong><span id="selectedCount">0</span> Dokumen Dipilih</strong>
                            <div class="vr"></div>
                            <button id="downloadSelected" class="btn btn-sm btn-light" disabled>
                                <i class="feather-download"></i>
                                <span class="btn-text">Unduh</span>
                                <span class="spinner-border spinner-border-sm d-none ms-2" role="status"></span>
                            </button>
                            {{-- <button id="downloadSelected" class="btn btn-sm btn-light"><i class="feather-download"></i>
                                Unduh</button> --}}
                            <button class="btn btn-sm btn-light"><i class="feather-rotate-ccw"></i> Pulihkan</button>
                            <button class="btn btn-sm btn-danger"><i class="feather-trash"></i> Hapus</button>
                            <button type="button" id="closeBulkBar" class="btn-close ms-auto"></button>
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
                                    @foreach ($arsips as $item)
                                        @php
                                            $tanggalDisplay = $item->tanggal_arsip?->format('d M Y');
                                            $pengarsip = $item->pengarsip->name ?? '-';
                                        @endphp

                                        <tr data-kode="{{ $item->kode_arsip }}" data-no="{{ $item->nomor_surat }}"
                                            data-perihal="{{ $item->perihal }}" data-divisi="{{ $item->divisi }}"
                                            data-tanggal="{{ $tanggalDisplay }}"
                                            data-date="{{ $item->tanggal_arsip?->format('Y-m-d') }}"
                                            data-pengarsip="{{ $pengarsip }}" data-files='@json(
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
                                                        <!-- Tombol Download -->
                                                        @foreach ($item->files as $file)
                                                            <a href="{{ route('arsip.download', $file->id) }}"
                                                                class="badge bg-light text-primary border d-inline-flex align-items-center p-2"
                                                                title="Download">
                                                                <i class="feather-download me-1" style="font-size: 14px;"></i>
                                                                <span style="font-size: 12px;">Unduh</span>
                                                            </a>

                                                            <!-- Tombol Preview -->
                                                            <button type="button"
                                                                class="badge bg-light text-success border d-inline-flex align-items-center p-2 preview-btn"
                                                                data-bs-toggle="modal" data-bs-target="#previewModal"
                                                                data-file="{{ asset('storage/' . $file->path_file) }}" title="Preview">
                                                                <i class="feather-eye me-1" style="font-size: 14px;"></i>
                                                                <span style="font-size: 12px;">Preview</span>
                                                            </button>
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
                                {{ $arsips->links() }}
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

    <!-- Modal Preview -->
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



    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>


        <!-- Search Table -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchTable');
                if (!searchInput) return;
                searchInput.addEventListener('keyup', function () {
                    const filter = this.value.toLowerCase();
                    const rows = document.querySelectorAll('#arsipTable tbody tr');
                    rows.forEach(row => {
                        row.style.display = row.textContent.toLowerCase().includes(filter) ? '' :
                            'none';
                    });
                });
            });
        </script>

        @push('styles')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        @endpush
        <!-- Date Range Picker & Filter -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dateInput = document.getElementById('dateRange');
                const clearBtn = document.getElementById('clearDateRange');
                const rows = document.querySelectorAll('#arsipTable tbody tr');
                const pagination = document.querySelector('.pagination')?.parentElement;

                if (!dateInput) return;

                const fp = flatpickr(dateInput, {
                    mode: 'range',
                    dateFormat: 'd M Y',
                    locale: 'id',
                    allowInput: false,
                    onChange: function (selectedDates) {
                        if (selectedDates.length === 2) {
                            filterByDate(selectedDates[0], selectedDates[1]);
                            clearBtn.style.display = 'inline-flex';
                            hidePagination();
                        }
                    }
                });

                function filterByDate(start, end) {
                    rows.forEach(row => {
                        const dateStr = row.dataset.date;
                        if (!dateStr) {
                            row.style.display = 'none';
                            return;
                        }

                        const rowDate = new Date(dateStr);
                        row.style.display =
                            rowDate >= start && rowDate <= end ? '' : 'none';
                    });
                }

                function hidePagination() {
                    if (pagination) pagination.style.display = 'none';
                }

                function showPagination() {
                    if (pagination) pagination.style.display = 'block';
                }

                clearBtn.addEventListener('click', function () {
                    fp.clear();
                    dateInput.value = '';
                    clearBtn.style.display = 'none';
                    rows.forEach(row => row.style.display = '');
                    showPagination();
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
                const closeBulkBtn = document.getElementById('closeBulkBar');

                function getRowCheckboxes() {
                    return document.querySelectorAll('.row-checkbox');
                }

                function showBulkBar() {
                    bulkBar.classList.remove('d-none');
                    bulkBar.classList.add('show');
                }

                function hideBulkBar() {
                    bulkBar.classList.add('d-none');
                    bulkBar.classList.remove('show');
                }

                function updateCount() {
                    const checked = document.querySelectorAll('.row-checkbox:checked').length;
                    const total = getRowCheckboxes().length;

                    selectedCount.textContent = checked;

                    if (checked > 0) {
                        showBulkBar();
                    } else {
                        hideBulkBar();
                    }

                    if (selectAll) {
                        selectAll.checked = checked === total && total > 0;
                        selectAll.indeterminate = checked > 0 && checked < total;
                    }
                }

                // checkbox row
                table.addEventListener('change', function (e) {
                    if (e.target.classList.contains('row-checkbox')) {
                        updateCount();
                    }
                });

                // select all
                selectAll.addEventListener('change', function () {
                    getRowCheckboxes().forEach(cb => cb.checked = this.checked);
                    updateCount();
                });

                // ❌ tombol silang
                closeBulkBtn.addEventListener('click', function () {
                    getRowCheckboxes().forEach(cb => cb.checked = false);

                    selectAll.checked = false;
                    selectAll.indeterminate = false;

                    selectedCount.textContent = 0;
                    hideBulkBar();
                });

                hideBulkBar(); // initial
            });
        </script>



        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const downloadBtn = document.getElementById('downloadSelected');
                if (!downloadBtn) return;

                const btnText = downloadBtn.querySelector('.btn-text');
                const spinner = downloadBtn.querySelector('.spinner-border');

                const checkboxes = document.querySelectorAll('.row-checkbox');

                // 🔄 fungsi enable / disable tombol
                function updateDownloadButton() {
                    const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
                    downloadBtn.disabled = checkedCount === 0;
                }

                // pantau checkbox
                checkboxes.forEach(cb => {
                    cb.addEventListener('change', updateDownloadButton);
                });

                // set kondisi awal
                updateDownloadButton();

                downloadBtn.addEventListener('click', function () {
                    const ids = Array.from(
                        document.querySelectorAll('.row-checkbox:checked')
                    ).map(cb => cb.value);

                    if (ids.length === 0) return; // safety

                    // 🔒 AKTIFKAN LOADING
                    downloadBtn.disabled = true;
                    btnText.textContent = 'Menyiapkan file...';
                    spinner.classList.remove('d-none');

                    fetch("{{ route('arsip.bulkDownload') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            ids
                        })
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Gagal mengunduh');

                            const disposition = response.headers.get('Content-Disposition');
                            let filename = 'download';

                            if (disposition && disposition.includes('filename=')) {
                                filename = disposition.split('filename=')[1].replace(/"/g, '');
                            }

                            return response.blob().then(blob => ({
                                blob,
                                filename
                            }));
                        })
                        .then(({
                            blob,
                            filename
                        }) => {
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = filename;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                        })
                        .catch(err => {
                            alert(err.message);
                        })
                        .finally(() => {
                            // 🔓 KEMBALIKAN KE NORMAL
                            btnText.textContent = 'Unduh';
                            spinner.classList.add('d-none');
                            updateDownloadButton(); // cek ulang checkbox
                        });
                });
            });
        </script>

        <iframe src="" frameborder="0" width="100%" height="600px" id="previewFrame"></iframe>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const previewButtons = document.querySelectorAll('.preview-btn');
                const iframe = document.getElementById('previewFrame');

                previewButtons.forEach(btn => {
                    btn.addEventListener('click', function () {
                        const fileUrl = this.dataset.file;
                        console.log('Preview file URL:', fileUrl); // cek di console
                        iframe.src = fileUrl;
                    });
                });

                // Clear iframe saat modal ditutup
                const modal = document.getElementById('previewModal');
                modal.addEventListener('hidden.bs.modal', function () {
                    iframe.src = '';
                });
            });
        </script>
    @endpush