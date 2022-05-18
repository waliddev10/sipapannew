<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KotaPenandatangan extends Model
{
    protected $table = 'kota_penandatangan';

    public $incrementing = false;

    protected $fillable = [
        'id', 'nama'
    ];
}
