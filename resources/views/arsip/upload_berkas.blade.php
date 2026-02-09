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
                                <div class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 35px; height: 35px; border: 1px solid #eee;">
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
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle mb-3">
                                        <i class="feather-upload-cloud" style="color: white"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">Pilih file atau drag and drop di sini</h5>
                                    <p class="text-muted small">
                                        Format: PDF, DOCX, JPG, TIFF (Maks 50MB per file)
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

                            <!-- KATEGORI ARSIP -->
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

                            <!-- NOMOR SURAT -->
                            <div class="mb-3" id="field-nomor-surat">
                                <label class="form-label fw-bold small">Nomor Surat<span
                                            class="text-danger">*</span></label>
                                <input type="text" name="nomor_surat" class="form-control" placeholder="Contoh: 123/IT/2025"
                                    value="{{ old('nomor_surat') }}" required>
                                <small class="text-muted">
                                    Wajib untuk Surat Masuk & Keluar, opsional untuk Laporan
                                </small>
                            </div>

                            <!-- PERIHAL -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Perihal<span
                                            class="text-danger">*</span></label>
                                <input type="text" name="perihal" class="form-control"
                                    placeholder="Contoh: Undangan Rapat Koordinasi" value="{{ old('perihal') }}" required>
                            </div>


                            {{-- <!-- DIVISI (FILTER) -->
                            <div class="mb-3 d-none" id="divisiWrapper">
                                <label class="form-label fw-bold small">Divisi *</label>
                                <select id="divisiSelect" class="form-select">
                                    <option value="">-- Pilih Divisi --</option>
                                </select>
                                <input type="hidden" name="divisi" id="divisiValue" />
                            </div>

                            <!-- SURAT MASUK -->
                            <div class="mb-3 d-none" id="suratMasukWrapper">
                                <label class="form-label fw-bold small">Surat Masuk *</label>
                                <select name="surat_masuk_id" id="suratMasukSelect" class="form-select">
                                    <option value="">-- Pilih Surat Masuk --</option>
                                    @foreach ($suratMasuk as $sm)
                                    <option value="{{ $sm->id }}" data-divisi="{{ $sm->penerima_divisi }}">
                                        {{ $sm->nomor_surat }} - {{ $sm->penerima_divisi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- SURAT KELUAR -->
                            <div class="mb-3 d-none" id="suratKeluarWrapper">
                                <label class="form-label fw-bold small">Surat Keluar *</label>
                                <select name="surat_keluar_id" id="suratKeluarSelect" class="form-select">
                                    <option value="">-- Pilih Surat Keluar --</option>
                                    @foreach ($suratKeluar as $sk)
                                    <option value="{{ $sk->id }}" data-divisi="{{ $sk->pengirim_divisi }}">
                                        {{ $sk->nomor_surat }} - {{ $sk->pengirim_divisi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="row g-3 mb-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Tanggal Arsip <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_arsip" class="form-control bg-light border-0 py-2"
                                        value="{{ old('tanggal_arsip', date('Y-m-d')) }}" required>
                                </div>

                                {{-- <div class="col-12">
                                    <label class="form-label fw-bold small">Nama Pengarsip</label>
                                    <input type="text" name="diarsipkan_nama" class="form-control bg-light border-0 py-2"
                                        placeholder="Nama pengarsip" value="{{ old('diarsipkan_nama') }}">
                                    <small class="text-muted">Opsional: Nama orang yang mengarsipkan</small>
                                </div> --}}

                                {{-- <div class="col-12">
                                    <label class="form-label fw-bold small">Lokasi Fisik</label>
                                    <input type="text" name="lokasi_fisik" class="form-control bg-light border-0 py-2"
                                        placeholder="Contoh: Lemari A / Rak 2 / Box 5" value="{{ old('lokasi_fisik') }}">
                                    <small class="text-muted">Opsional: Lokasi penyimpanan fisik dokumen</small>
                                </div> --}}
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-2" id="submitBtn" disabled>
                                <i class="feather-archive me-2"></i> Arsipkan Sekarang
                            </button>
                            <button type="reset" class="btn btn-light w-100 py-2 fw-bold text-muted" onclick="resetForm()">
                                Bersihkan Form
                            </button>

                            <div class="mt-4 p-3 bg-light rounded-3 border-start border-primary border-4">
                                <div class="d-flex">
                                    <i class="feather-info text-primary me-2"></i>
                                    <p class="mb-0 small text-muted">
                                        <strong>Catatan:</strong> Pastikan dokumen yang diarsipkan sesuai dengan surat yang
                                        dipilih.
                                        Kode arsip akan digenerate otomatis.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        let selectedFiles = [];

        const kategori = document.getElementById('kategori');
        const nomorSuratWrapper = document.getElementById('field-nomor-surat');

        const fileInput = document.getElementById('fileInput');
        const dropZone = document.getElementById('dropZone');
        const fileList = document.getElementById('fileList');
        const fileListContainer = document.getElementById('fileListContainer');
        const fileCount = document.getElementById('fileCount');
        const submitBtn = document.getElementById('submitBtn');
        const uploadForm = document.getElementById('uploadForm');

        /* ===============================
           KATEGORI → TOGGLE NOMOR SURAT
        =============================== */
        function toggleNomorSurat() {
            if (kategori.value === 'Laporan') {
                nomorSuratWrapper.style.display = 'none';
            } else {
                nomorSuratWrapper.style.display = 'block';
            }
        }

        if (kategori) {
            kategori.addEventListener('change', toggleNomorSurat);
            toggleNomorSurat(); // initial
        }

        /* ===============================
           FILE INPUT
        =============================== */
        fileInput.addEventListener('change', e => {
            handleFiles(e.target.files);
        });

        dropZone.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.classList.add('border-primary');
        });

        dropZone.addEventListener('dragleave', e => {
            e.preventDefault();
            dropZone.classList.remove('border-primary');
        });

        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('border-primary');
            handleFiles(e.dataTransfer.files);
        });

        function handleFiles(files) {
            for (let file of files) {
                if (isValidFile(file)) {
                    selectedFiles.push(file);
                }
            }

            syncInputFiles();
            updateFileList();
        }

        function isValidFile(file) {
            const validTypes = [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'image/jpeg',
                'image/png',
                'image/tiff'
            ];

            const maxSize = 50 * 1024 * 1024;

            if (!validTypes.includes(file.type)) {
                alert(`${file.name} bukan format yang didukung`);
                return false;
            }

            if (file.size > maxSize) {
                alert(`${file.name} melebihi 50MB`);
                return false;
            }

            return true;
        }

        function syncInputFiles() {
            try {
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            } catch (e) { }
        }

        function getFileIcon(type) {
            if (!type) return 'feather-file text-secondary';

            if (type.includes('pdf')) return 'feather-file-text text-danger';
            if (type.includes('word')) return 'feather-file-text text-primary';
            if (type.includes('image')) return 'feather-image text-success';

            return 'feather-file text-secondary';
        }

        function formatFileSize(bytes) {
            if (!bytes) return '0 Bytes';

            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return (bytes / Math.pow(k, i)).toFixed(2) + ' ' + sizes[i];
        }


        function updateFileList() {
            fileList.innerHTML = '';
            fileCount.textContent = selectedFiles.length;

            if (selectedFiles.length === 0) {
                fileListContainer.style.display = 'none';
                submitBtn.disabled = true;
                return;
            }

            fileListContainer.style.display = 'block';
            submitBtn.disabled = false;

            selectedFiles.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'list-group-item rounded-3 border p-3';

                const icon = getFileIcon(file.type);
                const size = formatFileSize(file.size);

                item.innerHTML = `
                        <div class="d-flex align-items-center">
                            <i class="${icon} fs-4 me-3"></i>

                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <span class="fw-bold text-dark small">
                                        ${file.name}
                                    </span>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-link text-danger p-0"
                                        onclick="removeFile(${index})">
                                        <i class="feather-x"></i>
                                    </button>
                                </div>

                                <span class="text-muted" style="font-size: 11px;">
                                    ${size}
                                </span>
                            </div>
                        </div>
                    `;

                fileList.appendChild(item);
            });
        }


        function removeFile(index) {
            selectedFiles.splice(index, 1);
            syncInputFiles();
            updateFileList();
        }

        function formatFileSize(bytes) {
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            if (bytes === 0) return '0 Byte';
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }

        /* ===============================
           DEBUG SUBMIT
        =============================== */
        uploadForm.addEventListener('submit', () => {
            console.log('Kategori:', kategori.value);
            console.log('Files:', selectedFiles.length);
        });
    </script>
@endpush