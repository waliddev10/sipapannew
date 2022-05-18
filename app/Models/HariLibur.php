<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'hari_libur';

    public $incrementing = false;

    protected $fillable = [
        'id', 'tgl_libur', 'dasar_hukum', 'keterangan'
    ];
}
