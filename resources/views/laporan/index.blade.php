@extends('layout.app')

@section('title', 'Laporan')

@section('content')

    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>
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

            /* Pastikan tombol PDF kembali ke warna normal setelah klik */
            .btn-outline-danger {
                color: #dc3545 !important;
                border-color: #dc3545 !important;
                background-color: transparent !important;
            }

            /* Hover dan active: tetap merah normal */
            .btn-outline-danger:hover,
            .btn-outline-danger:active,
            .btn-outline-danger:focus,
            .btn-outline-danger:focus-visible {
                color: #fff !important;
                background-color: #dc3545 !important;
                border-color: #dc3545 !important;
            }

            /* Setelah klik (hilangkan efek focus putih) */
            .btn-outline-danger:not(:hover):not(:active):focus {
                color: #dc3545 !important;
                background-color: transparent !important;
                border-color: #dc3545 !important;
                box-shadow: none !important;
            }

            /* Pastikan tombol Excel kembali ke warna normal setelah klik */
            .btn-outline-success {
                color: #198754 !important;
                border-color: #198754 !important;
                background-color: transparent !important;
            }

            /* Hover dan active: tetap hijau normal */
            .btn-outline-success:hover,
            .btn-outline-success:active,
            .btn-outline-success:focus,
            .btn-outline-success:focus-visible {
                color: #fff !important;
                background-color: #198754 !important;
                border-color: #198754 !important;
            }

            /* Setelah klik (hilangkan efek focus putih) */
            .btn-outline-success:not(:hover):not(:active):focus {
                color: #198754 !important;
                background-color: transparent !important;
                border-color: #198754 !important;
                box-shadow: none !important;
            }
        </style>
    @endpush
    @push('scripts')
        <!-- Date Range Picker with Filtering -->
        <script>
            $(function () {
                const $dateInput = $('#dateRange');
                const $clearBtn = $('#clearDateRange');
                const $tableRows = $('#laporanTable tbody tr');

                // 🔹 Inisialisasi Date Range Picker
                $dateInput.daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: 'DD MMM YYYY',
                        applyLabel: 'Terapkan',
                        cancelLabel: 'Batal',
                        daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                        monthNames: [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ]
                    },
                    opens: 'left'
                });

                // 🔹 Fungsi filter tabel berdasarkan tanggal
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
                        const rowDate = rowDateStr ? moment(rowDateStr, 'YYYY-MM-DD') : null;

                        $(this).toggle(
                            rowDate &&
                            rowDate.isSameOrAfter(startDate, 'day') &&
                            rowDate.isSameOrBefore(endDate, 'day')
                        );
                    });
                }

                // 🔹 Saat user pilih tanggal
                $dateInput.on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(
                        picker.startDate.format('DD MMM YYYY') + ' - ' + picker.endDate.format('DD MMM YYYY')
                    );
                    $clearBtn.show();
                    filterByDateRange();

                    // 🟢 Simpan nilai ke form PDF & Excel
                    $('#pdfStart').val(picker.startDate.format('YYYY-MM-DD'));
                    $('#pdfEnd').val(picker.endDate.format('YYYY-MM-DD'));
                    $('#excelStart').val(picker.startDate.format('YYYY-MM-DD'));
                    $('#excelEnd').val(picker.endDate.format('YYYY-MM-DD'));
                });

                // 🔹 Saat user klik batal
                $dateInput.on('cancel.daterangepicker', function () {
                    $(this).val('');
                    $clearBtn.hide();
                    filterByDateRange();

                    // 🟢 Kosongkan hidden input
                    $('#pdfStart, #pdfEnd, #excelStart, #excelEnd').val('');
                });

                // 🔹 Tombol reset tanggal
                $clearBtn.on('click', function () {
                    $dateInput.val('');
                    $(this).hide();
                    filterByDateRange();

                    // 🟢 Reset hidden input
                    $('#pdfStart, #pdfEnd, #excelStart, #excelEnd').val('');
                });
            });
        </script>

        <script>
            // Search seluruh kolom di tabel
            document.getElementById('searchLaporan').addEventListener('keyup', function () {
                const filter = this.value.toLowerCase();
                const rows = document.querySelectorAll('#laporanTable tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });


            
        </script>
    @endpush

@endsection