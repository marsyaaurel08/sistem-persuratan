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
        $path = storage_path('app/public/' . $file->path_file);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($path, $file->nama_file);
    }

    public function bulkDownload(Request $request)
    {
        $ids = $request->ids;

        $files = ArsipFile::whereIn('id', $ids)->get();

        if ($files->isEmpty()) {
            abort(404, 'File tidak ditemukan');
        }

        // ✅ 1 FILE
        if ($files->count() === 1) {
            $file = $files->first();
            $path = storage_path('app/public/' . $file->path_file);

            return response()->download($path, $file->nama_file);
        }

        // ✅ BANYAK FILE → ZIP
        $zipName = 'arsip_' . now()->format('Ymd_His') . '.zip';
        $zipDir = storage_path('app/public/tmp');

        if (!file_exists($zipDir)) {
            mkdir($zipDir, 0775, true);
        }

        $zipPath = $zipDir . '/' . $zipName;

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat ZIP');
        }

        $added = 0;
        foreach ($files as $file) {
            $filePath = storage_path('app/public/' . $file->path_file);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, $file->nama_file);
                $added++;
            }
        }

        $zip->close();

        if ($added === 0) {
            abort(500, 'Tidak ada file valid untuk di-ZIP');
        }

        return response()
            ->download($zipPath, $zipName)
            ->deleteFileAfterSend(true);
    }
}

