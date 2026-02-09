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

            $chartData[] = $countMasuk + $countKeluar + $countLaporan;
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
        // ============================
        $aktivitas = Arsip::with(['files', 'pengarsip'])
            ->orderByDesc('tanggal_arsip')
            ->limit(10)
            ->get()
            ->map(function ($a) {
                return [
                    'kode_arsip'    => $a->kode_arsip,
                    'nomor_surat'   => $a->nomor_surat,
                    'perihal'       => $a->perihal,
                    'tanggal_arsip' => optional($a->tanggal_arsip)->format('Y-m-d'),
                    'tanggal_view'  => optional($a->tanggal_arsip)->format('d M Y'),
                    'pengarsip'     => optional($a->pengarsip)->name ?? '-',
                    'files'         => $a->files->map(fn($f) => [
                        'id'        => $f->id,
                        'nama_file' => $f->nama_file,
                        'url'       => asset('storage/' . $f->path_file), // ← untuk Preview
                    ])->values(),
                ];
            })
            ->values();





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
        $tanggal = $request->input('tanggal', []);

        $start = null;
        $end   = null;
        if (!empty($tanggal) && count($tanggal) === 2) {
            $start = Carbon::parse($tanggal[0])->startOfDay();
            $end   = Carbon::parse($tanggal[1])->endOfDay();
        }

        // === Statistik (dari Arsip) ===
        $baseQuery = Arsip::query();
        if ($start && $end) {
            $baseQuery->whereBetween('tanggal_arsip', [$start, $end]);
        }

        $totalMasuk    = (clone $baseQuery)->where('kategori', 'Masuk')->count();
        $totalKeluar   = (clone $baseQuery)->where('kategori', 'Keluar')->count();
        $totalLaporan  = (clone $baseQuery)->where('kategori', 'Laporan')->count();

        // placeholder kalau masih dipakai di front-end
        $menungguRespon = 0;
        $waktuRespon    = 2;

        // === Grafik Line (dari Arsip + filter tanggal) ===
        $months    = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            $query = Arsip::query()
                ->when($start && $end, fn($q) => $q->whereBetween('tanggal_arsip', [$start, $end]))
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year);

            $chartData[] = $query->count();
        }

        // === Aktivitas Terbaru (dari Arsip + filter tanggal) ===
        $aktivitas = Arsip::with(['files', 'pengarsip'])
            ->when($start && $end, fn($q) => $q->whereBetween('tanggal_arsip', [$start, $end]))
            ->orderByDesc('tanggal_arsip')
            ->limit(10)
            ->get()
            ->map(function ($a) {
                return [
                    'kode_arsip'    => $a->kode_arsip,
                    'nomor_surat'   => $a->nomor_surat,
                    'perihal'       => $a->perihal,
                    'tanggal_arsip' => optional($a->tanggal_arsip)->format('Y-m-d'),
                    'tanggal_view'  => optional($a->tanggal_arsip)->format('d M Y'),
                    'pengarsip'     => optional($a->pengarsip)->name ?? '-',
                    'files'         => $a->files->map(fn($f) => [
                        'id'        => $f->id,
                        'nama_file' => $f->nama_file,
                        'url'       => asset('storage/' . $f->path_file),
                    ])->values(),
                ];
            })
            ->values();

        return response()->json([
            'totalMasuk'     => $totalMasuk,
            'totalKeluar'    => $totalKeluar,
            'totalLaporan'   => $totalLaporan,
            'menungguRespon' => $menungguRespon,
            'waktuRespon'    => $waktuRespon,
            'months'         => $months,
            'chartData'      => $chartData,
            'pieLabels'      => [],       // kalau nanti mau pie chart dari Arsip, bisa diisi
            'pieValues'      => [],
            'aktivitas'      => $aktivitas,
        ]);
    }
}
