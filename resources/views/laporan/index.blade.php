@extends('layout.app')

@section('title', 'Rekap')

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

                    <form method="GET" action="{{ route('laporan.index') }}" id="searchForm" class="m-0 p-0">
                        <input type="hidden" name="start" value="{{ request('start') }}">
                        <input type="hidden" name="end" value="{{ request('end') }}">

                        <div class="input-group rounded-pill border border-secondary-subtle align-items-center"
                            style="width: 220px; height: 38px; overflow: hidden; font-size: small;">
                            <span
                                class="input-group-text bg-white border-0 d-flex align-items-center justify-content-center px-2 h-100">
                                <i class="feather-search"></i>
                            </span>
                            <input type="text" name="search" id="searchInput"
                                class="form-control border-0 px-2 h-100 d-flex align-items-center" placeholder="Cari..."
                                value="{{ request('search') }}"
                                style="cursor: text; font-size: small; background-color: white; line-height: normal;">
                        </div>
                    </form>

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
                                    <th>Kode Arsip</th>
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Arsip</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporans as $laporan)
                                    <tr
                                        data-date="{{ $laporan->tanggal_arsip ? \Carbon\Carbon::parse($laporan->tanggal_arsip)->format('Y-m-d') : '' }}">
                                        <td>{{ $laporan->kode_arsip }}</td>
                                        <td>{{ $laporan->nomor_surat }}</td>
                                        <td>{{ $laporan->perihal }}</td>
                                        <td>
                                            <span class="badge-custom 
                                                                                    @if ($laporan->kategori == 'Masuk') badge-success
                                                                                    @elseif($laporan->kategori == 'Keluar') badge-warning
                                                                                    @elseif($laporan->kategori == 'Laporan') badge-info
                                                                                    @else badge-secondary @endif">
                                                {{ $laporan->kategori }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal_arsip)->format('d M Y') }}</td>
                                    </tr>
                                    <tr id="noDataRow" style="display: none;">
                                        <td colspan="100%" class="text-center text-muted py-3">
                                            {{-- Data tidak ditemukan --}}
                                            Tidak ada data laporan yang sesuai dengan pencarian.
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($laporans instanceof \Illuminate\Pagination\AbstractPaginator)
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

            .input-group .form-control:focus {
                border-color: #ced4da !important;
                box-shadow: none !important;
                outline: none !important;
            }

            /* Satukan border input + icon */
            .input-group {
                border: 1px solid #ced4da;
                border-radius: 50px;
                overflow: hidden;
                transition: all 0.2s ease-in-out;
            }

            /* Hilangkan double border */
            .input-group-text {
                border: none;
            }

            .input-group .form-control {
                border: none;
            }

            /* EFFECT AKTIF SATU KESATUAN */
            .input-group:focus-within {
                border-color: #3473d8;
                box-shadow: 0 0 0 2px rgba(10, 59, 139, 0.514);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // ========== SEARCH (auto submit, debounce 500ms) ==========
                let timer;
                const input = document.getElementById('searchInput');
                const form = document.getElementById('searchForm');

                if (input && form) {
                    input.addEventListener('keyup', function () {
                        clearTimeout(timer);
                        timer = setTimeout(() => form.submit(), 500);
                    });
                }

                // ========== DATE RANGE FILTER (flatpickr) ==========
                const dateInput = document.getElementById('dateRange');
                const clearBtn = document.getElementById('clearDateRange');

                if (dateInput) {
                    const fp = flatpickr(dateInput, {
                        mode: 'range',
                        dateFormat: 'd M Y',
                        locale: 'id',
                        onClose: function (selectedDates) {
                            if (selectedDates.length === 2) {

                                const start = fp.formatDate(selectedDates[0], "Y-m-d");
                                const end = fp.formatDate(selectedDates[1], "Y-m-d");

                                const url = new URL(window.location.href);
                                url.searchParams.set('start', start);
                                url.searchParams.set('end', end);
                                window.location.href = url.toString(); // reload halaman
                            }
                        }
                    });

                    // tampilkan tanggal aktif dari query URL
                    const params = new URLSearchParams(window.location.search);
                    const start = params.get('start');
                    const end = params.get('end');
                    if (start && end) {
                        dateInput.value =
                            `${fp.formatDate(new Date(start), "d M Y")} - ${fp.formatDate(new Date(end), "d M Y")}`;
                        clearBtn.style.display = "flex";
                    }

                    // tombol reset tanggal
                    clearBtn.addEventListener('click', function () {
                        const url = new URL(window.location.href);
                        url.searchParams.delete('start');
                        url.searchParams.delete('end');
                        window.location.href = url.toString();
                    });
                }
            });
        </script>
        <script>

            document.addEventListener('DOMContentLoaded', function () {

                let timer;

                const input = document.getElementById('searchInput');
                const form = document.getElementById('searchForm');

                input.addEventListener('keyup', function () {

                    clearTimeout(timer);

                    timer = setTimeout(function () {

                        form.submit();

                    }, 500);

                });

            });

        </script>
    @endpush

@endsection