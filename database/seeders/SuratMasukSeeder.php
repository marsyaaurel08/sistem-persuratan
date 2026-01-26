<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Daftar Perihal yang realistis untuk Surat Masuk
        $daftarPerihal = [
            'Tagihan Listrik dan Air Januari 2026',
            'Surat Penawaran Kerjasama Vendor Katering',
            'Undangan Workshop Keamanan Siber',
            'Dokumen Kontrak Sewa Gedung',
            'Surat Edaran Dinas Kesehatan',
            'Permohonan Magang Mahasiswa Universitas X',
            'Laporan Hasil Audit Eksternal',
            'Pemberitahuan Maintenance Sistem Bank',
            'Surat Masuk Pengaduan Pelanggan',
            'Dokumen Pajak Tahunan Perusahaan'
        ];

        $divisiPenerima = ['Keuangan', 'Marketing', 'HR', 'IT', 'Sarpras', 'Front Office'];
        $statuses = ['Pending', 'Disposisi', 'Selesai'];

        for ($i = 1; $i <= 10; $i++) {
            // Membuat waktu acak (Maksimal hari ini)
            $randomDate = $faker->dateTimeBetween('-5 months', 'now');
            $createdAt = Carbon::instance($randomDate);

            DB::table('surat_masuk')->insert([
                'nomor_surat'     => 'SM-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tanggal_surat'   => $createdAt->format('Y-m-d'), // Tanggal surat fisik
                'pengirim_id'     => $faker->numberBetween(1, 3), // FK ke tabel pengguna
                'penerima_divisi' => $faker->randomElement($divisiPenerima),
                'perihal'         => $faker->randomElement($daftarPerihal),
                'file_path'       => 'uploads/surat_masuk/sm-' . $i . '.pdf',
                'status'          => $faker->randomElement($statuses),
                'created_at'      => $createdAt, // Digunakan untuk sortir "Aktivitas Terbaru"
                'updated_at'      => $createdAt,
            ]);
        }
    }
}