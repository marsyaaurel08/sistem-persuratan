<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratKeluarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('surat_keluar')->insert([
            [
                'nomor_surat' => 'SK-001',
                'tanggal_surat' => '2026-01-01',
                'pengirim_divisi' => 'Keuangan',
                'penerima_id' => 2, // pastikan pengguna id 2 ada
                'perihal' => 'Surat Pemberitahuan Pajak',
                'file_path' => 'surat/sk-001.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-002',
                'tanggal_surat' => '2026-01-02',
                'pengirim_divisi' => 'Marketing',
                'penerima_id' => 3,
                'perihal' => 'Undangan Seminar',
                'file_path' => 'surat/sk-002.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-003',
                'tanggal_surat' => '2026-01-03',
                'pengirim_divisi' => 'HR',
                'penerima_id' => 1,
                'perihal' => 'Pengumuman Libur Nasional',
                'file_path' => 'surat/sk-003.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-004',
                'tanggal_surat' => '2026-01-04',
                'pengirim_divisi' => 'IT',
                'penerima_id' => 2,
                'perihal' => 'Permintaan Backup Data',
                'file_path' => 'surat/sk-004.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-005',
                'tanggal_surat' => '2026-01-05',
                'pengirim_divisi' => 'Keuangan',
                'penerima_id' => 3,
                'perihal' => 'Tagihan Vendor',
                'file_path' => 'surat/sk-005.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-006',
                'tanggal_surat' => '2026-01-06',
                'pengirim_divisi' => 'Marketing',
                'penerima_id' => 1,
                'perihal' => 'Proposal Kerjasama',
                'file_path' => 'surat/sk-006.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-007',
                'tanggal_surat' => '2026-01-07',
                'pengirim_divisi' => 'HR',
                'penerima_id' => 2,
                'perihal' => 'Surat Cuti Karyawan',
                'file_path' => 'surat/sk-007.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-008',
                'tanggal_surat' => '2026-01-08',
                'pengirim_divisi' => 'IT',
                'penerima_id' => 3,
                'perihal' => 'Laporan Masalah Server',
                'file_path' => 'surat/sk-008.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-009',
                'tanggal_surat' => '2026-01-09',
                'pengirim_divisi' => 'Keuangan',
                'penerima_id' => 1,
                'perihal' => 'Revisi Anggaran',
                'file_path' => 'surat/sk-009.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nomor_surat' => 'SK-010',
                'tanggal_surat' => '2026-01-10',
                'pengirim_divisi' => 'Marketing',
                'penerima_id' => 2,
                'perihal' => 'Surat Penawaran Produk',
                'file_path' => 'surat/sk-010.pdf',
                'status' => 'Pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
