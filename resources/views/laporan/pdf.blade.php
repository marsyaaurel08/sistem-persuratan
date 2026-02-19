<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Persuratan Klinik Jasa Tirta</title>
    <style>
        /* Gunakan Times New Roman untuk seluruh PDF */
        body,
        table,
        th,
        td,
        div {
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
            width: 50px;
            height: auto;
        }

        .header img.logo-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 50px;
            height: auto;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 14px;
            font-weight: bold;
        }

        .period {
            font-size: 12px;
            margin-top: 4px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body>

    <div class="header">
        <!-- Logo kiri-kanan -->
        <img class="logo-left"
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/logo-bumn-terbaru.png'))) }}"
            alt="Logo BUMN">
        <img class="logo-right"
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/images/logo-pjt1.png'))) }}"
            alt="Logo Jasa Tirta">

        <!-- Judul bertumpuk -->
        <div class="title">
            Laporan Persuratan
        </div>
        <div class="subtitle">
            Klinik Jasa Tirta
        </div>
        <div class="period" style="font-family:'Times New Roman', Times, serif; font-size:12px; margin-top:4px;">
            @if ($request->filled('start') && $request->filled('end'))
                Periode: {{ \Carbon\Carbon::parse($request->start)->format('d M Y') }}
                s/d {{ \Carbon\Carbon::parse($request->end)->format('d M Y') }}
            @else
                Periode: Semua Data
            @endif
        </div>

    </div>

    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Kode Arsip</th>
                <th>No Surat</th>
                <th>Perihal</th>
                <th>Kategori</th>
                <th>Tanggal Arsip</th>
            </tr>
        </thead>
        <tbody>
            @if ($isEmpty)
                <tr>
                    <td colspan="5" style="text-align:center; font-style:italic; padding:10px;">
                        @if ($request->filled('start') && $request->filled('end'))
                            Data laporan untuk periode
                            {{ \Carbon\Carbon::parse($request->start)->format('d M Y') }}
                            s/d {{ \Carbon\Carbon::parse($request->end)->format('d M Y') }}
                            belum tersedia.
                        @else
                            Data laporan belum tersedia.
                        @endif
                    </td>
                </tr>
            @else
                @foreach ($laporans as $laporan)
                    <tr>
                        <td>{{ $laporan->kode_arsip }}</td>
                        <td>{{ $laporan->nomor_surat }}</td>
                        <td>{{ $laporan->perihal }}</td>
                        <td>{{ $laporan->kategori }}</td>
                        <td>
                            {{ $laporan->tanggal_arsip ? \Carbon\Carbon::parse($laporan->tanggal_arsip)->format('d M Y') : '-' }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>

</html>