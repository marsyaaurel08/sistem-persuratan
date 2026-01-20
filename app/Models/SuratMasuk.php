<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

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

    // relasi ke pengguna (pengirim)
    public function pengirim()
    {
        return $this->belongsTo(Pengguna::class, 'pengirim_id');
    }
}
