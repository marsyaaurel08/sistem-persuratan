@extends('layout.app')

@section('content')
    <div class="page-header rounded">
        <div class="page-header-left d-flex align-items-center">
            <div class="page-header-title">
                <h5 class="m-b-10">Surat Keluar</h5>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row mb-2 mt-4">
            <div class="card shadow-sm">
                <div class="card-body d-flex align-items-center gap-3 py-2">

                    <!-- TEXT -->
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-envelope-fill fs-4 text-secondary"></i>
                        <div class="text-muted fs-5 fw-medium">
                            Total Surat Terkirim
                        </div>
                        <div class="fw-bold fs-5">
                            {{ $totalSurat }}
                        </div>
                    </div>

                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- HEADER: SEARCH & ACTION -->
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">

                        <!-- SEARCH -->
                        <div style="max-width: 500px; width: 100%;">
                            <div class="input-group rounded-pill overflow-hidden border border-secondary-subtle">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="search" class="form-control border-0"
                                    placeholder="Cari nomor surat / perihal / penerima ...">
                            </div>
                        </div>

                        <!-- ACTION BUTTON -->
                        <div class="d-flex gap-2">
                            <!-- RENTANG TANGGAL -->
                            <button class="btn bg-secondary-subtle text-dark rounded px-3">
                                <i class="bi bi-calendar-event-fill me-1 text-dark"></i>
                                Rentang Tanggal
                            </button>

                            <!-- TAMBAH SURAT -->
                            <button class="btn bg-secondary-subtle text-dark rounded px-3">
                                <i class="bi bi-plus-circle-fill me-1 text-dark"></i>
                                Tambah Surat
                            </button>
                        </div>
                    </div>

                    <!-- FILTER STATUS -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="input-group-text bg-transparent border-0 fw-semibold">
                            Status :
                        </span>
                        <span class="badge rounded-pill bg-primary px-3 py-2">
                            Semua
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Baru (10)
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Dalam Proses (5)
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Disposisi (7)
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Disposisi (7)
                        </span>
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2">
                            Selesai
                        </span>
                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr class="text-muted fs-6 fw-medium">
                                    <th>No. Surat</th>
                                    <th>Perihal</th>
                                    <th>Penerima</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody class="fs-6" id="surat-table">
                                @forelse ($suratKeluar as $item)
                                    <tr>
                                        <td>{{ $item->nomor_surat }}</td>

                                        <td>{{ $item->perihal }}</td>

                                        <td>
                                            {{ $item->penerima?->name ?? '-' }}
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}
                                        </td>

                                        <td>
                                            @if ($item->status === 'Pending')
                                                <span class="badge bg-warning-subtle text-warning">PENDING</span>
                                            @elseif ($item->status === 'Disposisi')
                                                <span class="badge bg-info-subtle text-info">DISPOSISI</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success">SELESAI</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada surat keluar
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const tableBody = document.getElementById('surat-table');

            let timeout = null;

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    const query = this.value;

                    fetch(`{{ route('surat_keluar.search') }}?search=${query}`)
                        .then(response => response.text())
                        .then(html => {
                            tableBody.innerHTML = html;
                        });
                }, 300); // debounce 300ms
            });
        });
    </script>