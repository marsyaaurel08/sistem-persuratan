@extends('layout.app')
@section('title', 'Edit Pengguna')

@section('content')
    <div class="container-fluid py-4">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/manajemen-pengguna" class="text-decoration-none" style="color: #000B58;">Data Pengguna</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Pengguna</li>
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
                            <h5 class="fs-16 fw-bold mb-0" style="color: #000B58;">Edit Pengguna</h5>
                        </div>
                    </div>

                    <hr class="m-0 text-secondary opacity-25">

                    <div class="card-body p-4">
                        {{-- Form edit pengguna --}}
                        <form id="formEditPengguna" method="POST" action="{{ route('pengguna.update', $pengguna->id) }}" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <div class="col-6">
                                    <label class="form-label fw-semibold mb-1">Nama Lengkap</label>
                                    <input type="text" name="name"
                                        class="form-control rounded-pill border-light-subtle bg-light"
                                        value="{{ old('name', $pengguna->name) }}"
                                        placeholder="Contoh: Ahmad Santoso" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-1">Alamat Email</label>
                                    <input type="email" name="email"
                                        class="form-control rounded-pill border-light-subtle bg-light"
                                        value="{{ old('email', $pengguna->email) }}"
                                        placeholder="nama@perusahaan.com" required autocomplete="off">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-1">Role / Akses</label>
                                    <select name="role" class="form-select rounded-pill border-light-subtle bg-light" required>
                                        <option disabled>Pilih Role</option>
                                        <option value="Admin" {{ old('role', $pengguna->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Pimpinan" {{ old('role', $pengguna->role) == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                        <option value="Staff" {{ old('role', $pengguna->role) == 'Staff' ? 'selected' : '' }}>Staff</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold mb-1">Divisi</label>
                                    <select name="divisi" class="form-select rounded-pill border-light-subtle bg-light" required>
                                        <option disabled>Pilih Divisi</option>
                                        <option value="IT" {{ old('divisi', $pengguna->divisi) == 'IT' ? 'selected' : '' }}>IT</option>
                                        <option value="HR" {{ old('divisi', $pengguna->divisi) == 'HR' ? 'selected' : '' }}>HR</option>
                                        <option value="Keuangan" {{ old('divisi', $pengguna->divisi) == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                                        <option value="Marketing" {{ old('divisi', $pengguna->divisi) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold mb-1">Password Baru (Opsional)</label>
                                    <div class="input-group">
                                        <input type="password" name="password"
                                            class="form-control rounded-start-pill border-light-subtle bg-light"
                                            placeholder="Biarkan kosong jika tidak ingin mengubah password"
                                            autocomplete="new-password">
                                        <button class="btn btn-outline-secondary rounded-end-pill px-3" type="button"
                                            onclick="togglePassword(this)">
                                            <i class="feather-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="/manajemen-pengguna" class="btn btn-light rounded-pill px-4">Batal</a>
                                        <button type="submit" class="btn rounded-pill px-4 text-white shadow-sm "
                                            style="background-color: #000B58;">
                                            Perbarui Data
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
                            <li class="mb-2">Email tidak boleh sama dengan pengguna lain.</li>
                            <li class="mb-2">Kosongkan kolom password jika tidak ingin mengubahnya.</li>
                            <li>Pastikan Role dan Divisi sesuai dengan tanggung jawab pengguna.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        /* ==== Toast Modern ==== */
        .toast-notif {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            max-width: 360px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.95rem;
            background: #fff;
            color: #333;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left: 6px solid;
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.4s ease;
            z-index: 9999;
        }
        .toast-notif.show { opacity: 1; transform: translateX(0); }
        .toast-success { border-color: #28a745; background-color: #e8f5e9; }
        .toast-error { border-color: #dc3545; background-color: #fdecea; }
        .toast-icon { font-size: 1.2rem; flex-shrink: 0; }
        .toast-close { margin-left: auto; background: transparent; border: none; color: #666; font-size: 1.1rem; cursor: pointer; }
        .toast-close:hover { color: #000; }
    </style>

    <div id="toastNotif" class="toast-notif">
        <div class="toast-icon"></div>
        <div class="toast-message"></div>
        <button class="toast-close" type="button">&times;</button>
    </div>

    <script>
        // === Toggle Password ===
        function togglePassword(btn) {
            const input = btn.previousElementSibling;
            input.type = input.type === "password" ? "text" : "password";
            btn.querySelector('i').classList.toggle('feather-eye');
            btn.querySelector('i').classList.toggle('feather-eye-off');
        }

        // === Toast Modern ===
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotif');
            const icon = toast.querySelector('.toast-icon');
            const msg = toast.querySelector('.toast-message');
            const closeBtn = toast.querySelector('.toast-close');
            toast.className = `toast-notif toast-${type}`;
            msg.textContent = message;

            icon.innerHTML = type === 'success'
                ? '<i class="feather-check-circle text-success"></i>'
                : '<i class="feather-x-circle text-danger"></i>';

            toast.classList.add('show');
            setTimeout(() => hideToast(), 3000);
            closeBtn.onclick = hideToast;
        }
        function hideToast() {
            const toast = document.getElementById('toastNotif');
            toast.classList.remove('show');
        }

        // === Submit via Fetch ===
        document.getElementById('formEditPengguna').addEventListener('submit', async function (e) {
            e.preventDefault();
            const form = this;
            const formData = new FormData(form);
            // Pastikan _method=PUT dikirim untuk Laravel
            formData.set('_method', 'PUT');
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                });
                if (response.ok) {
                    const result = await response.json().catch(() => ({}));
                    if (result.success) {
                        showToast('Data pengguna berhasil diperbarui!', 'success');
                        setTimeout(() => window.location.href = '/manajemen-pengguna?updated=1', 1000);
                    } else {
                        showToast('Gagal memperbarui data pengguna.', 'error');
                    }
                } else if (response.status === 422) {
                    const data = await response.json();
                    let msg = '';
                    for (const key in data.errors) {
                        msg += data.errors[key].join(' ') + '\n';
                    }
                    showToast(msg, 'warning');
                } else {
                    showToast('Terjadi kesalahan server.', 'error');
                }
            } catch {
                showToast('Terjadi kesalahan koneksi.', 'error');
            }
        });
    </script>
@endpush