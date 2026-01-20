<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim_divisi',
        'penerima_id',
        'perihal',
        'file_path',
        'status'
    ];

    protected $casts = [
        'tanggal_surat' => 'date'
    ];

    // 🔗 Penerima (Pengguna)
    public function penerima()
    {
        return $this->belongsTo(Pengguna::class, 'penerima_id');
    }

    // 🔗 Arsip
    public function arsip()
    {
        return $this->hasOne(Arsip::class);
    }
}
