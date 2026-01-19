@extends('layout.app')

@section('title', 'Form Surat Baru')

@section('content')
    <div class="main-content">
        <div class="page-header d-flex align-items-center justify-content-between mb-4 pb-2 rounded">
            <div class="page-header-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url()->previous() }}"
                                class="d-flex align-items-center text-dark fw-bold decoration-none">
                                <div class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 35px; height: 35px; border: 1px solid #eee;">
                                    <i class="feather-arrow-left text-primary"></i>
                                </div>
                                <span style="font-size: large; letter-spacing: -0.5px;">Form Surat Baru</span>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7">
                <div class="card stretch stretch-full shadow-sm">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="feather-file-plus me-2"></i>Informasi Surat
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Row 1: Nomor Surat & Kategori -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fw-bold text-muted"
                                        style="font-size: 11px; letter-spacing: 0.5px;">
                                        <i class="feather-hash me-1"></i>Nomor Surat
                                    </label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Contoh : PJT/0927/273" style="border-radius: 8px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fw-bold text-muted"
                                        style="font-size: 11px; letter-spacing: 0.5px;">
                                        <i class="feather-tag me-1"></i>Kategori
                                    </label>
                                    <select class="form-select form-select-sm" style="border-radius: 8px;">
                                        <option selected disabled>-- Pilih Kategori --</option>
                                        <option>Surat Masuk</option>
                                        <option>Surat Keluar</option>
                                        <option>Surat Internal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 2: Pengirim & Penerima -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fw-bold text-muted"
                                        style="font-size: 11px; letter-spacing: 0.5px;">
                                        <i class="feather-user me-1"></i>Pengirim / Sumber
                                    </label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Contoh : Direktur Keuangan"
                                        style="border-radius: 8px; font-size: small;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fw-bold text-muted"
                                        style="font-size: 11px; letter-spacing: 0.5px;">
                                        <i class="feather-users me-1"></i>Penerima / Unit
                                    </label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Contoh : Divisi Human Capital"
                                        style="border-radius: 8px; font-size: small;">
                                </div>
                            </div>

                            <!-- Row 3: Tanggal & Perihal -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fw-bold text-muted"
                                        style="font-size: 11px; letter-spacing: 0.5px;">
                                        <i class="feather-calendar me-1"></i>Tanggal
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" id="single-datepicker"
                                            placeholder="01 / 01 / 2026"
                                            style="border-radius: 8px 0 0 8px; font-size: small;">
                                        <span class="input-group-text" style="border-radius: 0 8px 8px 0;"><i
                                                class="feather-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase fw-bold text-muted"
                                        style="font-size: 11px; letter-spacing: 0.5px;">
                                        <i class="feather-message-square me-1"></i>Perihal
                                    </label>
                                    <input type="text" class="form-control form-control-sm"
                                        placeholder="Contoh : Permohonan Workshop"
                                        style="border-radius: 8px; font-size: small;">
                                </div>
                            </div>

                            <!-- Upload Area -->
                            <div class="mb-4">
                                <label class="form-label text-uppercase fw-bold text-muted"
                                    style="font-size: 11px; letter-spacing: 0.5px;">
                                    <i class="feather-upload me-1"></i>Unggah Berkas
                                </label>
                                <div class="border-dashed border-2 p-4 text-center rounded-3 position-relative"
                                    style="border-style: dashed; border-color: #dee2e6; background: linear-gradient(135deg, #fdfdfd 0%, #f8f9fa 100%); min-height: 120px; cursor: pointer; transition: all 0.3s ease;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%)'"
                                    onmouseout="this.style.background='linear-gradient(135deg, #fdfdfd 0%, #f8f9fa 100%)'">
                                    <input type="file" class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                        style="cursor: pointer;" accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                        <i class="feather-upload-cloud display-4 text-primary mb-2"></i>
                                        <p class="fw-semibold text-dark mb-1" style="font-size: small;">Upload berkas surat
                                        </p>
                                        <small class="text-muted" style="font-size: small;">Ukuran maksimal 5MB • Format:
                                            PDF, JPG, PNG</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                <button type="button" class="btn btn-outline-secondary btn-sm px-4"
                                    style="border-radius: 8px;">
                                    <i class="feather-save me-2"></i>Simpan Draft
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm px-4"
                                    style="background-color: #000c4d; border-radius: 8px;">
                                    <i class="feather-send me-2"></i>Kirim Surat
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card stretch stretch-full shadow-sm">
                    <div class="card-header bg-white border-bottom-0">
                        <h5 class="card-title mb-0 text-primary">
                            <i class="feather-eye me-2"></i>Pratinjau File
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- File Info -->
                        <div class="alert alert-light border d-flex align-items-center mb-4" style="border-radius: 8px;">
                            <i class="feather-file-text me-3 text-primary fs-4"></i>
                            <div class="flex-grow-1">
                                <span class="text-muted small">Belum ada file yang dipilih</span>
                            </div>
                        </div>

                        <!-- Preview Area -->
                        <div class="bg-light rounded-3 d-flex flex-column align-items-center justify-content-center position-relative overflow-hidden"
                            style="min-height: 400px; border: 1px solid #e9ecef;">
                            <div class="text-center">
                                <i class="feather-file-text display-1 text-light-dark mb-3" style="opacity: 0.3;"></i>
                                <h6 class="text-muted mb-2">Pratinjau Dokumen</h6>
                                <p class="text-sm text-muted mb-0">Upload file untuk melihat pratinjau</p>
                            </div>

                            <!-- Upload Progress (Hidden by default) -->
                            <div class="upload-progress w-100 px-4" style="display: none;">
                                <div class="progress mb-2" style="height: 6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="text-muted">Mengupload file...</small>
                            </div>
                        </div>

                        <!-- File Actions -->
                        <div class="d-flex gap-2 mt-3" id="file-actions" style="display: none;">
                            <button class="btn btn-outline-primary btn-sm flex-fill" style="border-radius: 6px;">
                                <i class="feather-download me-1"></i>Download
                            </button>
                            <button class="btn btn-outline-danger btn-sm flex-fill" style="border-radius: 6px;">
                                <i class="feather-trash-2 me-1"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary mb-0"><i class="feather-lock me-2"></i>Hak Akses Dokumen</h6>
                    <button class="btn btn-sm btn-dark" style="background-color: #000c4d;">
                        <i class="feather-plus me-1"></i>Tambah User
                    </button>
                </div>
                <div class="card-body">
                    <!-- User Cards Horizontal -->
                    <div class="row g-3">
                        <!-- User 1 -->
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px; font-weight: bold;">
                                        KF
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Keysha Arindra F</h6>
                                        <small class="text-primary">Mahasiswa Magang</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge-custom badge-success" style="font-size: small">Read</span>
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus akses">
                                        <i class="feather-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User 2 -->
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px; font-weight: bold;">
                                        RS
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Rizkya Salsabilla</h6>
                                        <small class="text-primary">Mahasiswa Magang</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge-custom badge-success" style="font-size: small">Read</span>
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus akses">
                                        <i class="feather-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User 3 -->
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px; font-weight: bold;">
                                        MS
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold">Marsya Aurelia S</h6>
                                        <small class="text-primary">Mahasiswa Magang</small>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge-custom badge-warning" style="font-size: small">Read/Write</span>
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus akses">
                                        <i class="feather-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/moment.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('duralux/assets/js/bootstrap.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Initialize Date Picker
            $('#single-datepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD / MM / YYYY',
                    daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                }
            });

            // File Upload Handler
            const fileInput = $('input[type="file"]');
            const uploadArea = $('.border-dashed');
            const fileInfo = $('.alert-light');
            const previewArea = $('.bg-light.rounded-3');
            const fileActions = $('#file-actions');

            uploadArea.on('click', function () {
                fileInput.click();
            });

            fileInput.on('change', function () {
                const file = this.files[0];
                if (file) {
                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file maksimal 5MB');
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file harus PDF, JPG, atau PNG');
                        this.value = '';
                        return;
                    }

                    // Update file info
                    fileInfo.html(`
                        <i class="feather-file-text me-3 text-success fs-4"></i>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-dark">${file.name}</div>
                            <small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB • ${file.type.split('/')[1].toUpperCase()}</small>
                        </div>
                    `);

                    // Show file actions
                    fileActions.show();

                    // Update preview area
                    previewArea.html(`
                        <div class="text-center">
                            <i class="feather-file-text display-1 text-success mb-3"></i>
                            <h6 class="text-dark mb-2">File berhasil dipilih</h6>
                            <p class="text-sm text-muted mb-0">Siap untuk diupload</p>
                        </div>
                    `);

                    // Add drag and drop visual feedback
                    uploadArea.css('border-color', '#28a745');
                    setTimeout(() => {
                        uploadArea.css('border-color', '#dee2e6');
                    }, 1000);
                }
            });

            // Drag and drop functionality
            uploadArea.on('dragover dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('border-primary').css('background', 'linear-gradient(135deg, #e7f3ff 0%, #f8f9fa 100%)');
            });

            uploadArea.on('dragleave dragend', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('border-primary').css('background', 'linear-gradient(135deg, #fdfdfd 0%, #f8f9fa 100%)');
            });

            uploadArea.on('drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('border-primary').css('background', 'linear-gradient(135deg, #fdfdfd 0%, #f8f9fa 100%)');

                const files = e.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    fileInput[0].files = files;
                    fileInput.trigger('change');
                }
            });

            // Add User Modal Handler
            $('.btn-dark').on('click', function () {
                $('#addUserModal').modal('show');
            });

            // User search functionality
            $('#userSearch').on('input', function () {
                const query = $(this).val().toLowerCase();
                if (query.length > 1) {
                    // Mock user data - replace with actual API call
                    const mockUsers = [
                        { id: 1, name: 'Ahmad Rahman', role: 'Staff IT', initials: 'AR' },
                        { id: 2, name: 'Siti Nurhaliza', role: 'Manager HR', initials: 'SN' },
                        { id: 3, name: 'Budi Santoso', role: 'Direktur', initials: 'BS' },
                        { id: 4, name: 'Maya Sari', role: 'Staff Keuangan', initials: 'MS' }
                    ];

                    const filteredUsers = mockUsers.filter(user =>
                        user.name.toLowerCase().includes(query)
                    );

                    if (filteredUsers.length > 0) {
                        let suggestions = '<div class="list-group">';
                        filteredUsers.forEach(user => {
                            suggestions += `
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center select-user" data-user='${JSON.stringify(user)}'>
                                    <div class="avatar-sm bg-light-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-size: 12px; font-weight: bold;">
                                        ${user.initials}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">${user.name}</div>
                                        <small class="text-muted">${user.role}</small>
                                    </div>
                                </a>
                            `;
                        });
                        suggestions += '</div>';
                        $('#userSuggestions').html(suggestions).show();
                    } else {
                        $('#userSuggestions').hide();
                    }
                } else {
                    $('#userSuggestions').hide();
                }
            });

            // Select user from suggestions
            $(document).on('click', '.select-user', function (e) {
                e.preventDefault();
                const user = JSON.parse($(this).attr('data-user'));
                $('#userSearch').val(user.name);
                $('#userSuggestions').hide();
            });

            // Add user button handler
            $('#addUserBtn').on('click', function () {
                const userName = $('#userSearch').val();
                const accessLevel = $('#accessLevel').val();

                if (!userName) {
                    alert('Silakan pilih user terlebih dahulu');
                    return;
                }

                // Generate initials
                const initials = userName.split(' ').map(n => n[0]).join('').toUpperCase();

                // Determine badge color based on access level
                let badgeClass = 'bg-success';
                let badgeText = 'Read';
                if (accessLevel === 'write') {
                    badgeClass = 'bg-warning';
                    badgeText = 'Read/Write';
                } else if (accessLevel === 'admin') {
                    badgeClass = 'bg-danger';
                    badgeText = 'Admin';
                }

                // Add user card
                const userCard = `
                    <div class="col-12 user-access-card">
                        <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-light-secondary text-secondary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                    ${initials}
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold">${userName}</h6>
                                    <small class="text-primary">User</small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="badge ${badgeClass}">${badgeText}</span>
                                <button class="btn btn-sm btn-outline-danger remove-user" title="Hapus akses">
                                    <i class="feather-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;

                $('.row.g-3').append(userCard);
                $('#empty-state').hide();
                $('#addUserModal').modal('hide');

                // Reset form
                $('#userSearch').val('');
                $('#accessLevel').val('read');
            });

            // Remove user handler
            $(document).on('click', '.remove-user', function () {
                if (confirm('Apakah Anda yakin ingin menghapus akses user ini?')) {
                    $(this).closest('.user-access-card').remove();

                    // Show empty state if no users left
                    if ($('.user-access-card').length === 0) {
                        $('#empty-state').show();
                    }
                }
            });

            // Form validation
            $('form').on('submit', function (e) {
                const requiredFields = ['input[placeholder*="Nomor Surat"]', 'select', 'input[placeholder*="Pengirim"]', 'input[placeholder*="Penerima"]', 'input[placeholder*="Tanggal"]', 'input[placeholder*="Perihal"]' style = "border-radius: 8px;  font-size: small;'];"];
                let isValid = true;

                requiredFields.forEach(selector => {
                    const field = $(selector);
                    if (!field.val() || field.val() === '-- Pilih Kategori --') {
                        field.addClass('is-invalid');
                        isValid = false;
                    } else {
                        field.removeClass('is-invalid');
                    }
                });

                if (!fileInput[0].files[0]) {
                    uploadArea.addClass('border-danger');
                    isValid = false;
                } else {
                    uploadArea.removeClass('border-danger');
                }

                if (!isValid) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang diperlukan');
                }
            });
        });
    </script>
@endsection