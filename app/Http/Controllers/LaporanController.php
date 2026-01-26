<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    // Tampilkan laporan
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

        // Filter teks
        if ($request->filled('search')) {
            $search = $request->search;
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                        ->mergeBindings($query->getQuery())
                        ->whereRaw("LOWER(no_surat) LIKE ? OR LOWER(perihal) LIKE ? OR LOWER(divisi) LIKE ? OR LOWER(status) LIKE ?", 
                            ["%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%"]);
        }

        // Filter tanggal
        if ($request->filled('start') && $request->filled('end')) {
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                        ->mergeBindings($query->getQuery())
                        ->whereBetween('tanggal', [$request->start, $request->end]);
        }

        $laporans = $query->orderBy('tanggal', 'desc')->paginate(10);


        return view('laporan.index', compact('laporans'));
    }

    // Export PDF
    // public function exportPdf(Request $request)
    // {
    //     $laporans = $this->getFilteredData($request);
    //     $pdf = PDF::loadView('laporan.pdf', compact('laporans'));
    //     return $pdf->download('laporan.pdf');
    // }

    // // Export Excel
    // public function exportExcel(Request $request)
    // {
    //     $laporans = $this->getFilteredData($request);
    //     return Excel::download(new LaporanExport($laporans), 'laporan.xlsx');
    // }

    // Helper ambil data sesuai filter
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
            $search = $request->search;
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                        ->mergeBindings($query->getQuery())
                        ->whereRaw("LOWER(no_surat) LIKE ? OR LOWER(perihal) LIKE ? OR LOWER(divisi) LIKE ? OR LOWER(status) LIKE ?", 
                            ["%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%"]);
        }

        if ($request->filled('start') && $request->filled('end')) {
            $query = DB::table(DB::raw("({$query->toSql()}) as t"))
                        ->mergeBindings($query->getQuery())
                        ->whereBetween('tanggal', [$request->start, $request->end]);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }
}
