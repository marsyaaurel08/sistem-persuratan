<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim_id',
        'penerima_divisi',
        'perihal',
        'file_path',
        'status'
    ];

    protected $casts = [
        'tanggal_surat' => 'date'
    ];

    // 🔗 Pengirim (Pengguna)
    public function pengirim()
    {
        return $this->belongsTo(Pengguna::class, 'pengirim_id');
    }

    // 🔗 Arsip
    public function arsip()
    {
        return $this->hasOne(Arsip::class);
    }

}
