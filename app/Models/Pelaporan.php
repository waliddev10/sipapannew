<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    protected $table = 'pelaporan';

    public $incrementing = false;

    protected $fillable = [
        'id', 'masa_pajak_id', 'perusahaan_id', 'tgl_pelaporan', 'volume', 'cara_pelaporan_id', 'file'
    ];
}
