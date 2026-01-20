{{-- @forelse ($suratMasuk as $surat)
<tr>
    <td>{{ $surat->nomor_surat }}</td>
    <td>{{ $surat->pengirim->name ?? '-' }}</td>
    <td>{{ $surat->perihal }}</td>
    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>
    <td>
        <span class="badge bg-secondary">{{ strtoupper($surat->status) }}</span>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">
        Data tidak ditemukan
    </td>
</tr>
@endforelse --}}

@forelse ($suratMasuk as $surat)
{{-- <tr data-date="{{ $surat->tanggal_surat }}"> --}}
    <td>{{ $surat->nomor_surat }}</td>
    <td>{{ $surat->pengirim->name ?? '-' }}</td>
    <td>{{ $surat->perihal }}</td>
    <td>{{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') }}</td>
    <td>
        <span class="badge bg-secondary">{{ strtoupper($surat->status) }}</span>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-muted">
        Data tidak ditemukan
    </td>
</tr>
@endforelse
