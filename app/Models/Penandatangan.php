<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penandatangan extends Model
{
    protected $table = 'penandatangan';

    public $incrementing = false;

    protected $fillable = [
        'id', 'nama', 'jabatan', 'nip'
    ];
}
