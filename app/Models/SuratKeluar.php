<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar'; // Sesuai migration

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
        'tanggal_surat' => 'date',
    ];
    
    public $timestamps = true;

    // Relasi ke User (Pengguna)
    public function penerima()
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }
}
