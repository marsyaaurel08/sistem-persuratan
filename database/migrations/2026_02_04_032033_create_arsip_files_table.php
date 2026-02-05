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
        Schema::create('arsip_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('arsip_id')
                ->constrained('arsip')
                ->cascadeOnDelete();

            $table->string('nama_file');
            $table->string('path_file');
            $table->bigInteger('ukuran_file');
            $table->string('tipe_file');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_files');
    }
};
