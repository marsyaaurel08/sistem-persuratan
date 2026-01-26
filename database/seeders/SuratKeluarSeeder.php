<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SuratKeluarSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // Daftar Perihal yang realistis
        $daftarPerihal = [
            'Undangan Rapat Koordinasi Tahunan',
            'Surat Pemberitahuan Cuti Bersama',
            'Pengajuan Anggaran Inventaris IT',
            'Surat Teguran Keterlambatan Vendor',
            'Permohonan Izin Kegiatan Sosialisasi',
            'Laporan Progres Pemasaran Bulanan',
            'Surat Keputusan Pengangkatan Karyawan',
            'Pemberitahuan Revisi Prosedur Operasional',
            'Permintaan Penawaran Harga Barang',
            'Surat Pengantar Pengiriman Dokumen Audit'
        ];

        $divisi = ['Keuangan', 'Marketing', 'HR', 'IT', 'Sarpras', 'Produksi'];
        $statuses = ['Pending', 'Disposisi', 'Selesai'];

        // Loop untuk membuat 20 data
        for ($i = 1; $i <= 10; $i++) {
            // Membuat waktu acak (Maksimal hari ini, tidak boleh lebih)
            $randomDate = $faker->dateTimeBetween('-5 months', 'now');
            $createdAt = Carbon::instance($randomDate);

            DB::table('surat_keluar')->insert([
                'nomor_surat'     => 'SK-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tanggal_surat'   => $createdAt->format('Y-m-d'),
                'pengirim_divisi' => $faker->randomElement($divisi),
                'penerima_id'     => $faker->numberBetween(1, 3), 
                'perihal'         => $faker->randomElement($daftarPerihal), // Mengambil dari daftar di atas
                'file_path'       => 'surat/sk-' . $i . '.pdf',
                'status'          => $faker->randomElement($statuses),
                'created_at'      => $createdAt,
                'updated_at'      => $createdAt,
            ]);
        }
    }
}