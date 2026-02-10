@extends('layout.app')

@section('title', 'Detail Arsip')

@section('content')
    <div class="main-content">
        <div class="page-header d-flex align-items-center justify-content-between mb-4 pb-2 rounded">
            <div class="page-header-left">
                <a href="{{ route('arsip.index') }}"
                    class="d-flex align-items-center text-dark fw-bold text-decoration-none">
                    <div class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width:35px;height:35px;border:1px solid #eee;">
                        <i class="feather-arrow-left text-primary"></i>
                    </div>
                    <span style="font-size:large">Detail Arsip</span>
                </a>
            </div>
        </div>

        <div class="row">
            {{-- INFO ARSIP --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 sticky-top" style="top:20px">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Informasi Arsip</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Kategori</label>
                            <input class="form-control" value="Surat {{ $arsip->kategori }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nomor Surat</label>
                            <input class="form-control" value="{{ $arsip->nomor_surat ?? '-' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Perihal</label>
                            <input class="form-control" value="{{ $arsip->perihal }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Tanggal Arsip</label>
                            <input class="form-control" value="{{ $arsip->tanggal_arsip?->format('d M Y') }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Pengarsip</label>
                            <input class="form-control" value="{{ $arsip->pengarsip->name ?? '-' }}" disabled>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FILE ARSIP --}}
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h5 class="fw-bold mb-0">Lampiran Dokumen</h5>
                                <small class="text-muted">
                                    {{ $arsip->files->count() }} file terlampir
                                </small>
                            </div>

                            @if ($arsip->files->count())
                                <button
                                    type="button"
                                    id="downloadAll"
                                    class="btn btn-primary rounded-pill"
                                    data-ids='@json($arsip->files->pluck("id"))'
                                >
                                    <span class="btn-text">
                                        <i class="feather-download me-1"></i> Download Semua
                                    </span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            @endif

                        </div>

                        <div class="list-group list-group-flush">
                            @foreach ($arsip->files as $file)
    @php
        $ext = strtolower(pathinfo($file->nama_file, PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg','jpeg','png'])) {
            $icon = 'feather-image text-success';
        } elseif ($ext === 'pdf') {
            $icon = 'feather-file-text text-danger';
        } elseif (in_array($ext, ['doc','docx'])) {
            $icon = 'feather-file text-primary';
        } else {
            $icon = 'feather-paperclip text-secondary';
        }
    @endphp

    <div class="border rounded-3 p-3 mb-2">
        <div class="d-flex align-items-center gap-3">

            {{-- ICON FILE --}}
            <div class="flex-shrink-0">
                <i class="{{ $icon }} fs-3"></i>
            </div>

            {{-- INFO FILE --}}
            <div class="flex-grow-1">
                <div class="fw-semibold small">
                    {{ $file->nama_file }}
                </div>
                <div class="text-muted" style="font-size: 11px">
                    {{ number_format($file->size / 1024, 1) }} KB
                </div>
            </div>

            {{-- ACTION --}}
            <div class="d-flex gap-2">
                <button
                    type="button"
                    class="btn btn-sm btn-outline-success preview-btn"
                    data-file="{{ asset('storage/' . $file->path_file) }}">
                    <i class="feather-eye"></i>
                </button>
                <a 
                    href="{{ route('arsip.download', $file->id) }}"
                    class="btn btn-sm btn-outline-primary"
                    download="">
                    <i class="feather-download"></i>
                </a>
            </div>

        </div>
    </div>
@endforeach

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" width="100%" height="600px" id="previewFrame"></iframe>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const fileInput = document.getElementById('fileInput');
            const dropZone = document.getElementById('dropZone');
            const fileList = document.getElementById('fileList');
            const fileListContainer = document.getElementById('fileListContainer');
            const fileCount = document.getElementById('fileCount');
            const submitBtn = document.getElementById('submitBtn');
            const uploadForm = document.getElementById('uploadForm');

            // 👉 Jika halaman ini bukan halaman upload, hentikan script
            if (!fileInput || !uploadForm) return;

            let selectedFiles = [];

            /* ===============================
               FILE INPUT & DRAG DROP
            =============================== */
            fileInput.addEventListener('change', e => {
                handleFiles(e.target.files);
            });

            if (dropZone) {
                dropZone.addEventListener('dragover', e => {
                    e.preventDefault();
                    dropZone.classList.add('border-primary');
                });

                dropZone.addEventListener('dragleave', () => {
                    dropZone.classList.remove('border-primary');
                });

                dropZone.addEventListener('drop', e => {
                    e.preventDefault();
                    dropZone.classList.remove('border-primary');
                    handleFiles(e.dataTransfer.files);
                });
            }

            function handleFiles(files) {
                for (const file of files) {
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
                const dt = new DataTransfer();
                selectedFiles.forEach(file => dt.items.add(file));
                fileInput.files = dt.files;
            }

            function updateFileList() {
                if (!fileList || !fileListContainer || !submitBtn) return;

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
                    item.className = 'list-group-item border rounded p-3';

                    item.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">${file.name}</div>
                                    <small class="text-muted">${formatFileSize(file.size)}</small>
                                </div>
                                <button type="button"
                                    class="btn btn-sm btn-link text-danger"
                                    onclick="window.removeFile(${index})">
                                    <i class="feather-x"></i>
                                </button>
                            </div>
                        `;

                    fileList.appendChild(item);
                });
            }

            window.removeFile = function (index) {
                selectedFiles.splice(index, 1);
                syncInputFiles();
                updateFileList();
            };

            function formatFileSize(bytes) {
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(1024));
                return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
            }

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const iframe = document.getElementById('previewFrame');
            const modalEl = document.getElementById('previewModal');
            const modal = new bootstrap.Modal(modalEl);

            document.querySelectorAll('.preview-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const fileUrl = this.dataset.file;
                    const ext = fileUrl.split('.').pop().toLowerCase();

                    // hanya preview PDF & image
                    const allowed = ['pdf', 'jpg', 'jpeg', 'png'];

                    if (!allowed.includes(ext)) {
                        alert('File ini tidak bisa dipratinjau');
                        return;
                    }

                    iframe.src = fileUrl;
                    modal.show();
                });
            });

            modalEl.addEventListener('hidden.bs.modal', function () {
                iframe.src = '';
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('downloadAll');
        if (!btn) return;

        const spinner = btn.querySelector('.spinner-border');
        const btnText = btn.querySelector('.btn-text');

        btn.addEventListener('click', function () {
            const ids = JSON.parse(this.dataset.ids);

            if (!ids.length) return;

            btn.disabled = true;
            btnText.textContent = 'Menyiapkan ZIP...';
            spinner.classList.remove('d-none');

            fetch("{{ route('arsip.bulkDownload') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ids })
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal mengunduh');

                const disposition = res.headers.get('Content-Disposition');
                let filename = 'arsip.zip';

                if (disposition && disposition.includes('filename=')) {
                    filename = disposition.split('filename=')[1].replace(/"/g, '');
                }

                return res.blob().then(blob => ({ blob, filename }));
            })
            .then(({ blob, filename }) => {
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            })
            .catch(err => alert(err.message))
            .finally(() => {
                btn.disabled = false;
                btnText.innerHTML = '<i class="feather-download me-1"></i> Download Semua';
                spinner.classList.add('d-none');
            });
        });
    });
</script>


@endpush