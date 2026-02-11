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
        // Statistik Card (ARSIP)
        // =============================
        $totalMasuk   = Arsip::where('kategori', 'Masuk')->count();
        $totalKeluar  = Arsip::where('kategori', 'Keluar')->count();
        $totalLaporan = Arsip::where('kategori', 'Laporan')->count();

        // =============================
        // Data Tren (Line Chart) - 6 bulan terakhir
        // =============================
        $months = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $months[] = $date->format('M');

            $chartData[] = Arsip::whereYear('tanggal_arsip', $date->year)
                ->whereMonth('tanggal_arsip', $date->month)
                ->count();
        }

        // =============================
        // Pie Chart (Kategori Arsip)
        // =============================
        $pieData = Arsip::select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        $pieLabels = $pieData->pluck('kategori')->toArray();
        $pieValues = $pieData->pluck('total')->toArray();

        // =============================
        // Aktivitas Terbaru
        // =============================
        $aktivitas = Arsip::with(['files', 'pengarsip'])
            ->orderByDesc('tanggal_arsip')
            ->limit(10)
            ->get()
            ->map(function ($a) {
                return [
                    'kode_arsip'    => $a->kode_arsip,
                    'nomor_surat'   => $a->nomor_surat,
                    'perihal'       => $a->perihal,
                    'tanggal_arsip' => $a->tanggal_arsip?->format('Y-m-d'),
                    'tanggal_view'  => $a->tanggal_arsip?->format('d M Y'),
                    'pengarsip'     => $a->pengarsip->name ?? '-',
                    'files'         => $a->files->map(fn ($f) => [
                        'id'        => $f->id,
                        'nama_file' => $f->nama_file,
                        'url'       => asset('storage/' . $f->path_file),
                    ])->values(),
                ];
            })
            ->values();

        // =============================
        // Kirim ke View
        // =============================
        return view('main', compact(
            'totalMasuk',
            'totalKeluar',
            'totalLaporan',
            'months',
            'chartData',
            'pieLabels',
            'pieValues',
            'aktivitas'
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

        // =============================
        // Base Query Arsip (Filter Tanggal)
        // =============================
        $baseQuery = Arsip::query()
            ->when($start && $end, fn ($q) =>
                $q->whereBetween('tanggal_arsip', [$start, $end])
            );

        // =============================
        // Statistik Card
        // =============================
        $totalMasuk   = (clone $baseQuery)->where('kategori', 'Masuk')->count();
        $totalKeluar  = (clone $baseQuery)->where('kategori', 'Keluar')->count();
        $totalLaporan = (clone $baseQuery)->where('kategori', 'Laporan')->count();

        // =============================
        // Line Chart (6 Bulan Terakhir)
        // =============================
        $months = [];
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $months[] = $date->format('M');

            $chartData[] = Arsip::query()
                ->when($start && $end, fn ($q) =>
                    $q->whereBetween('tanggal_arsip', [$start, $end])
                )
                ->whereYear('tanggal_arsip', $date->year)
                ->whereMonth('tanggal_arsip', $date->month)
                ->count();
        }

        // =============================
        // Pie Chart (Kategori Arsip)
        // =============================
        $pieData = (clone $baseQuery)
            ->select('kategori', DB::raw('count(*) as total'))
            ->groupBy('kategori')
            ->get();

        $pieLabels = $pieData->pluck('kategori')->toArray();
        $pieValues = $pieData->pluck('total')->toArray();

        // =============================
        // Aktivitas Terbaru
        // =============================
        $aktivitas = Arsip::with(['files', 'pengarsip'])
            ->when($start && $end, fn ($q) =>
                $q->whereBetween('tanggal_arsip', [$start, $end])
            )
            ->orderByDesc('tanggal_arsip')
            ->limit(10)
            ->get()
            ->map(function ($a) {
                return [
                    'kode_arsip'    => $a->kode_arsip,
                    'nomor_surat'   => $a->nomor_surat,
                    'perihal'       => $a->perihal,
                    'tanggal_arsip' => $a->tanggal_arsip?->format('Y-m-d'),
                    'tanggal_view'  => $a->tanggal_arsip?->format('d M Y'),
                    'pengarsip'     => $a->pengarsip->name ?? '-',
                    'files'         => $a->files->map(fn ($f) => [
                        'id'        => $f->id,
                        'nama_file' => $f->nama_file,
                        'url'       => asset('storage/' . $f->path_file),
                    ])->values(),
                ];
            })
            ->values();

        // =============================
        // Response JSON
        // =============================
        return response()->json([
            'totalMasuk'   => $totalMasuk,
            'totalKeluar'  => $totalKeluar,
            'totalLaporan' => $totalLaporan,
            'months'       => $months,
            'chartData'    => $chartData,
            'pieLabels'    => $pieLabels,
            'pieValues'    => $pieValues,
            'aktivitas'    => $aktivitas,
        ]);
    }
}
