<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\ArsipFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ArsipController extends Controller
{
    /**
     * Tampilkan daftar arsip
     */
    public function index(Request $request)
    {
        $kategori   = $request->get('kategori');
        $search     = $request->get('search');
        $startDate  = $request->get('start_date');
        $endDate    = $request->get('end_date');

        $query = Arsip::with(['files', 'pengarsip'])
            ->when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->when($search, fn($q) => $q->where(function($sub) use ($search) {
                $sub->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            }))
            ->when($startDate && $endDate, fn($q) => $q->whereBetween('tanggal_arsip', [$startDate, $endDate]));

        $arsips = $query->latest()->paginate(10)
                    ->appends($request->only(['kategori', 'search', 'start_date', 'end_date']));


        return view('arsip.index', [
            'arsips'        => $arsips,
            'kategoriAktif' => $kategori ?? 'semua',
            'countSemua'    => Arsip::count(),
            'countMasuk'    => Arsip::where('kategori', 'Masuk')->count(),
            'countKeluar'   => Arsip::where('kategori', 'Keluar')->count(),
            'countLaporan'  => Arsip::where('kategori', 'Laporan')->count(),
        ]);
    }

    /**
     * Simpan arsip baru
     */
    public function store(Request $request)
    {
        $rules = [
            'kategori'       => 'required|in:Masuk,Keluar,Laporan',
            'perihal'        => 'required|string|max:255',
            'tanggal_arsip'  => 'required|date',

            'files'          => 'required',
            'files.*'        => 'file|max:20480|mimes:pdf,doc,docx,jpg,jpeg,png,tiff',
        ];

        // Validasi nomor_surat berdasarkan kategori
        if ($request->kategori != 'Laporan') {
            $rules['nomor_surat'] = 'required|string|max:100|unique:arsip,nomor_surat';
        } else {
            $rules['nomor_surat'] = 'nullable|string|max:100|unique:arsip,nomor_surat';
        }

        // $request->validate($rules);

        $request->validate($rules, [

            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori tidak valid.',

            'perihal.required' => 'Perihal wajib diisi.',
            'perihal.max' => 'Perihal maksimal 255 karakter.',

            'tanggal_arsip.required' => 'Tanggal arsip wajib diisi.',
            'tanggal_arsip.date' => 'Format tanggal tidak valid.',

            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'nomor_surat.unique' => 'Nomor surat sudah digunakan.',
            'nomor_surat.max' => 'Nomor surat maksimal 100 karakter.',

            'files.required' => 'Dokumen wajib diunggah.',
            'files.*.file' => 'File tidak valid.',
            'files.*.max' => 'Ukuran file maksimal 20MB.',
            'files.*.mimes' => 'Dokumen tidak didukung. Silakan unggah file PDF, DOC, DOCX, JPG, JPEG, PNG, atau TIFF.',

        ]);

        // Simpan arsip
        $arsip = Arsip::create([
            'kategori'        => $request->kategori,
            'nomor_surat'     => $request->nomor_surat,
            'perihal'         => $request->perihal,
            'tanggal_arsip'   => $request->tanggal_arsip,
        ]);

        // Upload file
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
     * Form upload arsip
     */
    public function create()
    {
        return view('arsip.upload_berkas');
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

    /**
     * Unduh arsip secara massal.
     *
     * Aturan:
     * - 1 arsip dengan 1 file → langsung download file
     * - 1 arsip dengan banyak file → ZIP
     * - Banyak arsip → 1 ZIP (per arsip dibuatkan folder)
     */
    public function bulkDownload(Request $request)
    {
        $ids = $request->ids ?? [];

        // Validasi: harus ada arsip yang dipilih
        if (count($ids) === 0) {
            abort(400, 'Tidak ada arsip dipilih');
        }

        // Ambil data arsip beserta file-file nya
        $arsips = Arsip::with('files')
            ->whereIn('id', $ids)
            ->get();

        if ($arsips->isEmpty()) {
            abort(404, 'Arsip tidak ditemukan');
        }

        // Jika hanya 1 arsip dan hanya 1 file, unduh langsung tanpa ZIP
        if ($arsips->count() === 1) {
            $arsip = $arsips->first();

            if ($arsip->files->count() === 0) {
                abort(404, 'File arsip tidak ditemukan');
            }

            if ($arsip->files->count() === 1) {
                $file = $arsip->files->first();
                $path = storage_path('app/public/' . $file->path_file);

                return response()->download($path, $file->nama_file);
            }
        }

        // Unduh dalam bentuk ZIP (streaming)
        $zipName = 'arsip_' . now()->format('Ymd_His') . '.zip';

        return new StreamedResponse(function () use ($arsips) {
            $zip = new \ZipArchive;

            // File ZIP sementara
            $tmpFile = tempnam(sys_get_temp_dir(), 'arsip_zip_');

            if ($zip->open($tmpFile, \ZipArchive::CREATE) !== true) {
                abort(500, 'Gagal membuat ZIP');
            }

            // Daftar isi arsip untuk manifest
            $manifest = [];

            foreach ($arsips as $arsip) {
                // Nama folder berdasarkan nomor surat (dibuat aman untuk ZIP)
                $folder = preg_replace('/[^A-Za-z0-9_\-]/', '_', $arsip->nomor_surat);

                foreach ($arsip->files as $file) {
                    $filePath = storage_path('app/public/' . $file->path_file);

                    if (file_exists($filePath)) {
                        $zip->addFile(
                            $filePath,
                            $folder . '/' . $file->nama_file
                        );

                        $manifest[] = $arsip->nomor_surat . ' | ' . $file->nama_file;
                    }
                }
            }

            // Tambahkan file manifest ke dalam ZIP
            $zip->addFromString(
                'manifest.txt',
                implode(PHP_EOL, $manifest)
            );

            $zip->close();

            // Kirim ZIP ke client lalu hapus file sementara
            readfile($tmpFile);
            unlink($tmpFile);
        }, 200, [
            'Content-Type'        => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipName . '"',
        ]);
    }

    /**
     * Hapus arsip secara massal berdasarkan ID.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids ?? [];

        if (count($ids) === 0) {
            return response()->json(['message' => 'Tidak ada data'], 400);
        }

        Arsip::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Arsip berhasil dihapus'
        ]);
    }

    public function detail($id)
    {
        $arsip = Arsip::with(['pengarsip', 'files'])->findOrFail($id);

        return view('arsip.arsip_detail', compact('arsip'));
    }
}
