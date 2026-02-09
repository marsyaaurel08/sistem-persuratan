<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
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
        $totalMasuk = Arsip::where('kategori', 'Masuk')->count();
        $totalKeluar = Arsip::where('kategori', 'Keluar')->count();
        $totalLaporan = Arsip::where('kategori', 'Laporan')->count();

        $waktuRespon = 2; // contoh nilai statis
        $divisiMasuk = DB::table('surat_masuk')->select('penerima_divisi as divisi')->distinct();
        $divisiKeluar = DB::table('surat_keluar')->select('pengirim_divisi as divisi')->distinct();

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

            $countMasuk = Arsip::where('kategori', 'Masuk')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $countKeluar = Arsip::where('kategori', 'Keluar')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $countLaporan = Arsip::where('kategori', 'Laporan')
                ->whereMonth('created_at', $date->month)
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
            'totalLaporan',
            //'menungguRespon',
            'waktuRespon',
            'months',
            'chartData',
            'pieLabels',
            'pieValues',
            'aktivitas',
            'divisi'
        ));
    }

    public function filter(Request $request)
    {
        $divisi = $request->input('divisi', []);
        $tanggal = $request->input('tanggal', []);

        $queryMasuk = SuratMasuk::query();
        $queryKeluar = SuratKeluar::query();

        if (!empty($divisi)) {
            $queryMasuk->whereIn('penerima_divisi', $divisi);
            $queryKeluar->whereIn('pengirim_divisi', $divisi);
        }

        if (!empty($tanggal)) {
            $start = Carbon::parse($tanggal[0])->startOfDay();
            $end = Carbon::parse($tanggal[1])->endOfDay();
            $queryMasuk->whereBetween('tanggal_surat', [$start, $end]);
            $queryKeluar->whereBetween('tanggal_surat', [$start, $end]);
        }

        // === Statistik ===
        $totalMasuk = $queryMasuk->count();
        $totalKeluar = $queryKeluar->count();
        $menungguRespon = $queryMasuk->where('status', 'Pending')->count() +
            $queryKeluar->where('status', 'Pending')->count();
        $waktuRespon = 2;

        // === Grafik Line ===
        $months = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            $countMasuk = SuratMasuk::when(!empty($divisi), fn($q) => $q->whereIn('penerima_divisi', $divisi))
                ->when(!empty($tanggal), fn($q) => $q->whereBetween('tanggal_surat', [$start, $end]))
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $countKeluar = SuratKeluar::when(!empty($divisi), fn($q) => $q->whereIn('pengirim_divisi', $divisi))
                ->when(!empty($tanggal), fn($q) => $q->whereBetween('tanggal_surat', [$start, $end]))
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();

            $chartData[] = $countMasuk + $countKeluar;
        }

        // === Grafik Pie ===
        $statusMasuk = SuratMasuk::when(!empty($divisi), fn($q) => $q->whereIn('penerima_divisi', $divisi))
            ->when(!empty($tanggal), fn($q) => $q->whereBetween('tanggal_surat', [$start, $end]))
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $statusKeluar = SuratKeluar::when(!empty($divisi), fn($q) => $q->whereIn('pengirim_divisi', $divisi))
            ->when(!empty($tanggal), fn($q) => $q->whereBetween('tanggal_surat', [$start, $end]))
            ->select('status', DB::raw('count(*) as total'))
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

        // === Aktivitas Terbaru ===
        $aktivitas = DB::table(DB::raw("(
        SELECT nomor_surat, perihal, 'Surat Masuk' AS jenis, penerima_divisi AS lokasi, tanggal_surat, status, created_at
        FROM surat_masuk
        UNION ALL
        SELECT nomor_surat, perihal, 'Surat Keluar' AS jenis, pengirim_divisi AS lokasi, tanggal_surat, status, created_at
        FROM surat_keluar
    ) AS aktivitas_union"))
            ->when(!empty($divisi), fn($q) => $q->whereIn('lokasi', $divisi))
            ->when(!empty($tanggal), fn($q) => $q->whereBetween('tanggal_surat', [$start, $end]))
            ->orderByDesc('created_at')
            ->limit(7)
            ->get();

        return response()->json([
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'menungguRespon' => $menungguRespon,
            'waktuRespon' => $waktuRespon,
            'months' => $months,
            'chartData' => $chartData,
            'pieLabels' => $pieLabels,
            'pieValues' => $pieValues,
            'aktivitas' => $aktivitas,
        ]);
    }
}
