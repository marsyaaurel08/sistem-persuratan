<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('surat_masuk')->insert([
            [
                'nomor_surat' => 'SM-001',
                'tanggal_surat' => '2026-01-01',
                'pengirim_id' => 1, // pastikan user id 1 ada di tabel pengguna
                'penerima_divisi' => 'Keuangan',
                'perihal' => 'Surat Pemberitahuan Pajak',
                'file_path' => 'surat/sm-001.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-002',
                'tanggal_surat' => '2026-01-02',
                'pengirim_id' => 2,
                'penerima_divisi' => 'Marketing',
                'perihal' => 'Undangan Seminar',
                'file_path' => 'surat/sm-002.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-003',
                'tanggal_surat' => '2026-01-03',
                'pengirim_id' => 3,
                'penerima_divisi' => 'HR',
                'perihal' => 'Pengumuman Libur Nasional',
                'file_path' => 'surat/sm-003.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-004',
                'tanggal_surat' => '2026-01-04',
                'pengirim_id' => 1,
                'penerima_divisi' => 'IT',
                'perihal' => 'Permintaan Backup Data',
                'file_path' => 'surat/sm-004.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-005',
                'tanggal_surat' => '2026-01-05',
                'pengirim_id' => 2,
                'penerima_divisi' => 'Keuangan',
                'perihal' => 'Tagihan Vendor',
                'file_path' => 'surat/sm-005.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-006',
                'tanggal_surat' => '2026-01-06',
                'pengirim_id' => 3,
                'penerima_divisi' => 'Marketing',
                'perihal' => 'Proposal Kerjasama',
                'file_path' => 'surat/sm-006.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-007',
                'tanggal_surat' => '2026-01-07',
                'pengirim_id' => 1,
                'penerima_divisi' => 'HR',
                'perihal' => 'Surat Cuti Karyawan',
                'file_path' => 'surat/sm-007.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-008',
                'tanggal_surat' => '2026-01-08',
                'pengirim_id' => 2,
                'penerima_divisi' => 'IT',
                'perihal' => 'Laporan Masalah Server',
                'file_path' => 'surat/sm-008.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-009',
                'tanggal_surat' => '2026-01-09',
                'pengirim_id' => 3,
                'penerima_divisi' => 'Keuangan',
                'perihal' => 'Revisi Anggaran',
                'file_path' => 'surat/sm-009.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SM-010',
                'tanggal_surat' => '2026-01-10',
                'pengirim_id' => 1,
                'penerima_divisi' => 'Marketing',
                'perihal' => 'Surat Penawaran Produk',
                'file_path' => 'surat/sm-010.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
