<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class SuratMasukController extends Controller
{
    // Menampilkan daftar surat masuk
    // public function index(Request $request)
    // {
    //     $query = SuratMasuk::with('pengirim')->latest();

    //     if ($request->filled('search')) {
    //         $search = $request->search;

    //         $query->where(function ($q) use ($search) {
    //             $q->where('nomor_surat', 'like', "%$search%")
    //             ->orWhere('perihal', 'like', "%$search%")
    //             ->orWhere('penerima_divisi', 'like', "%$search%")
    //             ->orWhereHas('pengirim', function ($q2) use ($search) {
    //                 $q2->where('name', 'like', "%$search%");
    //             });
    //         });
    //     }

    //     $suratMasuk = $query->get();

    //     $totalSurat = SuratMasuk::count();
    //     $belumDisposisi = SuratMasuk::where('status', 'Pending')->count();
    //     $selesaiBulanIni = SuratMasuk::where('status', 'Selesai')
    //         ->whereMonth('tanggal_surat', now()->month)
    //         ->whereYear('tanggal_surat', now()->year)
    //         ->count();

    //     return view('surat_masuk.index', compact(
    //         'suratMasuk',
    //         'totalSurat',
    //         'belumDisposisi',
    //         'selesaiBulanIni'
    //     ));
    // }

    public function index(Request $request)
    {
        // Query awal dengan eager loading pengirim dan urut terbaru
        $query = SuratMasuk::with('pengirim')->latest();

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // FILTER SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%$search%")
                ->orWhere('perihal', 'like', "%$search%")
                ->orWhere('penerima_divisi', 'like', "%$search%")
                ->orWhereHas('pengirim', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                });
            });
        }

        $suratMasuk = $query->get();

        // Statistik untuk dashboard
        $totalSurat = SuratMasuk::count();
        $belumDisposisi = SuratMasuk::where('status', 'Pending')->count();
        $selesaiBulanIni = SuratMasuk::where('status', 'Selesai')
            ->whereMonth('tanggal_surat', now()->month)
            ->whereYear('tanggal_surat', now()->year)
            ->count();

        return view('surat_masuk.index', compact(
            'suratMasuk',
            'totalSurat',
            'belumDisposisi',
            'selesaiBulanIni'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = SuratMasuk::with('pengirim');

        if ($status) {
            $query->where('status', ucfirst($status));
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%$search%")
                ->orWhere('perihal', 'like', "%$search%")
                ->orWhereHas('pengirim', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%");
                });
            });
        }

        $suratMasuk = $query->latest()->get();

        return view('surat_masuk.partials.table', compact('suratMasuk'))->render();
    }

    // public function search(Request $request)
    // {
    //     $search = $request->search;

    //     $suratMasuk = SuratMasuk::with('pengirim')
    //         ->where(function ($q) use ($search) {
    //             $q->where('nomor_surat', 'like', "%$search%")
    //             ->orWhere('perihal', 'like', "%$search%")
    //             ->orWhereHas('pengirim', function ($q2) use ($search) {
    //                 $q2->where('name', 'like', "%$search%");
    //             });
    //         })
    //         ->latest()
    //         ->get();

    //     return view('surat_masuk.partials.table', compact('suratMasuk'))->render();
    // }

    // Menyimpan data surat masuk
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
        ]);

        SuratMasuk::create($request->all());

        return redirect()
            ->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil disimpan');
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
