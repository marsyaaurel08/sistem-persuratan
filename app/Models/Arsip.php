<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Arsip extends Model
{
    protected $table = 'arsip';

    protected $fillable = [
        'kode_arsip',
        'jenis_surat',
        'surat_masuk_id',
        'surat_keluar_id',
        'tanggal_arsip',
        'diarsipkan_oleh'
    ];

    protected static function booted()
    {
        static::creating(function ($arsip) {
            if (empty($arsip->diarsipkan_oleh) && Auth::id()) {
                $arsip->diarsipkan_oleh = Auth::id();
            }

            // use the year from tanggal_arsip (or now if not set)
            $tanggal = $arsip->tanggal_arsip ?? Carbon::now()->toDateString();
            $tahun = Carbon::parse($tanggal)->year;

            // get current max suffix for that year to avoid duplicates
            $max = Arsip::where('kode_arsip', 'like', "ARS/{$tahun}/%")
                ->selectRaw('MAX(CAST(RIGHT(kode_arsip,4) AS UNSIGNED)) as maxnum')
                ->value('maxnum');

            $nomor = $max ? ((int) $max + 1) : 1;
            $kode = str_pad($nomor, 4, '0', STR_PAD_LEFT);
            $arsip->kode_arsip = "ARS/{$tahun}/{$kode}";
        });
    }

    // RELATION
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class);
    }

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }
    public function pengarsip()
    {
        return $this->belongsTo(User::class, 'diarsipkan_oleh');
    }
}
