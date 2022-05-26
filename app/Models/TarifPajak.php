<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifPajak extends Model
{
    protected $table = 'tarif_pajak';

    protected $fillable = [
        'nilai', 'tgl_berlaku', 'keterangan'
    ];
}
