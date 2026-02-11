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
                    <input type="text" name="kop_instansi" class="form-control" required>
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea name="kop_alamat" class="form-control" rows="2" required></textarea>
                </div>

                {{-- Kontak --}}
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="kop_telp" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="kop_email" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Website</label>
                        <input type="text" name="kop_web" class="form-control" placeholder="www.example.com">
                    </div>
                </div>

            </div>
        </div>

        {{-- ================= INFO SURAT ================= --}}
        <div class="card mb-4">
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Perihal</label>
                    <input type="text" name="perihal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Surat</label>
                    <input type="date" name="tanggal" class="form-control" required>
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
            <button type="submit" class="btn btn-primary">
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
@endsection
