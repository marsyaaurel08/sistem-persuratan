<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\ArsipFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArsipController extends Controller
{
    /**
     * Tampilkan daftar arsip
     */
    public function index()
    {
        $arsip = Arsip::with(['files', 'pengarsip'])
            ->latest()
            ->paginate(10);

        return view('arsip.index', compact('arsip'));
    }

    /**
     * Form upload arsip
     */
    public function create()
    {
        return view('arsip.upload_berkas');
    }

    /**
     * Simpan arsip baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori'       => 'required|in:Masuk,Keluar,Laporan',
            'nomor_surat'    => 'nullable|string|max:100',
            'perihal'        => 'required|string|max:255',
            'tanggal_arsip'  => 'required|date',
            //'lokasi_fisik'   => 'nullable|string|max:100',

            'files'          => 'required',
            'files.*'        => 'file|max:51200|mimes:pdf,doc,docx,jpg,jpeg,png,tiff',
        ]);

        // Simpan arsip (kode_arsip & user di-handle model)
        $arsip = Arsip::create([
            'kategori'        => $request->kategori,
            'nomor_surat'     => $request->nomor_surat,
            'perihal'         => $request->perihal,
            'tanggal_arsip'   => $request->tanggal_arsip,
            //'lokasi_fisik'    => $request->lokasi_fisik,
        ]);

        // Upload file arsip
        foreach ($request->file('files') as $file) {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('arsip', $filename, 'public');

            $arsip->files()->create([
                'nama_file'   => $file->getClientOriginalName(),
                'path_file'   => $path,
                'ukuran_file' => $file->getSize(),
                'tipe_file'   => $file->getClientMimeType(),
            ]);
        }

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Arsip berhasil disimpan dengan kode: ' . $arsip->kode_arsip);
    }

    /**
     * Download file arsip
     */

    public function download($id)
    {
        $file = ArsipFile::findOrFail($id);
        // Resolve full path on public disk and download using response helper
        $path = storage_path('app/public/' . $file->path_file);
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        return response()->download($path, $file->nama_file);
    }
}

