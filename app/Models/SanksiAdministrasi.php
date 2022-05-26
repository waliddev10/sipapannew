<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanksiAdministrasi extends Model
{
    protected $table = 'sanksi_administrasi';

    protected $fillable = [
        'id', 'nilai', 'tgl_batas', 'hari_min', 'tgl_berlaku', 'keterangan'
    ];
}
