<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SuratKeluar extends Model
{
    use HasFactory;

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

    // relasi ke pengguna (penerima)
    public function penerima()
    {
        return $this->belongsTo(Pengguna::class, 'penerima_id');
    }
}
