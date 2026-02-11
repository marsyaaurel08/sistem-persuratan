<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Arsip;
use App\Models\User;
use App\Models\ArsipFile;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ArsipSeeder extends Seeder
{
    public function run(): void
    {
        // $pengguna = User::pluck('id');

        //     if ($pengguna->isEmpty()) {
        //         $this->command->warn('⚠️ Seeder Arsip dilewati karena tabel pengguna kosong.');
        //         return;
        //     }

        $userId = 1;

        $fileNames = [
            '1770257823_6srxgOPQ0m.pdf',
        ];

        $kategoriOptions = ['Masuk', 'Keluar', 'Laporan'];

        $perihalSamples = [
            'Undangan Rapat Koordinasi',
            'Laporan Keuangan Bulanan',
            'Permintaan Pengadaan Barang',
            'Surat Tugas Dinas Luar',
            'Laporan Kegiatan Tahunan',
            'Notulen Rapat Proyek',
            'Pemberitahuan Kunjungan Lapangan',
            'Surat Permohonan Cuti',
            'Berita Acara Serah Terima',
            'Laporan Monitoring dan Evaluasi',
            'Surat Peringatan Kinerja',
            'Laporan Inventaris Barang',
            'Surat Edaran Internal',
            'Laporan Akhir Proyek',
            'Dokumentasi Kegiatan Sosial',
            'Laporan Audit Tahunan',
            'Surat Peminjaman Barang',
            'Laporan Evaluasi Semester',
            'Surat Perintah Kerja',
            'Laporan Penutupan Tahun',
            'Surat Edaran Pimpinan',
        ];

        for ($i = 0; $i < 40; $i++) {
            $kategori = $kategoriOptions[array_rand($kategoriOptions)];
            $perihal = $perihalSamples[$i] ?? 'Dokumen Arsip #' . ($i + 1);

            // Selalu buat nomor surat unik, termasuk untuk "Laporan"
            $prefix = match ($kategori) {
                'Masuk' => 'SM',
                'Keluar' => 'SK',
                'Laporan' => 'LP',
                default => 'AR',
            };

            $nomorSurat = $prefix . '-' . date('Y') . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);

            // Generate kode arsip unik
            do {
                $kodeArsip = 'ARS/' . date('Y') . '/' . strtoupper(Str::random(6));
            } while (Arsip::where('kode_arsip', $kodeArsip)->exists());

            // Buat data arsip
            $arsip = Arsip::create([
                'kategori' => $kategori,
                'nomor_surat' => $nomorSurat,
                'perihal' => $perihal,
                'tanggal_arsip' => Carbon::now()->subDays(rand(1, 60)),
                'kode_arsip' => $kodeArsip,
                'diarsipkan_oleh' => $userId,
            ]);

            // Pilih salah satu file dari daftar kamu
            $fileName = $fileNames[array_rand($fileNames)];

            // Tambahkan data ke tabel arsip_files
            ArsipFile::create([
                'arsip_id'   => $arsip->id,
                'nama_file'  => $fileName,
                'path_file'  => 'uploads/arsip/' . $fileName,
                'ukuran_file' => 1024, // contoh ukuran dummy
                'tipe_file'  => 'application/pdf',
            ]);
        }

        $this->command->info('✅ Seeder ArsipSeeder berhasil membuat 40 arsip lengkap dengan nomor surat dan file PDF.');
    }
}
