<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{ 
    // Menampilkan daftar surat keluar
    public function index(Request $request)
    {
        $query = SuratKeluar::with('penerima')->latest();

        // FILTER STATUS (case-insensitive)
        if ($request->filled('status')) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($request->status)]);
        }

        // FILTER SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('pengirim_divisi', 'like', "%{$search}%")
                    ->orWhereHas('penerima', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $suratKeluar = $query->get();

        // ================= STATISTIK =================
        $totalSurat = SuratKeluar::count();

        $statusCounts = SuratKeluar::selectRaw('LOWER(status) as status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $selesaiBulanIni = SuratKeluar::whereRaw("LOWER(status) = 'selesai'")
            ->whereMonth('tanggal_surat', now()->month)
            ->whereYear('tanggal_surat', now()->year)
            ->count();

        return view('surat_keluar.index', compact(
            'suratKeluar',
            'totalSurat',
            'statusCounts',
            'selesaiBulanIni'
        ));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $query = SuratKeluar::with('penerima');

        if (!empty($status)) {
            $query->whereRaw('LOWER(status) = ?', [strtolower($status)]);
        }

        // FILTER SEARCH
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                    ->orWhere('perihal', 'like', "%{$search}%")
                    ->orWhere('pengirim_divisi', 'like', "%{$search}%")
                    ->orWhereHas('penerima', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $suratKeluar = $query->latest()->get();

        return view('surat_keluar.partials.table', compact('suratKeluar'))->render();
    }

    // Menyimpan data surat keluar
    public function store(Request $request)
    {
        $request->validate([
            'nomor_surat'     => 'required',
            'tanggal_surat'   => 'required|date',
            'pengirim_divisi' => 'required',
            'perihal'         => 'required',
            'penerima_id'     => 'nullable|exists:pengguna,id',
            'file_path'       => 'nullable',
        ]);

        SuratKeluar::create($request->all());

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil disimpan');
    }

    // Detail surat keluar
    public function show($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        return view('surat_keluar.show', compact('surat'));
    }

    // Form edit surat keluar
    public function edit($id)
    {
        $surat = SuratKeluar::findOrFail($id);
        return view('surat_keluar.edit', compact('surat'));
    }

    // Update surat keluar
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_surat'     => 'required',
            'tanggal_surat'   => 'required|date',
            'pengirim_divisi' => 'required',
            'perihal'         => 'required',
            'penerima_id'     => 'nullable|exists:pengguna,id',
            'status'          => 'required',
        ]);

        $surat = SuratKeluar::findOrFail($id);
        $surat->update($request->all());

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui');
    }

    // Hapus surat keluar
    public function destroy($id)
    {
        SuratKeluar::findOrFail($id)->delete();

        return redirect()
            ->route('surat_keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus');
    }
}
