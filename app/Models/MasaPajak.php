<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasaPajak extends Model
{
    protected $table = 'masa_pajak';

    public $incrementing = false;

    protected $fillable = [
        'id', 'bulan', 'tahun'
    ];
}
