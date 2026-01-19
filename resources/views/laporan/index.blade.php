@extends('layout.app')

@section('title', 'Laporan')

@section('content')
    <div class="page-header rounded">
    <div class="page-header-left d-flex align-items-center">
        <div class="page-header-title">
            <h5 class="m-b-10">Laporan</h5>
        </div>
    </div>

    <div class="page-header-right ms-auto">
        <div class="page-header-right-items">
            <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper ">

                <!-- Search Divisi -->
                <div class="input-group" style="max-width: 250px; height: 38px;">
                    <span
                        class="input-group-text bg-white border-end-0 rounded-start-pill d-flex align-items-center justify-content-center"
                        style="height: 100%;">
                        <i class="feather-search"></i>
                    </span>
                    <input type="text" id="searchLaporan" class="form-control rounded-end-pill"
                        placeholder="Cari laporan..." style="height: 100%;">
                </div>


                <!-- Rentang Tanggal -->
                <div class="dropdown">
                    <a class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between rounded-pill"
                        style="min-width: 180px; height: 38px;" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="feather-calendar me-2"></i>
                        <span>Rentang Tanggal</span>
                        <i class="feather-chevron-down ms-2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-3">
                        <input type="text" class="form-control mb-2" placeholder="Pilih tanggal awal">
                        <input type="text" class="form-control mb-2" placeholder="Pilih tanggal akhir">
                        <div class="d-flex justify-content-between mt-2">
                            <button class="btn btn-sm btn-light">Reset</button>
                            <button class="btn btn-sm btn-success">Terapkan</button>
                        </div>
                    </div>
                </div>
                <!-- Tombol Export Compact -->
                <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-2 py-1 rounded-pill"
                    style="width: 70px; height: 35px;">
                    <i class="feather-file-text"></i>
                    <span>PDF</span>
                </button>

                <button class="btn btn-sm btn-outline-success d-flex align-items-center gap-1 px-2 py-1 rounded-pill"
                    style="width: 70px; height: 35px;">
                    <i class="feather-file"></i>
                    <span>Excel</span>
                </button>


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

                    <!-- Search Input untuk tabel -->
                    {{-- <div class="mb-3 d-flex justify-content-end">
                        <input type="text" id="searchTableLaporan" class="form-control w-auto rounded-pill"
                            placeholder="Cari data laporan...">
                    </div> --}}

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
                                <tr>
                                    <td>001/LAP/2026</td>
                                    <td>Laporan Keuangan</td>
                                    <td>Divisi A</td>
                                    <td>19 Jan 2026</td>
                                    <td><span class="badge-custom badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td>002/LAP/2026</td>
                                    <td>Laporan Stok</td>
                                    <td>Divisi B</td>
                                    <td>18 Jan 2026</td>
                                    <td><span class="badge-custom badge-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>003/LAP/2026</td>
                                    <td>Laporan Marketing</td>
                                    <td>Divisi C</td>
                                    <td>17 Jan 2026</td>
                                    <td><span class="badge-custom badge-danger">Ditolak</span></td>
                                </tr>
                                <tr>
                                    <td>004/LAP/2026</td>
                                    <td>Laporan HR</td>
                                    <td>Divisi A</td>
                                    <td>16 Jan 2026</td>
                                    <td><span class="badge-custom badge-info">Proses</span></td>
                                </tr>
                                <tr>
                                    <td>001/LAP/2026</td>
                                    <td>Laporan Keuangan</td>
                                    <td>Divisi A</td>
                                    <td>19 Jan 2026</td>
                                    <td><span class="badge-custom badge-success">Selesai</span></td>
                                </tr>
                                <tr>
                                    <td>002/LAP/2026</td>
                                    <td>Laporan Stok</td>
                                    <td>Divisi B</td>
                                    <td>18 Jan 2026</td>
                                    <td><span class="badge-custom badge-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>003/LAP/2026</td>
                                    <td>Laporan Marketing</td>
                                    <td>Divisi C</td>
                                    <td>17 Jan 2026</td>
                                    <td><span class="badge-custom badge-danger">Ditolak</span></td>
                                </tr>
                                <tr>
                                    <td>004/LAP/2026</td>
                                    <td>Laporan HR</td>
                                    <td>Divisi A</td>
                                    <td>16 Jan 2026</td>
                                    <td><span class="badge-custom badge-info">Proses</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Search divisi di tabel
            document.getElementById('searchLaporan').addEventListener('keyup', function () {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#laporanTable tbody tr');

                rows.forEach(row => {
                    let divisi = row.cells[2].textContent.toLowerCase(); // kolom Divisi
                    row.style.display = divisi.includes(filter) ? '' : 'none';
                });
            });

            // Search seluruh tabel
            document.getElementById('searchTableLaporan').addEventListener('keyup', function () {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#laporanTable tbody tr');

                rows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        </script>
    @endpush

@endsection