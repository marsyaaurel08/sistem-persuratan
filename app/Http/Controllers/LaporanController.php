<?php

namespace App\Http\Controllers;

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
        $query = DB::table('surat_masuk')
            ->select(
                'nomor_surat as no_surat',
                'perihal',
                'penerima_divisi as divisi',
                'tanggal_surat as tanggal',
                'status'
            )
            ->unionAll(
                DB::table('surat_keluar')->select(
                    'nomor_surat as no_surat',
                    'perihal',
                    'pengirim_divisi as divisi',
                    'tanggal_surat as tanggal',
                    'status'
                )
            );

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                ->whereRaw("
                    LOWER(no_surat) LIKE ? OR 
                    LOWER(perihal) LIKE ? OR 
                    LOWER(divisi) LIKE ? OR 
                    LOWER(status) LIKE ?
                ", ["%$search%", "%$search%", "%$search%", "%$search%"]);
        }

        if ($request->filled('start') && $request->filled('end')) {
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                ->whereBetween('tanggal', [$request->start, $request->end]);
        }

        $laporans = $query->orderBy('tanggal', 'desc')->paginate(10);
        return view('laporan.index', compact('laporans'));
    }

    public function exportPdf(Request $request)
    {
        $laporans = $this->getFilteredData($request);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact('laporans', 'request'))
            ->setPaper('a4', 'portrait');

        if ($request->filled('start') && $request->filled('end')) {
            $start = \Carbon\Carbon::parse($request->start)->format('d-m-Y');
            $end   = \Carbon\Carbon::parse($request->end)->format('d-m-Y');
            $filename = "Laporan PDF Persuratan Periode {$start} s.d {$end}.pdf";
        } else {
            $filename = "Laporan PDF Persuratan Semua Data.pdf";
        }

        return $pdf->stream($filename);
    }


    public function exportExcel(Request $request)
    {
        $laporans = $this->getFilteredData($request);

        if ($request->filled('start') && $request->filled('end')) {
            $start = \Carbon\Carbon::parse($request->start)->format('d-m-Y');
            $end   = \Carbon\Carbon::parse($request->end)->format('d-m-Y');
            $filename = "Laporan Excel Persuratan Periode {$start} s.d {$end}.xlsx";
        } else {
            $filename = "Laporan Excel Persuratan Semua Data.xlsx";
        }

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LaporanExport($laporans),
            $filename
        );
    }


    public function previewExcel(Request $request)
    {
        $laporans = $this->getFilteredData($request);

        // Header kolom (bisa ubah sesuai kebutuhan)
        $headers = ['No. Surat', 'Perihal', 'Divisi', 'Tanggal', 'Status'];

        return view('laporan.preview_excel', compact('laporans', 'headers', 'request'));
    }


    protected function getFilteredData(Request $request)
    {
        $query = DB::table('surat_masuk')
            ->select(
                'nomor_surat as no_surat',
                'perihal',
                'penerima_divisi as divisi',
                'tanggal_surat as tanggal',
                'status'
            )
            ->unionAll(
                DB::table('surat_keluar')->select(
                    'nomor_surat as no_surat',
                    'perihal',
                    'pengirim_divisi as divisi',
                    'tanggal_surat as tanggal',
                    'status'
                )
            );

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                ->whereRaw("
                    LOWER(no_surat) LIKE ? OR 
                    LOWER(perihal) LIKE ? OR 
                    LOWER(divisi) LIKE ? OR 
                    LOWER(status) LIKE ?
                ", ["%$search%", "%$search%", "%$search%", "%$search%"]);
        }

        if ($request->filled('start') && $request->filled('end')) {
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                ->whereBetween('tanggal', [$request->start, $request->end]);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }
}
