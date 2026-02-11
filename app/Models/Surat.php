<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        // KOP
        'logo_kiri',
        'logo_kanan',
        'kop_instansi',
        'kop_alamat',
        'kop_telp',
        'kop_email',
        'kop_web',

        // INFO SURAT
        'nomor_surat',
        'perihal',
        'tanggal_surat',

        // ISI
        'isi_surat',

        // META
        'user_id',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    /**
     * Surat dibuat oleh user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
