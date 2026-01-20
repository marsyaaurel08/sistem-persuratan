<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $table = 'surat_masuk'; // Sesuai migration

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim_id',
        'penerima_divisi',
        'perihal',
        'file_path',
        'status'
    ];

    public $timestamps = true;

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    // Relasi ke User (Pengguna)
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
}
