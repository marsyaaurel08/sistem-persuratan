@extends('layout.app')
@section('title', 'Manajemen Pengguna')
@section('content')
    <div class="page-header">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Manajemen Pengguna</h5>
            </div>
        </div>



        <div class="page-header-right ms-auto">
            <div class="page-header-right-items">
                <div class="d-flex align-items-center gap-2 page-header-right-items-wrapper">

                    <!-- Search Divisi -->
                    <div class="input-group" style="min-width: 180px; height: 38px;">
                        <span
                            class="input-group-text bg-white border-end-0 rounded-start-pill d-flex align-items-center justify-content-center"
                            style="height: 100%;">
                            <i class="feather-search"></i>
                        </span>
                        <input type="text" id="searchPengguna" class="form-control rounded-end-pill"
                            placeholder="Cari pengguna..." style="height: 100%;">
                    </div>

                    <!-- Dropdown Semua Divisi -->
                    <div class="dropdown">
                        <a class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between rounded-pill"
                            style="min-width: 180px; height: 38px;" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="feather-layers me-2"></i>
                            <span>Semua Divisi</span>
                            <i class="feather-chevron-down ms-2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-3">
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="divisi1" checked>
                                <label class="form-check-label" for="divisi1">Divisi A</label>
                            </div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="divisi2" checked>
                                <label class="form-check-label" for="divisi2">Divisi B</label>
                            </div>
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="divisi3">
                                <label class="form-check-label" for="divisi3">Divisi C</label>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>

    <div class="row g-2 mt-3">
        <div class="col-12">
            <div class="card stretch stretch-full p-2">
                <div class="card-body">
                    <h5 class="fs-14 fw-semibold mb-3">Manajemen Pengguna</h5>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm align-middle" id="userTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Divisi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Ahmad Santoso</td>
                                    <td>ahmad@example.com</td>
                                    <td><span class="badge-custom badge-info">Admin</span></td>
                                    <td>Keuangan</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-primary"><i class="feather-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="feather-trash-2"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Siti Nurhaliza</td>
                                    <td>siti@example.com</td>
                                    <td><span class="badge-custom badge-success">User</span></td>
                                    <td>Marketing</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-primary"><i class="feather-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="feather-trash-2"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Budi Prasetyo</td>
                                    <td>budi@example.com</td>
                                    <td><span class="badge-custom badge-purple">Manager</span></td>
                                    <td>HR</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-primary"><i class="feather-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="feather-trash-2"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Rina Wijaya</td>
                                    <td>rina@example.com</td>
                                    <td><span class="badge-custom badge-warning">User</span></td>
                                    <td>IT</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-primary"><i class="feather-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="feather-trash-2"></i></button>
                                        </div>
                                    </td>
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
    <script>
        // Simple Search Table
        document.getElementById('searchPengguna').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#aktivitasTable tbody tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
@endpush