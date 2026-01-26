<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'divisi'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    // 🔗 Surat Masuk yang dikirim user
    public function suratMasuk()
    {
        return $this->hasMany(SuratMasuk::class, 'pengirim_id');
    }

    // 🔗 Surat Keluar yang diterima user
    public function suratKeluar()
    {
        return $this->hasMany(SuratKeluar::class, 'penerima_id');
    }

    // 🔗 Arsip oleh user
    public function arsip()
    {
        return $this->hasMany(Arsip::class, 'diarsipkan_oleh');
    }
}
