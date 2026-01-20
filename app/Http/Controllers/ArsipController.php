<?php

namespace App\Http\Controllers;

use App\Models\Arsip as ModelsArsip;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class ArsipController extends Controller
{
    public function index()
    {

       $arsip = ModelsArsip::with(['suratMasuk', 'suratKeluar'])->latest()->paginate(10);

        // Hitung arsip berdasarkan divisi dari surat masuk & keluar
        $divisiStats = [];
        
        // Dari Surat Masuk (penerima_divisi)
        $suratMasukDivisi = SuratMasuk::whereHas('arsip')
            ->select('penerima_divisi')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('penerima_divisi')
            ->get();

        // Dari Surat Keluar (pengirim_divisi)
        $suratKeluarDivisi = SuratKeluar::whereHas('arsip')
            ->select('pengirim_divisi')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('pengirim_divisi')
            ->get();

        // Gabung dan hitung total per divisi
        foreach ($suratMasukDivisi as $row) {
            $divisi = $row->penerima_divisi;
            if (!isset($divisiStats[$divisi])) {
                $divisiStats[$divisi] = 0;
            }
            $divisiStats[$divisi] += $row->count;
        }

        foreach ($suratKeluarDivisi as $row) {
            $divisi = $row->pengirim_divisi;
            if (!isset($divisiStats[$divisi])) {
                $divisiStats[$divisi] = 0;
            }
            $divisiStats[$divisi] += $row->count;
        }

        // Warna untuk setiap divisi
        $colors = ['#4e73df', '#1cc88a', '#f6c23e', '#af52de', '#ff6b6b', '#4ecdc4'];
        $colorIndex = 0;
        $folders = [];

        foreach ($divisiStats as $divisi => $count) {
            $folders[] = [
                'name' => $divisi ?? 'Unknown',
                'count' => $count . ' dokumen',
                'color' => $colors[$colorIndex % count($colors)]
            ];
            $colorIndex++;
        }

        return view('arsip.index', compact('arsip', 'folders'));
    }
}