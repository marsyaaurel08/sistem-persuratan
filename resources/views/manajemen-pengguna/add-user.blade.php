@extends('layout.app')
@section('title', 'Tambah Pengguna')
@section('content')
    <div class="container-fluid py-4">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/manajemen-pengguna" class="text-decoration-none" style="color: #000B58;">Data
                        Pengguna</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-0">
                        <div class="d-flex align-items-center">
                            <a href="/manajemen-pengguna"
                                class="btn btn-sm btn-light rounded-circle me-3 d-inline-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px; padding: 0;">
                                <i class="feather-arrow-left"></i>
                            </a>
                            <h5 class="fs-16 fw-bold mb-0" style="color: #000B58;">Tambah Pengguna Baru</h5>
                        </div>
                    </div>

                    <hr class="m-0 text-secondary opacity-25">

                    <div class="card-body p-4">
                        <form action="#" method="POST">
                            <div class="row g-4">
                                <div class="col-6">
                                    <label class="form-label fw-semibold mb-1">Nama Lengkap</label>
                                    <input type="text" class="form-control rounded-pill border-light-subtle bg-light"
                                        placeholder="Contoh: Ahmad Santoso" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-1">Alamat Email</label>
                                    <input type="email" class="form-control rounded-pill border-light-subtle bg-light"
                                        placeholder="nama@perusahaan.com" required>
                                </div>



                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-1">Role / Akses</label>
                                    <select class="form-select rounded-pill border-light-subtle bg-light">
                                        <option selected disabled>Pilih Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-1">Divisi</label>
                                    <select class="form-select rounded-pill border-light-subtle bg-light">
                                        <option selected disabled>Pilih Divisi</option>
                                        <option value="it">IT</option>
                                        <option value="hr">HR</option>
                                        <option value="keuangan">Keuangan</option>
                                        <option value="marketing">Marketing</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold mb-1">Password Sementara</label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control rounded-start-pill border-light-subtle bg-light"
                                            placeholder="Minimal 8 karakter" required>
                                        <button class="btn btn-outline-secondary rounded-end-pill px-3" type="button">
                                            <i class="feather-eye"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="col-12 mt-5">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light rounded-pill px-4">Batal</button>
                                        <button type="submit" class="btn rounded-pill px-5 text-white shadow-sm"
                                            style="background-color: #000B58;">
                                            Simpan Pengguna
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 bg-light-subtle">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3" style="color: #000B58;">Panduan Pengisian</h6>
                        <ul class="small text-secondary ps-3">
                            <li class="mb-2">Pastikan alamat email aktif untuk pengiriman aktivasi.</li>
                            <li class="mb-2">Role menentukan tingkat akses menu yang dapat dibuka.</li>
                            <li>Gunakan kombinasi huruf dan angka untuk password yang kuat.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection