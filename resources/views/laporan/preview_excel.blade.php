@extends('layout.app')

@section('title', 'Preview Excel')

@section('content')
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('laporan.index') }}"
                class="btn btn-outline-secondary d-flex align-items-center justify-content-center rounded-circle"
                style="width: 36px; height: 36px;">
                <i class="feather-arrow-left"></i>
            </a>
            <h5 class="m-0">Preview Laporan (Format Excel)</h5>
        </div>

        <a href="{{ route('laporan.exportExcel', ['start' => request('start'), 'end' => request('end'), 'search' => request('search')]) }}"
            class="btn btn-sm btn-success rounded-pill px-3 d-flex align-items-center gap-1">
            <i class="feather-download"></i>
            <span>Download Excel</span>
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm align-middle text-center">
                    <thead class="table-success">
                        <tr>
                            @foreach ($headers as $header)
                                <th>{{ $header }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                            <tr>
                                <td>{{ $laporan->kode_arsip }}</td>
                                <td>{{ $laporan->nomor_surat }}</td>
                                <td>{{ $laporan->perihal }}</td>
                                <td>{{ $laporan->kategori }}</td>
                                <td>{{ $laporan->tanggal_arsip ? \Carbon\Carbon::parse($laporan->tanggal_arsip)->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($headers) }}" class="text-muted">Tidak ada data untuk ditampilkan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
