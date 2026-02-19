<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Preview Surat</title>

    <style>
        body,
        div,
        p,
        span {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        .header {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }

        .header img.logo-left {
            position: absolute;
            top: 0;
            left: 0;
            width: auto;
            height: 65px;
        }

        .header img.logo-right {
            position: absolute;
            top: 0;
            right: 0;
            width: auto;
            height: 55px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .subtitle {
            font-size: 12px;
            margin-top: 2px;
        }

        .contact {
            font-size: 12px;
            margin-top: 2px;
        }

        .line-bold {
            border-top: 3px solid #000;
            margin-top: 12px;
        }

        .line-thin {
            border-top: 1px solid #000;
            margin-top: 2px;
            margin-bottom: 12px;
        }

        .info-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .info-surat p {
            margin: 2px 0;
            font-size: 12px;
        }

        .isi-surat {
            margin-top: 10px;
            line-height: 1.6;
            text-align: justify;
        }
    </style>
</head>

<body>

    {{-- ================= HEADER / KOP ================= --}}
    <div class="header">

        {{-- Logo kiri --}}
        @if (!empty($logo_kiri))
            <img class="logo-left"
                src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logo_kiri))) }}">
        @endif

        {{-- Logo kanan --}}
        @if (!empty($logo_kanan))
            <img class="logo-right"
                src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $logo_kanan))) }}">
        @endif

        <div class="title">
            {{ $kop_instansi }}
        </div>

        <div class="subtitle">
            {{ $kop_alamat }}
        </div>

        @php
            $contacts = array_filter([
                !empty($kop_telp) ? 'Telp: ' . $kop_telp : null,
                !empty($kop_email) ? 'Email: ' . $kop_email : null,
                !empty($kop_web) ? 'Web: ' . $kop_web : null,
            ]);
        @endphp

        @if(count($contacts))
            <div class="contact">
                {{ implode(' | ', $contacts) }}
            </div>
        @endif

        <div class="line-bold"></div>
        <div class="line-thin"></div>

    </div>

    {{-- ================= INFO SURAT ================= --}}
    @if(!empty($nomor_surat) || !empty($perihal))
        <div class="info-surat">
            @if(!empty($nomor_surat))
                <p><strong>Nomor :</strong> {{ $nomor_surat }}</p>
            @endif

            @if(!empty($perihal))
                <p><strong>Perihal :</strong> {{ $perihal }}</p>
            @endif
        </div>
    @endif


    {{-- ================= ISI SURAT ================= --}}
    <div class="isi-surat">
        {!! $isi_surat !!}
    </div>

</body>

</html>