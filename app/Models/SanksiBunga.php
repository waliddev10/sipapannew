<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanksiBunga extends Model
{
    protected $table = 'sanksi_bunga';

    public $incrementing = false;

    protected $fillable = [
        'id', 'nilai', 'hari_min', 'hari_max', 'hari_pembagi', 'tgl_berlaku', 'keterangan'
    ];
}
