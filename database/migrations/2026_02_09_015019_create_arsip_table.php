<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();

            // Kategori arsip
            $table->enum('kategori', ['Masuk', 'Keluar', 'Laporan']);

            // Informasi surat
            $table->string('nomor_surat', 100)->nullable();
            $table->string('perihal', 255);

            // Metadata arsip
            $table->date('tanggal_arsip');
            $table->string('kode_arsip', 50)->unique()->nullable();
            //$table->string('lokasi_fisik', 100)->nullable();

            // User yang mengarsipkan (login)
            $table->foreignId('diarsipkan_oleh')
                  ->constrained('pengguna')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
