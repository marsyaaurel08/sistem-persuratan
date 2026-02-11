<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    /**
     * Form buat surat
     */
    public function index()
    {
        return view('surat.index');
    }

    /**
     * Preview surat (HTML)
     */
    public function preview(Request $request)
    {
        $data = $request->validate([
            // KOP
            'kop_instansi' => 'required|string',
            'kop_alamat'   => 'required|string',
            'kop_telp'     => 'nullable|string',
            'kop_email'    => 'nullable|string',
            'kop_web'      => 'nullable|string',

            // LOGO
            'logo_kiri'  => 'nullable|image',
            'logo_kanan' => 'nullable|image',

            // INFO
            'nomor_surat' => 'required|string',
            'perihal'     => 'required|string',
            'tanggal'     => 'required|date',

            // ISI
            'isi_surat'   => 'required|string',
        ]);

        // Simpan logo sementara
        if ($request->hasFile('logo_kiri')) {
            $data['logo_kiri'] = $request->file('logo_kiri')->store('temp', 'public');
        }

        if ($request->hasFile('logo_kanan')) {
            $data['logo_kanan'] = $request->file('logo_kanan')->store('temp', 'public');
        }

        // Simpan ke session
        session(['surat_preview' => $data]);

        return view('surat.preview', $data);
    }

    /**
     * Download PDF
     */
    public function downloadPdf()
    {
        $data = session('surat_preview');

        abort_if(!$data, 404);

        $pdf = Pdf::loadView('surat.pdf', $data)->setPaper('A4');

        return $pdf->download('surat.pdf');
    }
}
