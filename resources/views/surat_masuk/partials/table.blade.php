@forelse ($suratMasuk as $surat)
    <tr data-date="{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('Y-m-d') }}">
        <td>{{ $surat->nomor_surat }}</td>
        <td>{{ $surat->pengirim->name ?? '-' }}</td>
        <td>{{ $surat->perihal }}</td>
        <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>

        @php
            $status = strtolower(trim($surat->status));

            $statusMap = [
                'pending' => ['label' => 'Pending', 'class' => 'bg-warning-subtle text-warning'],
                'disposisi' => ['label' => 'Disposisi', 'class' => 'bg-info-subtle text-info'],
                'selesai' => ['label' => 'Selesai', 'class' => 'bg-success-subtle text-success'],
                'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-danger-subtle text-danger'],
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
        <td colspan="6" class="text-center text-muted">
            Data tidak ditemukan
        </td>
    </tr>
@endforelse

@push('styles')
    <style>
        .badge-custom {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.85em;
            font-weight: 500;
            border-radius: 0.75rem;
            /* bulat lembut */
            text-align: center;
            vertical-align: middle;
        }

        .bg-warning-subtle {
            background-color: #fff3cd !important;
            color: #856404 !important;
        }

        .bg-info-subtle {
            background-color: #cff4fc !important;
            color: #055160 !important;
        }

        .bg-success-subtle {
            background-color: #d1e7dd !important;
            color: #0f5132 !important;
        }

        .bg-danger-subtle {
            background-color: #f8d7da !important;
            color: #842029 !important;
        }

        .bg-secondary-subtle {
            background-color: #e2e3e5 !important;
            color: #41464b !important;
        }
    </style>
@endpush
