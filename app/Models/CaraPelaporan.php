<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaraPelaporan extends Model
{
    protected $table = 'cara_pelaporan';

    public $incrementing = false;

    protected $fillable = [
        'id', 'nama'
    ];
}
