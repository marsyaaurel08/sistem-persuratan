@forelse ($suratKeluar as $surat)
    <tr data-date="{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('Y-m-d') }}"
        data-status="{{ strtolower($surat->status) }}">
        <td>{{ $surat->nomor_surat }}</td>
        <td>{{ $surat->pengirim_divisi ?? '-' }}</td>
        <td>{{ $surat->penerima->name ?? '-' }}</td>
        <td>{{ $surat->perihal }}</td>
        <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>

        @php
            $status = strtolower(trim($surat->status));

            $statusMap = [
                'pending' => [
                    'label' => 'Pending',
                    'class' => 'bg-warning-subtle text-warning',
                ],
                'disposisi' => [
                    'label' => 'Disposisi',
                    'class' => 'bg-info-subtle text-info',
                ],
                'selesai' => [
                    'label' => 'Selesai',
                    'class' => 'bg-success-subtle text-success',
                ],
                'ditolak' => [
                    'label' => 'Ditolak',
                    'class' => 'bg-danger-subtle text-danger',
                ],
            ];

            $badgeClass = $statusMap[$status]['class'] ?? 'bg-secondary-subtle text-secondary';
            $badgeLabel = $statusMap[$status]['label'] ?? ucfirst($surat->status);
        @endphp

        <td>
            <span class="badge-custom {{ $badgeClass }}">
                {{ $badgeLabel }}
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
        <td colspan="7" class="text-center text-muted">
            Data tidak ditemukan
        </td>
    </tr>
@endforelse
