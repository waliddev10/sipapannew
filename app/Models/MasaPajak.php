<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasaPajak extends Model
{
    protected $table = 'masa_pajak';

    protected $fillable = [
        'bulan', 'tahun'
    ];
}
