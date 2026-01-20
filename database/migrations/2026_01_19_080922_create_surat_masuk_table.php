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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat', 50); // Nomor surat masuk
            $table->date('tanggal_surat'); // Tanggal surat diterima
            $table->foreignId('pengirim_id')->nullable()->constrained('pengguna')->cascadeOnDelete(); // FK ke pengguna
            $table->string('penerima_divisi', 100); // Divisi atau orang yang menerima surat
            $table->string('perihal', 255); // Judul atau isi surat
            $table->string('file_path', 255)->nullable(); // File surat (PDF/DOC)
            $table->enum('status', ['Pending','Disposisi','Selesai'])->default('Pending'); // Status surat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
