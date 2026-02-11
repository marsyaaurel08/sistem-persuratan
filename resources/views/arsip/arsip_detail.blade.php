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
                                    data-ids='@json([$arsip->id])'
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
                    data-bs-toggle="modal" 
                    data-bs-target="#previewModal"
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

@push('modals')
<!-- Modal Preview -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    
    <!-- Tombol Close Floating di Luar Modal Content -->
    <button 
        type="button" 
        onclick="
            const m = document.getElementById('previewModal');
            const f = document.getElementById('previewFrame');
            m.classList.remove('show');
            m.style.display = 'none';
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
            const bd = document.querySelectorAll('.modal-backdrop');
            bd.forEach(b => b.remove());
            if(f) f.src = 'about:blank';
        "
        style="
            position: fixed;
            top: 50px;
            right: 50px;
            z-index: 99999;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background: #dc3545;
            color: white;
            font-size: 28px;
            font-weight: bold;
            line-height: 1;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        "
        onmouseover="this.style.transform='scale(1.1)'"
        onmouseout="this.style.transform='scale(1)'"
        >
        ×
    </button>

    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header border-bottom">
                <h5 class="modal-title">Preview Dokumen</h5>
            </div>
            
            <div class="modal-body p-0" style="background: #f8f9fa;">
                <iframe src="" frameborder="0" width="100%" height="600px" id="previewFrame" style="display: block;"></iframe>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="
                    const m = document.getElementById('previewModal');
                    const f = document.getElementById('previewFrame');
                    m.classList.remove('show');
                    m.style.display = 'none';
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    const bd = document.querySelectorAll('.modal-backdrop');
                    bd.forEach(b => b.remove());
                    if(f) f.src = 'about:blank';
                ">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // === MODAL PREVIEW ===
            const iframe = document.getElementById('previewFrame');
            const modalEl = document.getElementById('previewModal');

            // Handler tombol preview
            document.querySelectorAll('.preview-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    const fileUrl = this.dataset.file;
                    if (!fileUrl) return;

                    const ext = fileUrl.split('.').pop().toLowerCase();
                    const allowed = ['pdf', 'jpg', 'jpeg', 'png'];

                    if (!allowed.includes(ext)) {
                        alert('File ini tidak bisa dipratinjau');
                        e.stopPropagation();
                        return;
                    }

                    if(iframe) iframe.src = fileUrl;
                });
            });

            // Reset iframe saat modal ditutup
            if (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    if(iframe) iframe.src = 'about:blank';
                });
            }

            // === DOWNLOAD SEMUA ===
            const btn = document.getElementById('downloadAll');
            if (btn) {
                const spinner = btn.querySelector('.spinner-border');
                const btnText = btn.querySelector('.btn-text');

                btn.addEventListener('click', function () {
                    const ids = JSON.parse(this.dataset.ids);

                    if (!ids || !ids.length) {
                        alert('Tidak ada file untuk diunduh');
                        return;
                    }

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
                        console.log('Response status:', res.status);
                        
                        if (!res.ok) {
                            return res.text().then(text => {
                                console.error('Error response:', text);
                                throw new Error('Server error: ' + res.status);
                            });
                        }

                        const disposition = res.headers.get('Content-Disposition');
                        let filename = 'arsip_{{ now()->format("Ymd_His") }}.zip';

                        if (disposition && disposition.includes('filename=')) {
                            const matches = disposition.match(/filename="?(.+?)"?$/);
                            if (matches && matches[1]) {
                                filename = matches[1];
                            }
                        }

                        return res.blob().then(blob => {
                            console.log('Blob size:', blob.size);
                            if (blob.size === 0) {
                                throw new Error('File kosong');
                            }
                            return { blob, filename };
                        });
                    })
                    .then(({ blob, filename }) => {
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = filename;
                        document.body.appendChild(a);
                        a.click();
                        
                        setTimeout(() => {
                            a.remove();
                            URL.revokeObjectURL(url);
                        }, 100);
                        
                        console.log('Download started:', filename);
                    })
                    .catch(err => {
                        console.error('Download error:', err);
                        alert('Gagal mengunduh: ' + err.message);
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btnText.innerHTML = '<i class="feather-download me-1"></i> Download Semua';
                        spinner.classList.add('d-none');
                    });
                });
            }
        });
    </script>
@endpush