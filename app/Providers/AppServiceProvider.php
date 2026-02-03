<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    public function boot()
    {
        Paginator::useBootstrap();

        // Ambil statistik dasar
        // $totalMasuk = SuratMasuk::count();
        // $totalKeluar = SuratKeluar::count();
        // $menungguRespon = SuratMasuk::where('status', 'Pending')->count()
        //     + SuratKeluar::where('status', 'Pending')->count();
        // $waktuRespon = 2; // jika statis, atau hitung sesuai logika

        // View::share([
        //     'totalMasuk' => $totalMasuk,
        //     'totalKeluar' => $totalKeluar,
        //     'menungguRespon' => $menungguRespon,
        //     'waktuRespon' => $waktuRespon,
        // ]);

        // // jika ingin juga share $divisi secara global (opsional)
        // $divisiMasuk = DB::table('surat_masuk')->select('penerima_divisi as divisi')->distinct();
        // $divisiKeluar = DB::table('surat_keluar')->select('pengirim_divisi as divisi')->distinct();
        // $divisi = $divisiMasuk->union($divisiKeluar)->orderBy('divisi')->get();
        // View::share('divisi', $divisi);
    }
}
