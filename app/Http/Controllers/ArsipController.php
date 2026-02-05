<?php

namespace App\Http\Controllers;

use App\Models\Arsip as ModelsArsip;
use App\Models\ArsipFile;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index()
    {
        // Arsip utama (buat tabel)
        $arsip = ModelsArsip::with(['suratMasuk', 'suratKeluar', 'files'])
            ->latest()
            ->paginate(10);

        // Rekap arsip per divisi
        $divisiStats = [];

        foreach ($arsip->items() as $a) {
            if ($a->jenis_surat === 'Masuk' && $a->suratMasuk) {
                $divisi = $a->suratMasuk->penerima_divisi;
            } elseif ($a->jenis_surat === 'Keluar' && $a->suratKeluar) {
                $divisi = $a->suratKeluar->pengirim_divisi;
            } else {
                $divisi = 'Unknown';
            }

            if (!isset($divisiStats[$divisi])) {
                $divisiStats[$divisi] = 0;
            }

            $divisiStats[$divisi]++; // 1 arsip = 1 dokumen
        }

        // Folder UI
        $colors = ['#4e73df', '#1cc88a', '#f6c23e', '#af52de', '#ff6b6b', '#4ecdc4'];
        $folders = [];
        $i = 0;

        foreach ($divisiStats as $divisi => $count) {
            $folders[] = [
                'name'  => $divisi,
                'count' => $count . ' dokumen',
                'color' => $colors[$i % count($colors)]
            ];
            $i++;
        }

        return view('arsip.index', compact('arsip', 'folders'));
    }



    public function create()
    {
        $suratMasuk = SuratMasuk::whereDoesntHave('arsip')
            ->latest()
            ->get();

        $suratKeluar = SuratKeluar::whereDoesntHave('arsip')
            ->latest()
            ->get();

        return view('arsip.upload_berkas', compact('suratMasuk', 'suratKeluar'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'jenis_surat' => 'required|in:Masuk,Keluar',
            'tanggal_arsip' => 'required|date',
            'surat_masuk_id' => 'required_if:jenis_surat,Masuk|nullable|exists:surat_masuk,id|prohibited_unless:jenis_surat,Masuk',
            'surat_keluar_id' => 'required_if:jenis_surat,Keluar|nullable|exists:surat_keluar,id|prohibited_unless:jenis_surat,Keluar',
            'lokasi_fisik' => 'nullable|string|max:100',
            'divisi' => 'nullable|string|max:100',
            'diarsipkan_nama' => 'nullable|string|max:100',
            'files.*' => 'required|file|max:51200|mimes:pdf,doc,docx,jpg,jpeg,png,tiff',
        ]);

        // Validate that at least one file is uploaded
        if (!$request->hasFile('files')) {
            return back()->withErrors(['files' => 'Minimal satu file harus diupload'])->withInput();
        }

        // Validate jenis surat dengan surat_id yang sesuai
        if ($request->jenis_surat === 'Masuk' && !$request->surat_masuk_id) {
            return back()->withErrors(['surat_masuk_id' => 'Surat masuk harus dipilih'])->withInput();
        }
        if ($request->jenis_surat === 'Keluar' && !$request->surat_keluar_id) {
            return back()->withErrors(['surat_keluar_id' => 'Surat keluar harus dipilih'])->withInput();
        }

        // Optional consistency check: selected surat belongs to selected divisi
        if ($request->filled('divisi')) {
            if ($request->jenis_surat === 'Masuk' && $request->surat_masuk_id) {
                $sm = SuratMasuk::find($request->surat_masuk_id);
                if ($sm && $sm->penerima_divisi !== $request->divisi) {
                    return back()->withErrors(['divisi' => 'Divisi tidak sesuai dengan surat masuk terpilih'])->withInput();
                }
            }
            if ($request->jenis_surat === 'Keluar' && $request->surat_keluar_id) {
                $sk = SuratKeluar::find($request->surat_keluar_id);
                if ($sk && $sk->pengirim_divisi !== $request->divisi) {
                    return back()->withErrors(['divisi' => 'Divisi tidak sesuai dengan surat keluar terpilih'])->withInput();
                }
            }
        }

        // Create arsip record
        $arsip = ModelsArsip::create([
            'jenis_surat' => $request->jenis_surat,
            'surat_masuk_id' => $request->surat_masuk_id,
            'surat_keluar_id' => $request->surat_keluar_id,
            'tanggal_arsip' => $request->tanggal_arsip,
            'lokasi_fisik' => $request->lokasi_fisik,
            'diarsipkan_nama' => $request->diarsipkan_nama,
        ]);

        // Upload and save files
        foreach ($request->file('files') as $file) {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('arsip', $filename, 'public');

            $arsip->files()->create([
                'nama_file' => $file->getClientOriginalName(),
                'path_file' => $path,
                'ukuran_file' => $file->getSize(),
                'tipe_file' => $file->getClientMimeType(),
            ]);
        }

        return redirect()
            ->route('arsip.index')
            ->with('success', 'Berkas berhasil diarsipkan dengan kode: ' . $arsip->kode_arsip);
    }

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
