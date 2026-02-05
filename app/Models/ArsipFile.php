<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipFile extends Model
{
    protected $table = 'arsip_files';

    protected $fillable = [
        'arsip_id',
        'nama_file',
        'path_file',
        'ukuran_file',
        'tipe_file',
    ];

    public function arsip()
    {
        return $this->belongsTo(Arsip::class);
    }
}