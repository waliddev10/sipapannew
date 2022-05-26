<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penandatangan extends Model
{
    protected $table = 'penandatangan';

    protected $fillable = [
        'id', 'nama', 'jabatan', 'nip'
    ];
}
