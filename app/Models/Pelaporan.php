<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    protected $table = 'pelaporan';

    protected $fillable = [
        'masa_pajak_id',
        'perusahaan_id',
        'tgl_pelaporan',
        'volume',
        'cara_pelaporan_id',
        'file'
    ];

    public function cara_pelaporan()
    {
        return $this->belongsTo(CaraPelaporan::class);
    }

    public function masa_pajak()
    {
        return $this->belongsTo(MasaPajak::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
