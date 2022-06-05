<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penetapan extends Model
{
    protected $table = 'penetapan';

    protected $fillable = [
        'pelaporan_id',
        'no_penetapan',
        'tgl_penetapan',
        'penandatangan_id',
        'kota_penandatangan_id'
    ];

    public function pelaporan()
    {
        return $this->belongsTo(Pelaporan::class);
    }

    public function penandatangan()
    {
        return $this->belongsTo(Penandatangan::class);
    }

    public function kota_penandatangan()
    {
        return $this->belongsTo(KotaPenandatangan::class);
    }
}
