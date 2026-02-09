@extends('layout.app')

@section('title', 'Laporan')

@section('content')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <div class="page-header d-flex align-items-center justify-content-between mb-4">
        <div class="page-header-left">
            <div class="page-header-title">
                <h5 class="m-b-10">Laporan</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">

                    <div class="input-group" style="max-width: 250px; height: 38px;">
                        <span
                            class="input-group-text bg-white border-end-0 rounded-start-pill d-flex align-items-center justify-content-center">
                            <i class="feather-search"></i>
                        </span>
                        <input type="text" id="searchLaporan" class="form-control border-start-0 rounded-end-pill"
                            placeholder="Cari laporan..." style="height: 100%;">
                    </div>

                    <div class="input-group rounded-pill border border-secondary-subtle align-items-center"
                        style="width: 220px; height: 38px; overflow: hidden; font-size: small;">
                        <span
                            class="input-group-text bg-white border-0 d-flex align-items-center justify-content-center px-2 h-100">
                            <i class="feather-calendar"></i>
                        </span>
                        <input type="text" id="dateRange" class="form-control border-0 px-2 h-100 d-flex align-items-center"
                            placeholder="Pilih Tanggal" readonly
                            style="cursor: pointer; font-size: small; background-color: white; line-height: normal;">
                        <button class="btn btn-light border-0 d-flex align-items-center justify-content-center px-2 h-100"
                            type="button" id="clearDateRange" title="Reset tanggal" style="display: none;">
                            <i class="feather-x"></i>
                        </button>
                    </div>

                    <form id="pdfForm" action="{{ route('laporan.exportPdf') }}" method="GET" target="_blank">
                        <input type="hidden" name="start" id="pdfStart">
                        <input type="hidden" name="end" id="pdfEnd">
                        <button type="submit"
                            class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center gap-1 px-2 rounded-pill"
                            style="width: 70px; height: 35px;">
                            <i class="feather-file-text"></i>
                            <span>PDF</span>
                        </button>
                    </form>

                    <form id="excelForm" action="{{ route('laporan.previewExcel') }}" method="GET" target="_blank">
                        <input type="hidden" name="start" id="excelStart">
                        <input type="hidden" name="end" id="excelEnd">
                        <button type="submit"
                            class="btn btn-sm btn-outline-success d-flex align-items-center justify-content-center gap-1 px-2 rounded-pill"
                            style="width: 70px; height: 35px;">
                            <i class="feather-file"></i>
                            <span>Excel</span>
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>





    <!-- Card Tabel Laporan -->
    <div class="row g-2 mt-3">
        <div class="col-12">
            <div class="card stretch stretch-full p-2">
                <div class="card-body">
                    <h5 class="fs-14 fw-semibold mb-3">Data Laporan</h5>




                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle" id="laporanTable">
                            <thead>
                                <tr>
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Divisi</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporans as $laporan)
                                    <tr
                                        data-date="{{ $laporan->tanggal ? \Carbon\Carbon::parse($laporan->tanggal)->format('Y-m-d') : '' }}">
                                        <td>{{ $laporan->no_surat }}</td>
                                        <td>{{ $laporan->perihal }}</td>
                                        <td>{{ $laporan->divisi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                        <td>
                                            <span
                                                class="badge-custom 
                                                                                                                                                                    @if($laporan->status == 'Selesai') badge-success
                                                                                                                                                                    @elseif($laporan->status == 'Pending') badge-warning
                                                                                                                                                                    @elseif($laporan->status == 'Ditolak') badge-danger
                                                                                                                                                                    @else badge-info @endif">
                                                {{ $laporan->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($laporans instanceof \Illuminate\Pagination\AbstractPaginator)
                            <div class="mt-2 d-flex justify-content-center">
                                {{ $laporans->links() }}
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            .pagination {
                color: #000 !important;
            }

            .pagination .page-item .page-link {
                color: #000;
                border: 1px solid #dee2e6;
            }

            .pagination .page-item.active .page-link {
                background-color: #f8f9fa;
                border-color: #dee2e6;
                color: #000;
            }

            .btn-outline-danger {
                color: #dc3545 !important;
                border-color: #dc3545 !important;
                background-color: transparent !important;
            }

            .btn-outline-danger:hover,
            .btn-outline-danger:active,
            .btn-outline-danger:focus,
            .btn-outline-danger:focus-visible {
                color: #fff !important;
                background-color: #dc3545 !important;
                border-color: #dc3545 !important;
            }

            .btn-outline-danger:not(:hover):not(:active):focus {
                color: #dc3545 !important;
                background-color: transparent !important;
                border-color: #dc3545 !important;
                box-shadow: none !important;
            }

            .btn-outline-success {
                color: #198754 !important;
                border-color: #198754 !important;
                background-color: transparent !important;
            }

            .btn-outline-success:hover,
            .btn-outline-success:active,
            .btn-outline-success:focus,
            .btn-outline-success:focus-visible {
                color: #fff !important;
                background-color: #198754 !important;
                border-color: #198754 !important;
            }

            .btn-outline-success:not(:hover):not(:active):focus {
                color: #198754 !important;
                background-color: transparent !important;
                border-color: #198754 !important;
                box-shadow: none !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const dateInput = document.getElementById('dateRange');
                const clearBtn = document.getElementById('clearDateRange');
                const rows = document.querySelectorAll('#laporanTable tbody tr');
                const pagination = document.querySelector('.pagination'); // pagination container
                const searchInput = document.getElementById('searchLaporan');

                const fp = flatpickr(dateInput, {
                    mode: 'range',
                    dateFormat: 'd M Y',
                    locale: 'id',
                    onChange: function (selectedDates) {
                        if (selectedDates.length === 2) {
                            const start = selectedDates[0];
                            const end = selectedDates[1];
                            filterByDateRange(start, end);
                            clearBtn.style.display = 'inline-flex';
                            pagination?.classList.add('d-none'); // sembunyikan pagination

                            // isi hidden input untuk export PDF/Excel
                            document.getElementById('pdfStart').value = start.toISOString().split('T')[0];
                            document.getElementById('pdfEnd').value = end.toISOString().split('T')[0];
                            document.getElementById('excelStart').value = start.toISOString().split('T')[0];
                            document.getElementById('excelEnd').value = end.toISOString().split('T')[0];
                        }
                    }
                });

                function filterByDateRange(start, end) {
                    rows.forEach(row => {
                        const rowDateStr = row.getAttribute('data-date');
                        if (!rowDateStr) return row.style.display = 'none';
                        const rowDate = new Date(rowDateStr);
                        row.style.display = (rowDate >= start && rowDate <= end) ? '' : 'none';
                    });
                }

                clearBtn.addEventListener('click', function () {
                    fp.clear();
                    dateInput.value = '';
                    clearBtn.style.display = 'none';
                    rows.forEach(row => row.style.display = '');
                    pagination?.classList.remove('d-none'); // tampilkan kembali pagination
                    document.getElementById('pdfStart').value = '';
                    document.getElementById('pdfEnd').value = '';
                    document.getElementById('excelStart').value = '';
                    document.getElementById('excelEnd').value = '';
                });

                searchInput.addEventListener('keyup', function () {
                    const filter = this.value.toLowerCase();
                    let hasFilter = filter.length > 0;
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        const match = text.includes(filter);
                        row.style.display = match ? '' : 'none';
                        if (match) visibleCount++;
                    });

                    if (hasFilter) {
                        pagination?.classList.add('d-none'); // sembunyikan pagination
                    } else if (!dateInput.value) {
                        pagination?.classList.remove('d-none'); // tampilkan pagination lagi kalau tidak ada filter
                    }
                });
            });
        </script>
    @endpush

@endsection