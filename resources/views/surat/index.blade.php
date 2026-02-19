@extends('layout.app')

@section('title', 'Buat Surat')

@section('content')
    <div class="container">
        <h4 class="mb-4">Buat Surat</h4>

        <form action="{{ route('surat.preview') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ================= KOP SURAT ================= --}}
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    KOP SURAT
                </div>

                <div class="card-body">

                    {{-- Logo --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Logo Kiri</label>
                            <input type="file" name="logo_kiri" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Logo Kanan</label>
                            <input type="file" name="logo_kanan" class="form-control" accept="image/*">
                        </div>
                    </div>

                    {{-- Instansi --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Instansi</label>
                        <input type="text" name="kop_instansi"
                            class="form-control @error('kop_instansi') is-invalid @enderror"
                            value="{{ old('kop_instansi') }}">
                        @error('kop_instansi')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    {{-- Alamat --}}
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="kop_alamat"
                            class="form-control @error('kop_alamat') is-invalid @enderror">{{ old('kop_alamat') }}</textarea>
                        @error('kop_alamat')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>



                    {{-- Kontak --}}
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="kop_telp" class="form-control @error('kop_telp') is-invalid @enderror"
                                value="{{ old('kop_telp') }}">

                            @error('kop_telp')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="kop_email"
                                class="form-control @error('kop_email') is-invalid @enderror"
                                value="{{ old('kop_email') }}">

                            @error('kop_email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-md-4">
                            <label class="form-label">Website</label>
                            <input type="text" name="kop_web" class="form-control @error('kop_web') is-invalid @enderror"
                                value="{{ old('kop_web') }}">
                            @error('kop_web')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>

            {{-- ================= INFO SURAT ================= --}}
            <div class="card mb-4">
                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Nomor Surat</label>
                        <input type="text" name="nomor_surat" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Perihal</label>
                        <input type="text" name="perihal" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Surat</label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>

                </div>
            </div>

            {{-- ================= ISI SURAT ================= --}}
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    ISI SURAT
                </div>
                <div class="card-body">
                    <textarea name="isi_surat" id="isi_surat" class="form-control"></textarea>
                </div>
            </div>

            {{-- ================= BUTTON ================= --}}
            <div class="d-flex justify-content-end">
                <button type="button" id="btnReset" class="btn btn-danger btn-custom">
                    Reset
                </button>
                <span class="mx-2"></span>
                <button type="submit" class="btn btn-primary btn-custom">
                    Berikutnya (Preview)
                </button>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5/tinymce.min.js"></script>

    <script>
        tinymce.init({
            selector: '#isi_surat',
            height: 600,

            menubar: 'file edit view insert format tools table help',

            plugins: `
                                                        advlist autolink lists link image charmap preview anchor
                                                        searchreplace visualblocks code fullscreen
                                                        insertdatetime media table code help wordcount
                                                        pagebreak
                                                    `,

            toolbar: `
                                                        undo redo | blocks | 
                                                        fontfamily fontsize |
                                                        bold italic underline strikethrough |
                                                        alignleft aligncenter alignright alignjustify |
                                                        outdent indent |
                                                        bullist numlist |
                                                        lineheight |
                                                        forecolor backcolor |
                                                        table link image |
                                                        removeformat |
                                                        code fullscreen
                                                    `,

            font_family_formats: `
                                                        Times New Roman=Times New Roman,times;
                                                        Arial=Arial,Helvetica,sans-serif;
                                                        Calibri=Calibri,sans-serif;
                                                        Cambria=Cambria,serif;
                                                    `,

            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 24pt 36pt',

            line_height_formats: '1 1.15 1.5 2 2.5 3',

            content_style: `
                                                        body {
                                                            font-family: "Times New Roman", serif;
                                                            font-size: 12pt;
                                                            padding: 40px;
                                                        }
                                                    `
        });
    </script>

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const inputs = document.querySelectorAll("input, textarea");

            inputs.forEach(function (input) {
                input.addEventListener("input", function () {

                    // Hapus class is-invalid
                    this.classList.remove("is-invalid");

                    // Cari error message terdekat dan hapus
                    let errorDiv = this.parentElement.querySelector(".invalid-feedback");
                    if (errorDiv) {
                        errorDiv.remove();
                    }

                });
            });

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const telp = document.querySelector("input[name='kop_telp']");
            const email = document.querySelector("input[name='kop_email']");
            const web = document.querySelector("input[name='kop_web']");

            const contactFields = [telp, email, web];

            function clearContactErrors() {
                contactFields.forEach(field => {
                    field.classList.remove("is-invalid");

                    let errorDiv = field.parentElement.querySelector(".invalid-feedback");
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                });
            }

            contactFields.forEach(field => {
                field.addEventListener("input", function () {

                    if (telp.value.trim() !== "" ||
                        email.value.trim() !== "" ||
                        web.value.trim() !== "") {

                        clearContactErrors();
                    }

                });
            });

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const resetButton = document.getElementById("btnReset");
            const form = document.querySelector("form");

            resetButton.addEventListener("click", function () {

                // Reset isi form
                form.reset();

                // Hapus class error
                form.querySelectorAll(".is-invalid").forEach(el => {
                    el.classList.remove("is-invalid");
                });

                // Hapus pesan error
                form.querySelectorAll(".invalid-feedback").forEach(el => {
                    el.remove();
                });

            });

        });
    </script>
    <style>
        .btn-custom {
            transition: all 0.15s ease-in-out;
        }

        .btn-custom:active {
            transform: scale(0.95);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2) inset;
        }
    </style>


@endsection