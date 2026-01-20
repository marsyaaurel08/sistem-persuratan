@forelse ($suratKeluar as $surat)
<tr>
    <td>{{ $surat->nomor_surat }}</td>
    <td>{{ $surat->pengirim_divisi }}</td>
    <td>{{ $surat->penerima->name ?? '-' }}</td>
    <td>{{ $surat->perihal }}</td>
    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>
    <td>
        <span class="badge bg-secondary">
            {{ strtoupper($surat->status) }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted">
        Data tidak ditemukan
    </td>
</tr>
@endforelse
