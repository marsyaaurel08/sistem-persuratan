@extends('layout.app')

@section('title', 'Arsip')

@section('content')
    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>

    <!-- Row 4 Card Dashboard -->
    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Arsip</h5>
            </div>
        </div>

        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">

                    <!-- Search Bar -->
                    <div class="input-group" style="min-width: 300px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill" id="search-icon">
                            <i class="feather-search"></i>
                        </span>
                        <input type="text" id="searchTable" class="form-control rounded-end-pill" placeholder="Cari surat..."
                            style="font-size: small">
                    </div>


                    <!-- Date Range Picker -->
                    <div class="input-group" style="min-width: 300px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill"><i class="feather-calendar"></i></span>
                        <input type="text" id="dateRange" class="form-control rounded-end-pill" placeholder="Pilih Rentang Tanggal" readonly
                            style="cursor: pointer; font-size: small;">
                        <button class="btn btn-light border" type="button" id="clearDateRange" title="Reset tanggal"
                            style="display: none;">
                            <i class="feather-x"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-2">

        <!-- Row Arsip Terbaru -->
        <div class="row g-2 mt-3">
            <div class="col-12">
                <div class="card stretch stretch-full p-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fs-14 fw-semibold mb-0">Arsip Terbaru</h5>

                        </div>

                        <!-- Bulk Action Bar -->
                        <div id="bulkActionBar"
                            class="alert alert-light border-primary d-flex align-items-center gap-3 mb-3"
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
                            <table class="table table-hover table-sm align-middle" id="aktivitasTable">
                                <thead>
                                    <tr>
                                        <th style="width:40px;"></th>
                                        <th>No. Surat</th>
                                        <th>Perihal</th>
                                        <th>Penerima</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="row-checkbox">
                                        </td>
                                        <td>001/INV/2026</td>
                                        <td>Pembayaran Invoice</td>
                                        <td>PT ABC / Finance</td>
                                        <td>19 Jan 2026</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="row-checkbox">
                                        </td>
                                        <td>002/INV/2026</td>
                                        <td>Order Barang</td>
                                        <td>PT XYZ / Warehouse</td>
                                        <td>18 Jan 2026</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="row-checkbox">
                                        </td>
                                        <td>003/INV/2026</td>
                                        <td>Proposal Kerja Sama</td>
                                        <td>Marketing / PT DEF</td>
                                        <td>17 Jan 2026</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="row-checkbox">
                                        </td>
                                        <td>004/INV/2026</td>
                                        <td>Follow Up Payment</td>
                                        <td>Finance / PT GHI</td>
                                        <td>16 Jan 2026</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            // Line Chart
            const ctxLine = document.getElementById('lineChart').getContext('2d');
            const lineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [12, 19, 14, 21, 17, 23],
                        borderColor: '#000B58',
                        backgroundColor: 'rgba(0,11,88,0.2)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Pie Chart
            const ctxPie = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Nota Dinas', 'Undangan', 'Lainnya'],
                    datasets: [{
                        data: [31, 48, 21],
                        backgroundColor: ['#000B58', '#8BBCE7', '#FFEB3B']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            align: 'center',
                            labels: {
                                usePointStyle: true, // lingkaran
                                pointStyle: 'circle',
                                boxWidth: 12,
                                padding: 10,
                                font: { size: 12 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.chart._metasets[context.datasetIndex].total;
                                    let percentage = ((value / total) * 100).toFixed(0);
                                    return `${label}: ${percentage} %`;
                                }
                            }
                        }
                    }
                }
            });


        </script>
        <script>
            // Simple Search Table
            document.getElementById('searchTable').addEventListener('keyup', function () {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#aktivitasTable tbody tr');

                rows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        </script>
        <script>
            // Date Range Picker Initialization
            $(function () {
                $('#dateRange').daterangepicker({
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

                // Event ketika user memilih tanggal
                $('#dateRange').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(
                        picker.startDate.format('DD MMM YYYY') +
                        ' - ' +
                        picker.endDate.format('DD MMM YYYY')
                    );
                    $('#clearDateRange').show(); // Tampilkan tombol clear
                });

                // Event ketika user membatalkan pilihan
                $('#dateRange').on('cancel.daterangepicker', function () {
                    $(this).val('');
                    $('#clearDateRange').hide(); // Sembunyikan tombol clear
                });

                // Event ketika tombol clear diklik
                $('#clearDateRange').on('click', function () {
                    $('#dateRange').val('');
                    $(this).hide();
                });

                // Event ketika tombol filter diklik
                $('#btnFilter').on('click', function () {
                    var dateRange = $('#dateRange').val();
                    if (dateRange) {
                        console.log('Filter dengan rentang tanggal:', dateRange);
                        // Tambahkan logic filter di sini
                        alert('Filter akan diterapkan untuk: ' + dateRange);
                    } else {
                        alert('Silakan pilih rentang tanggal terlebih dahulu');
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('change', function (e) {

                const selectAll = document.getElementById('selectAll');
                const rowCheckboxes = document.querySelectorAll('.row-checkbox');
                const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;

                // ======================
                // KLIK SELECT ALL
                // ======================
                if (e.target.id === 'selectAll') {
                    rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
                }

                // ======================
                // UPDATE SELECT ALL STATUS
                // ======================
                selectAll.checked = checkedCount === rowCheckboxes.length && rowCheckboxes.length > 0;
                selectAll.indeterminate = checkedCount > 0 && checkedCount < rowCheckboxes.length;

                // ======================
                // BULK BAR
                // ======================
                const bulkBar = document.getElementById('bulkActionBar');
                const countText = document.getElementById('selectedCount');

                countText.textContent = checkedCount;
                bulkBar.style.display = checkedCount > 0 ? 'flex' : 'none';

            });
        </script>


    @endpush