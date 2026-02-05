@forelse ($suratKeluar as $surat)
    {{-- <tr data-date="{{ $surat->tanggal_surat }}"> --}}
        <tr data-date="{{ $surat->tanggal_surat }}" data-status="{{ strtolower($surat->status) }}">
        <td>{{ $surat->nomor_surat }}</td>
        <td>{{ $surat->pengirim_divisi }}</td>
        <td>{{ $surat->penerima->name ?? '-' }}</td>
        <td>{{ $surat->perihal }}</td>
        <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>

        @php
            $status = strtolower(trim($surat->status));

            $statusMap = [
                'pending' => [
                    'label' => 'PENDING',
                    'class' => 'bg-warning-subtle text-warning',
                ],
                'disposisi' => [
                    'label' => 'DISPOSISI',
                    'class' => 'bg-info-subtle text-info',
                ],
                'selesai' => [
                    'label' => 'SELESAI',
                    'class' => 'bg-success-subtle text-success',
                ],
            ];
        @endphp

        <td>
            <span class="badge {{ $statusMap[$status]['class'] ?? 'bg-secondary text-white' }}">
                {{ $statusMap[$status]['label'] ?? strtoupper($surat->status) }}
            </span>
        </td>

        <td class="text-center">
            <button class="btn p-0 border-0 bg-transparent" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center text-muted">
            Data tidak ditemukan
        </td>
    </tr>
@endforelse
