@extends('layout.app')

@section('title', 'Upload Berkas Arsip')

@section('content')
    <div class="main-content">
        <div class="page-header d-flex align-items-center justify-content-between mb-4 pb-2 rounded">
            <div class="page-header-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('arsip.index') }}"
                                class="d-flex align-items-center text-dark fw-bold decoration-none">
                                <div class="d-flex align-items-center justify-content-center me-3 shadow-sm"
                                    style="width: 35px; height: 35px; border: 1px solid #eee; border-radius: 50%; background-color: #fff;">
                                    <i class="feather-arrow-left text-primary"></i>
                                </div>
                                <span style="font-size: large; letter-spacing: -0.5px;">Upload Berkas Arsip</span>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="row">
                <div class="col-lg-7">
                    <div class="card stretch stretch-full shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3">Upload File</h5>

                            <div class="border-dashed border-2 p-5 text-center rounded-4 position-relative mb-4"
                                style="border-style: dashed; border-color: #d1d5db; background-color: #f8fafc; cursor: pointer;"
                                id="dropZone">

                                <input type="file" name="files[]" id="fileInput"
                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0" style="cursor: pointer;"
                                    multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.tiff">

                                <div class="d-flex flex-column align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle mb-3" style="height: 50px; width: 50px;">
                                        <i class="feather-upload-cloud" style="color: white"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Pilih file atau drag and drop di sini</h5>
                                    <p class="text-muted small">
                                        Format: PDF, DOC, DOCX, JPG, JPEG, PNG, TIFF (Maks 20MB per file)
                                    </p>
                                    <button type="button" class="btn btn-primary px-4 fw-bold"
                                        onclick="document.getElementById('fileInput').click()">
                                        Browse Files
                                    </button>
                                </div>
                            </div>

                            <div id="fileListContainer" style="display: none;">
                                <h6 class="fw-bold mb-3">File yang akan diupload (<span id="fileCount">0</span>)</h6>
                                <div class="list-group gap-2" id="fileList"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Detail Arsip</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Kategori Arsip<span
                                        class="text-danger">*</span></label>
                                <select name="kategori" id="kategori" class="form-select" required>
                                    <option value="">-- Pilih Kategori Arsip --</option>
                                    @foreach (\App\Models\Arsip::KATEGORI as $value => $label)
                                        <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 position-relative" id="field-nomor-surat">
                                <label class="form-label fw-bold small">
                                    Nomor Surat <span class="text-danger" id="nomorRequired">*</span>
                                </label>
                                <div class="position-relative">
                                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control pe-5"
                                        placeholder="Contoh: 123/IT/2025" value="{{ old('nomor_surat') }}">
                                    <div id="nomorIcon" class="position-absolute top-50 end-0 translate-middle-y me-3">
                                    </div>
                                </div>
                                <small id="nomorFeedback" class="text-muted">
                                    Wajib untuk Surat Masuk & Keluar, opsional untuk Laporan
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Perihal<span class="text-danger">*</span></label>
                                <input type="text" name="perihal" class="form-control"
                                    placeholder="Contoh: Undangan Rapat Koordinasi" value="{{ old('perihal') }}" required>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Tanggal Arsip <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_arsip" class="form-control bg-light border-0 py-2"
                                        value="{{ old('tanggal_arsip', date('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-2" id="submitBtn">
                                <i class="feather-archive me-2"></i> Arsipkan Sekarang
                            </button>
                            <button type="reset" class="btn btn-light w-100 py-2 fw-bold text-muted"
                                onclick="resetForm()">Bersihkan Form</button>

                            <div class="mt-4 p-3 bg-light rounded-3 border-start border-primary border-4">
                                <div class="d-flex">
                                    <i class="feather-info text-primary me-2"></i>
                                    <p class="mb-0 small text-muted">
                                        <strong>Catatan:</strong> Pastikan dokumen sesuai kategori surat yang dipilih. Kode
                                        arsip digenerate otomatis.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ✅ Toast Container --}}
    <div id="toastNotif" class="toast-notif">
        <span class="toast-icon"></span>
        <span class="toast-message"></span>
        <button class="toast-close">&times;</button>
    </div>
@endsection

@push('scripts')

    <style>
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

        .toast-error {
            border-color: #dc3545;
            background-color: #fdecea;
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
        document.addEventListener('DOMContentLoaded', function () {
            let selectedFiles = [];
            let nomorValid = false;
            let typingTimer;
            const delay = 500;

            const kategori = document.getElementById('kategori');
            const nomorInput = document.getElementById('nomor_surat');
            const nomorIcon = document.getElementById('nomorIcon');
            const nomorFeedback = document.getElementById('nomorFeedback');
            const perihal = document.querySelector('input[name="perihal"]');
            const tanggal = document.querySelector('input[name="tanggal_arsip"]');
            let fileInput = document.getElementById('fileInput');
            const dropZone = document.getElementById('dropZone');
            const fileList = document.getElementById('fileList');
            const fileListContainer = document.getElementById('fileListContainer');
            const fileCount = document.getElementById('fileCount');
            const submitBtn = document.getElementById('submitBtn');
            const nomorRequired = document.getElementById('nomorRequired');

            function toggleNomorSurat() {
                if (kategori.value === 'Laporan') {
                    nomorInput.removeAttribute('required');
                    nomorRequired.style.display = 'none';
                } else {
                    nomorInput.setAttribute('required', 'required');
                    nomorRequired.style.display = 'inline';
                }
            }

            function validateForm() {
                let valid = true;
                if (!kategori.value) valid = false;
                if (!perihal.value.trim()) valid = false;
                if (!tanggal.value) valid = false;
                if (kategori.value !== 'Laporan') {
                    if (!nomorValid) valid = false;
                } else if (nomorInput.value.trim() && !nomorValid) valid = false;
                if (selectedFiles.length === 0) valid = false;
                submitBtn.disabled = !valid;
            }

            nomorInput.addEventListener('input', function () {
                clearTimeout(typingTimer);
                const value = this.value.trim();
                nomorInput.classList.remove('is-valid', 'is-invalid');
                nomorIcon.innerHTML = '';
                nomorValid = false;
                if (!value) {
                    nomorFeedback.className = 'text-muted';
                    nomorFeedback.innerText = 'Wajib untuk Surat Masuk & Keluar, opsional untuk Laporan';
                    validateForm();
                    return;
                }

                nomorIcon.innerHTML = '<div class="spinner-border spinner-border-sm text-secondary"></div>';
                typingTimer = setTimeout(() => {
                    fetch(`/arsip/check-nomor?nomor=${encodeURIComponent(value)}`)
                        .then(res => res.json())
                        .then(data => {
                            nomorIcon.innerHTML = '';
                            if (data.exists) {
                                nomorInput.classList.add('is-invalid');
                                nomorFeedback.className = 'text-danger';
                                nomorFeedback.innerText = 'Nomor surat sudah ada';
                                nomorValid = false;
                            } else {
                                nomorInput.classList.add('is-valid');
                                nomorFeedback.className = 'text-success';
                                nomorFeedback.innerText = 'Nomor tersedia';
                                nomorValid = true;
                            }
                            validateForm();
                        })
                        .catch(() => {
                            nomorIcon.innerHTML = '';
                            nomorFeedback.className = 'text-muted';
                            nomorFeedback.innerText = 'Gagal memeriksa nomor';
                            nomorValid = false;
                            validateForm();
                        });
                }, delay);
            });

            dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-primary'); });
            dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-primary'));
            dropZone.addEventListener('drop', e => { e.preventDefault(); dropZone.classList.remove('border-primary'); handleFiles(e.dataTransfer.files); });
            fileInput.addEventListener('change', e => handleFiles(e.target.files));

            function handleFiles(files) {
                const MAX_SIZE = 20 * 1024 * 1024;
                const ALLOWED = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'tiff'];
                let hasError = false;
                const validFiles = [];

                for (let file of files) {
                    const ext = (file.name.split('.').pop() || '').toLowerCase();
                    if (!ALLOWED.includes(ext)) { showToast(`Format file ${file.name} tidak diizinkan.`, 'error'); hasError = true; continue; }
                    if (file.size > MAX_SIZE) { showToast(`Ukuran file ${file.name} melebihi 20MB.`, 'error'); hasError = true; continue; }
                    const exists = selectedFiles.some(f => f.name === file.name && f.size === file.size);
                    if (!exists) validFiles.push(file);
                }

                if (validFiles.length > 0) selectedFiles = [...selectedFiles, ...validFiles];
                if (hasError && validFiles.length === 0) fileInput.value = '';
                syncInputFiles();
                updateFileList();
                validateForm();
            }

            function syncInputFiles() {
                const newInput = fileInput.cloneNode();
                fileInput.parentNode.replaceChild(newInput, fileInput);
                newInput.addEventListener('change', e => handleFiles(e.target.files));
                fileInput = newInput;
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
                window.removeFile = removeFile; // Rebind agar tombol close tetap aktif
            }

            function updateFileList() {
                fileList.innerHTML = '';
                fileCount.textContent = selectedFiles.length;
                fileListContainer.style.display = selectedFiles.length ? 'block' : 'none';
                selectedFiles.forEach((file, index) => {
                    const size = file.size > 1024 * 1024
                        ? (file.size / 1024 / 1024).toFixed(2) + ' MB'
                        : (file.size / 1024).toFixed(2) + ' KB';
                    fileList.innerHTML += `
                                <div class="list-group-item rounded-3 border p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold small">${file.name}</span>
                                        <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="removeFile(${index})">✖</button>
                                    </div>
                                    <small class="text-muted">${size}</small>
                                </div>`;
                });
            }

            function removeFile(index) {
                selectedFiles.splice(index, 1);
                syncInputFiles();
                updateFileList();
                validateForm();
            }

            window.removeFile = removeFile;

            kategori.addEventListener('change', () => { toggleNomorSurat(); validateForm(); });
            perihal.addEventListener('input', validateForm);
            tanggal.addEventListener('change', validateForm);

            toggleNomorSurat();
            validateForm();
        });

        function showToast(msg, type = 'success') {
            const toast = document.getElementById('toastNotif');
            toast.querySelector('.toast-message').textContent = msg;
            toast.querySelector('.toast-icon').innerHTML = type === 'error'
                ? '<i class="feather-x-circle text-danger"></i>'
                : '<i class="feather-check-circle text-success"></i>';
            toast.className = `toast-notif toast-${type} show`;
            clearTimeout(window.toastTimer);
            window.toastTimer = setTimeout(() => hideToast(), 3000);
        }

        function hideToast() {
            document.getElementById('toastNotif').classList.remove('show');
        }
    </script>
@endpush