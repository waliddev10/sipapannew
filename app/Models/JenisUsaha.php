<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisUsaha extends Model
{
    protected $table = 'jenis_usaha';

    public $incrementing = false;

    protected $fillable = [
        'id', 'nama'
    ];
}
