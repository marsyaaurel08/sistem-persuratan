<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Arsip;
use App\Models\User;
use Carbon\Carbon;

class ArsipSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id');

        if ($users->isEmpty()) {
            $this->command->warn('Seeder Arsip dilewati karena tidak ada user.');
            return;
        }

        $data = [
            [
                'kategori' => 'Masuk',
                'nomor_surat' => 'SM-001/IT/2025',
                'perihal' => 'Undangan Rapat Koordinasi',
            ],
            [
                'kategori' => 'Keluar',
                'nomor_surat' => 'SK-015/IT/2025',
                'perihal' => 'Surat Tugas Dinas',
            ],
            [
                'kategori' => 'Laporan',
                'nomor_surat' => null,
                'perihal' => 'Laporan Kegiatan Magang Mahasiswa',
            ],
        ];

        foreach ($data as $item) {
            Arsip::create([
                'kategori' => $item['kategori'],
                'nomor_surat' => $item['nomor_surat'],
                'perihal' => $item['perihal'],
                'tanggal_arsip' => Carbon::now()->subDays(rand(1, 30)),
                'kode_arsip' => 'ARS/' . date('Y') . '/' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'lokasi_fisik' => 'Lemari A - Rak ' . rand(1, 5),
                'diarsipkan_oleh' => $users->random(),
            ]);
        }
    }
}
