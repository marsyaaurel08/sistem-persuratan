<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add temporary name field
        Schema::table('arsip', function (Blueprint $table) {
            $table->string('diarsipkan_nama')->nullable()->after('diarsipkan_oleh');
        });

        // Make diarsipkan_oleh nullable to allow inserts without auth
        Schema::table('arsip', function (Blueprint $table) {
            $table->unsignedBigInteger('diarsipkan_oleh')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('arsip', function (Blueprint $table) {
            $table->dropColumn('diarsipkan_nama');
        });

        Schema::table('arsip', function (Blueprint $table) {
            $table->unsignedBigInteger('diarsipkan_oleh')->nullable(false)->change();
        });
    }
};
