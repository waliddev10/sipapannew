<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TanggalLibur extends Model
{
    protected $table = 'tanggal_libur';

    protected $fillable = [
        'tgl_libur', 'dasar_hukum', 'keterangan'
    ];
}
