<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaan';

    protected $fillable = [
        'nama', 'alamat', 'tgl_penetapan', 'hp_pj', 'nama_pj', 'jenis_usaha_id', 'email'
    ];

    public function jenis_usaha()
    {
        return $this->belongsTo(JenisUsaha::class);
    }
}
