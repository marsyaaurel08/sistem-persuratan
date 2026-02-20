<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Arsip::query()
            ->select(
                'kode_arsip',
                'nomor_surat',
                'perihal',
                'kategori',
                'tanggal_arsip'
            );

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(kode_arsip) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(nomor_surat) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(perihal) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(kategori) LIKE ?', ["%$search%"]);
            });
        }

        // 📅 FILTER TANGGAL ARSIP
        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('tanggal_arsip', [
                $request->start,
                $request->end
            ]);
        }

        $laporans = $query->latest()->paginate(10)
            ->appends($request->only(['search', 'start', 'end']));

        return view('laporan.index', compact('laporans'));
    }

    public function exportPdf(Request $request)
    {
        $laporans = $this->getFilteredData($request);

        // Cek apakah data kosong
        $isEmpty = $laporans->isEmpty();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', [
            'laporans' => $laporans,
            'request' => $request,
            'isEmpty' => $isEmpty, // kirim status kosong
        ])->setPaper('a4', 'portrait');

        if ($request->filled('start') && $request->filled('end')) {
            $start = \Carbon\Carbon::parse($request->start)->format('d-m-Y');
            $end   = \Carbon\Carbon::parse($request->end)->format('d-m-Y');
            $filename = "Laporan PDF Arsip Periode {$start} s.d {$end}.pdf";
        } else {
            $filename = "Laporan PDF Arsip Semua Data.pdf";
        }

        return $pdf->stream($filename);
    }

    public function exportExcel(Request $request)
    {
        $laporans = $this->getFilteredData($request);

        if ($request->filled('start') && $request->filled('end')) {
            $start = \Carbon\Carbon::parse($request->start)->format('d-m-Y');
            $end   = \Carbon\Carbon::parse($request->end)->format('d-m-Y');
            $periode = "Periode: {$start} s.d {$end}";
            $filename = "Laporan Excel Persuratan Periode {$start} s.d {$end}.xlsx";
        } else {
            $periode = "Periode: Semua Data";
            $filename = "Laporan Excel Persuratan Semua Data.xlsx";
        }

        // ✅ Pastikan di sini argumen kedua adalah string, bukan array
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanExport($laporans, $periode),
            $filename
        );
    }

    public function previewExcel(Request $request)
    {
        $laporans = $this->getFilteredData($request);

        // Header kolom baru sesuai Arsip
        $headers = ['Kode Arsip', 'No. Surat', 'Perihal', 'Kategori', 'Tanggal Arsip'];

        return view('laporan.preview_excel', compact('laporans', 'headers', 'request'));
    }


    protected function getFilteredData(Request $request)
    {
        $query = Arsip::query()
            ->select(
                'kode_arsip',
                'nomor_surat',
                'perihal',
                'kategori',
                'tanggal_arsip'
            );

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(kode_arsip) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(nomor_surat) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(perihal) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(kategori) LIKE ?', ["%$search%"]);
            });
        }

        // 📅 FILTER TANGGAL ARSIP
        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('tanggal_arsip', [
                $request->start,
                $request->end
            ]);
        }

        return $query->orderBy('tanggal_arsip', 'desc')->get();
    }
}
