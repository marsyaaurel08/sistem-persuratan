<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Arsip extends Model
{
    protected $table = 'arsip';

    protected $fillable = [
        'kategori',
        'nomor_surat',
        'perihal',
        'tanggal_arsip',
        'kode_arsip',
        //'lokasi_fisik',
        'diarsipkan_oleh',
    ];

    protected $casts = [
        'tanggal_arsip' => 'date',
    ];

    public const KATEGORI = [
        'Masuk'   => 'Surat Masuk',
        'Keluar'  => 'Surat Keluar',
        'Laporan' => 'Laporan',
    ];

    /**
     * Auto-generate kode arsip & set user login
     */
    protected static function booted()
    {
        static::creating(function ($arsip) {

            // Set user login otomatis
            if (empty($arsip->diarsipkan_oleh) && Auth::check()) {
                $arsip->diarsipkan_oleh = Auth::id();
            }

            // Jangan override kalau sudah di-set manual
            if (!empty($arsip->kode_arsip)) {
                return;
            }

            // Ambil tahun dari tanggal arsip (atau sekarang)
            $tanggal = $arsip->tanggal_arsip ?? Carbon::now();
            $tahun = Carbon::parse($tanggal)->year;

            // Ambil nomor terakhir di tahun yang sama
            $max = self::whereYear('tanggal_arsip', $tahun)
                ->selectRaw('MAX(CAST(RIGHT(kode_arsip,4) AS UNSIGNED)) as maxnum')
                ->value('maxnum');

            $nomor = $max ? $max + 1 : 1;
            $urut = str_pad($nomor, 4, '0', STR_PAD_LEFT);

            $arsip->kode_arsip = "ARS/{$tahun}/{$urut}";
        });
    }


    public function pengarsip()
    {
        return $this->belongsTo(Pengguna::class, 'diarsipkan_oleh');
    }

    public function files()
    {
        return $this->hasMany(ArsipFile::class, 'arsip_id');
    }

    
}
