<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarifPajak extends Model
{
    protected $table = 'tarif_pajak';

    protected $fillable = [
        'id', 'nilai', 'tgl_berlaku', 'keterangan'
    ];
}
