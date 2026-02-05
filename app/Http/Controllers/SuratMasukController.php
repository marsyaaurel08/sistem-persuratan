<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    // Menampilkan daftar surat masuk
    public function index(Request $request)
    {
        $query = SuratMasuk::with('pengirim')->latest();

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                ->orWhere('perihal', 'like', "%{$search}%")
                ->orWhere('penerima_divisi', 'like', "%{$search}%")
                ->orWhereHas('pengirim', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        $suratMasuk = $query->get();

        // ================= STATISTIK =================
        $totalSurat = SuratMasuk::count();

        $belumDisposisi = SuratMasuk::where('status', 'Pending')->count();

        $statusCounts = SuratMasuk::select('status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $selesaiBulanIni = SuratMasuk::where('status', 'Selesai')
            ->whereMonth('tanggal_surat', now()->month)
            ->whereYear('tanggal_surat', now()->year)
            ->count();

        return view('surat_masuk.index', compact(
            'suratMasuk',
            'totalSurat',
            'belumDisposisi',
            'statusCounts',
            'selesaiBulanIni'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = SuratMasuk::with('pengirim');

        // FILTER STATUS (langsung, TANPA ucfirst)
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // FILTER SEARCH
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                ->orWhere('perihal', 'like', "%{$search}%")
                ->orWhere('penerima_divisi', 'like', "%{$search}%")
                ->orWhereHas('pengirim', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        $suratMasuk = $query->latest()->get();

        return view('surat_masuk.partials.table', compact('suratMasuk'))->render();
    }

    // Menyimpan data surat masuk
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'     => 'required|string|max:100',
            'tanggal_surat'   => 'required|date',
            'pengirim_id'     => 'required|exists:pengguna,id',
            'penerima_divisi' => 'required|string|max:255',
            'perihal'         => 'required|string|max:255',
            'file_surat'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        try {
            // UPLOAD FILE
            $file = $request->file('file_surat');
            $fileName = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $filePath = $file->storeAs('surat_masuk', $fileName, 'public');

            // SIMPAN DB
            SuratMasuk::create([
                'nomor_surat'     => $request->nomor_surat,
                'tanggal_surat'   => $request->tanggal_surat,
                'pengirim_id'     => $request->pengirim_id,
                'penerima_divisi' => $request->penerima_divisi,
                'perihal'         => $request->perihal,
                'file_path'       => $filePath,
                'status'          => 'Pending',
            ]);

            // RESPONSE AJAX
            return response()->json([
                'success'  => true,
                'message'  => 'Surat masuk berhasil disimpan',
                'redirect' => route('surat_masuk.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan surat'
            ], 500);
        }
    }

    public function create()
    {
        $pengguna = Pengguna::orderBy('divisi')->orderBy('name')->get();

        return view('surat_masuk.upload_surat', compact('pengguna'));
    }

    // Detail surat
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('surat_masuk.show', compact('surat'));
    }

    // Form edit surat
    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('surat_masuk.edit', compact('surat'));
    }

    // Update surat
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
        ]);

        $surat = SuratMasuk::findOrFail($id);
        $surat->update($request->all());

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui');
    }

    // Hapus surat
    public function destroy($id)
    {
        SuratMasuk::findOrFail($id)->delete();

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus');
    }

}
