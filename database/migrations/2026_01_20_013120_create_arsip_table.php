<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();

            // Jenis surat yang diarsipkan
            $table->enum('jenis_surat', ['Masuk', 'Keluar']);

            // Relasi ke surat masuk / keluar (salah satu terisi)
            $table->foreignId('surat_masuk_id')
                  ->nullable()
                  ->constrained('surat_masuk')
                  ->cascadeOnDelete();

            $table->foreignId('surat_keluar_id')
                  ->nullable()
                  ->constrained('surat_keluar')
                  ->cascadeOnDelete();

            // Metadata arsip
            $table->string('kode_arsip', 50)->unique();
            $table->string('lokasi_fisik', 100)->nullable(); // lemari / rak / box
            $table->date('tanggal_arsip');

            // Siapa yang mengarsipkan
            $table->foreignId('diarsipkan_oleh')
                  ->constrained('pengguna')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip');
    }
};
