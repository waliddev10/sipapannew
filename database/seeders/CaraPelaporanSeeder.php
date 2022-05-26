<?php

namespace Database\Seeders;

use App\Models\CaraPelaporan;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class CaraPelaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return CaraPelaporan::create([
            'nama' => 'Pesan WhatsApp',
        ]);
    }
}
