<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Npa extends Model
{
    protected $table = 'npa';

    protected $fillable = [
        'volume_min', 'volume_max', 'nilai', 'jenis_usaha_id', 'tgl_berlaku', 'keterangan'
    ];

    public function jenis_usaha()
    {
        return $this->belongsTo(JenisUsaha::class);
    }
}
