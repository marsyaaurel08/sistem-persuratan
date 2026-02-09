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
            <div class="page-header-right-items d-flex align-items-center gap-2">
                <!-- Search -->
                <div class="input-group" style="min-width: 180px; height: 38px;">
                    <span
                        class="input-group-text bg-white border-end-0 rounded-start-pill d-flex align-items-center justify-content-center"
                        style="height: 100%;">
                        <i class="feather-search"></i>
                    </span>
                    <input type="text" id="searchPengguna" class="form-control rounded-end-pill"
                        placeholder="Cari pengguna..." style="height: 100%;">
                </div>

                <!-- Dropdown Divisi -->
                <div class="dropdown">
                    <button id="dropdownDivisiButton"
                        class="btn btn-md btn-light-brand d-flex align-items-center justify-content-between rounded-pill"
                        style="min-width: 180px; height: 38px;" type="button" data-bs-toggle="dropdown"
                        data-bs-auto-close="outside" aria-expanded="false">
                        <i class="feather-layers me-2"></i>
                        <span>Semua Divisi</span>
                        <i class="feather-chevron-down ms-2"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-3 shadow-sm" style="min-width: 240px;">
                        <div class="form-check mb-2 border-bottom pb-2">
                            <input class="form-check-input" type="checkbox" id="pilihSemuaDivisi" checked>
                            <label class="form-check-label fw-bold" for="pilihSemuaDivisi">Pilih Semua</label>
                        </div>
                        @foreach ($divisi as $item)
                            <div class="form-check mb-1">
                                <input class="form-check-input divisi-checkbox" type="checkbox" id="divisi{{ $loop->index }}"
                                    value="{{ $item }}" checked>
                                <label class="form-check-label" for="divisi{{ $loop->index }}">{{ $item }}</label>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                            <button class="btn btn-sm btn-light px-3 py-1 rounded-pill" id="resetDivisi"><i
                                    class="feather-x me-1"></i> Reset</button>
                            <button class="btn btn-sm btn-primary px-3 py-1 rounded-pill" id="applyDivisi"><i
                                    class="feather-check me-1"></i> Terapkan</button>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fs-14 fw-semibold mb-0">Data Pengguna</h5>
                        <a href="/tambah-pengguna">
                            <button class="btn btn-sm rounded-pill px-3"
                                style="background-color: #000B58; color: white; border: none;">
                                <i class="feather-plus me-1"></i> Tambah
                            </button>
                        </a>
                    </div>

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
                                @forelse ($pengguna as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge-custom
                                                        @if ($user->role === 'Admin') badge-info
                                                        @elseif($user->role === 'Pimpinan') badge-purple
                                                        @else badge-success @endif">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td>{{ $user->divisi ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('pengguna.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="feather-edit"></i>
                                                </a>

                                                <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST"
                                                    class="form-hapus-pengguna" data-nama="{{ $user->name }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger btn-hapus-pengguna">
                                                        <i class="feather-trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            Data pengguna tidak ditemukan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pengguna->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Modern -->
    <div id="toastNotif" class="toast-notif">
        <div class="toast-icon"></div>
        <div class="toast-message"></div>
        <button class="toast-close">&times;</button>
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

        .toast-notif.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast-success {
            border-color: #28a745;
            background-color: #e8f5e9;
        }

        .toast-info {
            border-color: #0d6efd;
            background-color: #e7f0ff;
        }

        .toast-warning {
            border-color: #ffc107;
            background-color: #fff8e1;
        }

        /* ==== Custom Pagination ==== */
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

        .toast-error {
            border-color: #dc3545;
            background-color: #fdecea;
        }

        .toast-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .toast-close {
            margin-left: auto;
            background: transparent;
            border: none;
            color: #666;
            font-size: 1.1rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #000;
        }
    </style>

    <script>
        // === Modern Toast Function ===
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotif');
            const icon = toast.querySelector('.toast-icon');
            const msg = toast.querySelector('.toast-message');
            const closeBtn = toast.querySelector('.toast-close');

            toast.className = `toast-notif toast-${type}`;
            msg.textContent = message;

            switch (type) {
                case 'success':
                    icon.innerHTML = '<i class="feather-check-circle text-success"></i>';
                    break;
                case 'info':
                    icon.innerHTML = '<i class="feather-info text-primary"></i>';
                    break;
                case 'warning':
                    icon.innerHTML = '<i class="feather-alert-triangle text-warning"></i>';
                    break;
                case 'error':
                    icon.innerHTML = '<i class="feather-x-circle text-danger"></i>';
                    break;
            }

            toast.classList.add('show');

            setTimeout(() => hideToast(), 3000);
            closeBtn.onclick = hideToast;
        }

        function hideToast() {
            const toast = document.getElementById('toastNotif');
            toast.classList.remove('show');
        }

        // === Hapus pengguna AJAX ===
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-hapus-pengguna').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const form = btn.closest('form.form-hapus-pengguna');
                    const nama = form.getAttribute('data-nama') || '';
                    e.preventDefault();
                    if (!confirm(`Yakin ingin menghapus pengguna "${nama}"?`)) return;

                    const fd = new FormData(form);
                    fetch(form.action, {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        body: fd
                    })
                    .then(async res => {
                        let data = {};
                        try {
                            data = await res.json();
                        } catch {}
                        if (res.ok && data.success) {
                            showToast(data.message || 'Berhasil menghapus pengguna');
                            setTimeout(() => window.location.reload(), 900);
                        } else if (res.ok && !data.success) {
                            showToast(data.message || 'Gagal menghapus pengguna!');
                        } else {
                            showToast('Gagal menghapus pengguna!');
                        }
                    })
                    .catch(() => showToast('Terjadi kesalahan koneksi.'));
                });
            });

            // Toast dari session (Laravel flash)
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif
            });
    </script>
    <script>
    // Tampilkan toast jika ada ?success=1 di URL (setelah tambah pengguna)
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === '1') {
            showToast('Pengguna baru berhasil ditambahkan!', 'success');
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        } else if (urlParams.get('updated') === '1') {
            showToast('Data pengguna berhasil diperbarui!', 'success');
            if (window.history.replaceState) {
                const url = new URL(window.location);
                url.searchParams.delete('updated');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        }
    });
    </script>

    <script>
        // === Fungsi filter gabungan (pencarian + divisi) ===
        document.getElementById('searchPengguna').addEventListener('keyup', filterTable);

        function filterTable() {
            let filterText = document.getElementById('searchPengguna').value.toLowerCase();
            let selectedDivisi = Array.from(document.querySelectorAll('.divisi-checkbox:checked')).map(cb => cb.value.toLowerCase());
            let rows = document.querySelectorAll('#userTable tbody tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                let divisi = row.children[4]?.textContent.trim().toLowerCase() || '';
                let matchText = text.includes(filterText);
                let matchDivisi = selectedDivisi.length === 0 || selectedDivisi.includes(divisi);
                row.style.display = matchText && matchDivisi ? '' : 'none';
            });
        }

        document.getElementById('pilihSemuaDivisi').addEventListener('change', function () {
            document.querySelectorAll('.divisi-checkbox').forEach(cb => cb.checked = this.checked);
            updateDivisiLabel();
        });

        document.getElementById('resetDivisi').addEventListener('click', function () {
            document.querySelectorAll('.divisi-checkbox').forEach(cb => cb.checked = true);
            document.getElementById('pilihSemuaDivisi').checked = true;
            updateDivisiLabel();
            filterTable();
        });

        document.getElementById('applyDivisi').addEventListener('click', function () {
            filterTable();
            updateDivisiLabel();
            const dropdownToggle = document.getElementById('dropdownDivisiButton');
            let dropdown = bootstrap.Dropdown.getInstance(dropdownToggle);
            if (!dropdown) dropdown = new bootstrap.Dropdown(dropdownToggle);
            dropdown.hide();
        });

        function updateDivisiLabel() {
            const totalDivisi = document.querySelectorAll('.divisi-checkbox').length;
            const selectedDivisi = document.querySelectorAll('.divisi-checkbox:checked').length;
            const label = document.querySelector('#dropdownDivisiButton span');

            if (selectedDivisi === totalDivisi) {
                label.textContent = 'Semua Divisi';
            } else if (selectedDivisi === 0) {
                label.textContent = '0 divisi dipilih';
            } else if (selectedDivisi === 1) {
                label.textContent = '1 divisi dipilih';
            } else {
                label.textContent = `${selectedDivisi} divisi dipilih`;
            }
        }

        document.querySelectorAll('.divisi-checkbox').forEach(cb => {
            cb.addEventListener('change', function () {
                const totalDivisi = document.querySelectorAll('.divisi-checkbox').length;
                const checkedCount = document.querySelectorAll('.divisi-checkbox:checked').length;
                document.getElementById('pilihSemuaDivisi').checked = (checkedCount === totalDivisi);
                updateDivisiLabel();
            });
        });
    </script>
@endpush 