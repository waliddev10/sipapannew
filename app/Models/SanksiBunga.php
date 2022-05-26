<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanksiBunga extends Model
{
    protected $table = 'sanksi_bunga';

    protected $fillable = [
        'nilai', 'hari_min', 'hari_max', 'hari_pembagi', 'tgl_berlaku', 'keterangan'
    ];
}
