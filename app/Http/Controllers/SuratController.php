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

            'kop_telp'  => 'nullable|string|required_without_all:kop_email,kop_web',
            'kop_email' => 'nullable|email|required_without_all:kop_telp,kop_web',
            'kop_web'   => 'nullable|string|required_without_all:kop_telp,kop_email',


            // LOGO
            'logo_kiri'  => 'nullable|image',
            'logo_kanan' => 'nullable|image',

            // INFO
            'nomor_surat' => 'nullable|string',
            'perihal'     => 'nullable|string',
            'tanggal'     => 'nullable|date',

            // ISI
            'isi_surat'   => 'nullable|string',

        ], [
            'kop_instansi.required' => 'Nama instansi wajib diisi',
            'kop_alamat.required'   => 'Alamat wajib diisi',

            'kop_telp'  => 'Minimal salah satu Contact wajib diisi',
            'kop_email' => 'Minimal salah satu Contact wajib diisi',
            'kop_web'   => 'Minimal salah satu Contact wajib diisi',
        ]);
        // if (
        //     !$request->filled('kop_telp') &&
        //     !$request->filled('kop_email') &&
        //     !$request->filled('kop_web')
        // ) {
        //     return redirect()->route('surat.create')
        //         ->withErrors(['contact' => 'Minimal salah satu Contact wajib diisi'])
        //         ->withInput();
        // }




        // Simpan logo sementara
        if ($request->hasFile('logo_kiri')) {
            $data['logo_kiri'] = $request->file('logo_kiri')->store('temp', 'public');
        }

        if ($request->hasFile('logo_kanan')) {
            $data['logo_kanan'] = $request->file('logo_kanan')->store('temp', 'public');
        }

        // Simpan ke session (kalau mau dipakai untuk download PDF)
        session(['surat_preview' => $data]);

        // 💡 Render langsung ke PDF Viewer (stream), bukan view HTML biasa
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('surat.preview', $data)->setPaper('A4');

        // tampilkan di browser (bukan download)
        return $pdf->stream('preview-surat.pdf');
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
