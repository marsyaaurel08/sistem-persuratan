<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =============================
        // Statistik Card
        // =============================
        $totalMasuk = SuratMasuk::count();
        $totalKeluar = SuratKeluar::count();
        $menungguRespon = SuratMasuk::where('status', 'Pending')->count() +
            SuratKeluar::where('status', 'Pending')->count();
        $waktuRespon = 2; // contoh nilai statis
        $divisiMasuk = SuratMasuk::select('penerima_divisi as divisi')->distinct();
        $divisiKeluar = SuratKeluar::select('pengirim_divisi as divisi')->distinct();

        $divisi = $divisiMasuk
            ->union($divisiKeluar)
            ->orderBy('divisi')
            ->get();

        // =============================
        // Data Tren (Line Chart)
        // =============================
        $months = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            $countMasuk = SuratMasuk::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $countKeluar = SuratKeluar::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $chartData[] = $countMasuk + $countKeluar;
        }

        // =============================
        // Data Pie Chart
        // =============================
        $statusMasuk = SuratMasuk::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $statusKeluar = SuratKeluar::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $combinedStatus = [];
        foreach ($statusMasuk as $s) {
            $combinedStatus[$s->status] = ($combinedStatus[$s->status] ?? 0) + $s->total;
        }
        foreach ($statusKeluar as $s) {
            $combinedStatus[$s->status] = ($combinedStatus[$s->status] ?? 0) + $s->total;
        }

        $pieLabels = array_keys($combinedStatus);
        $pieValues = array_values($combinedStatus);

        // =============================
        // Aktivitas Terbaru
        // =============================



        $aktivitas = DB::table(DB::raw("(
            SELECT 
                nomor_surat AS nomor_surat, 
                perihal AS perihal, 
                'Surat Masuk' AS jenis, 
                penerima_divisi AS lokasi, 
                tanggal_surat AS tanggal_surat, 
                status AS status, 
                created_at AS created_at
            FROM surat_masuk
            UNION ALL
            SELECT 
                nomor_surat AS nomor_surat, 
                perihal AS perihal, 
                'Surat Keluar' AS jenis, 
                pengirim_divisi AS lokasi, 
                tanggal_surat AS tanggal_surat, 
                status AS status, 
                created_at AS created_at
            FROM surat_keluar
                ) AS aktivitas_union"))
            ->select('*')
            ->orderByDesc('created_at')
            ->limit(7)
            ->get();




        // =============================
        // 5. Kirim ke View
        // =============================



        return view('main', compact(
            'totalMasuk',
            'totalKeluar',
            'menungguRespon',
            'waktuRespon',
            'months',
            'chartData',
            'pieLabels',
            'pieValues',
            'aktivitas',
            'divisi'
        ));
    }
}
