<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Arsip;
use App\Models\Pengguna;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use Carbon\Carbon;

class ArsipSeeder extends Seeder
{
    public function run(): void
    {
        // === Arsip Surat Masuk ===
        $suratMasuk = SuratMasuk::take(5)->get();

        foreach ($suratMasuk as $sm) {
            Arsip::create([
                'jenis_surat' => 'Masuk',
                'surat_masuk_id' => $sm->id,
                'surat_keluar_id' => null,
                'tanggal_arsip' => Carbon::now()->subDays(rand(1, 30)),
                'diarsipkan_oleh' => Pengguna::inRandomOrder()->first()->id,
            ]);
        }

        // === Arsip Surat Keluar ===
        $suratKeluar = SuratKeluar::take(5)->get();

        foreach ($suratKeluar as $sk) {
            Arsip::create([
                'jenis_surat' => 'Keluar',
                'surat_masuk_id' => null,
                'surat_keluar_id' => $sk->id,
                'tanggal_arsip' => Carbon::now()->subDays(rand(1, 30)),
                'diarsipkan_oleh' => Pengguna::inRandomOrder()->first()->id,
            ]);
        }
    }
}
