<?php

namespace Database\Seeders;

use App\Models\MasaPajak;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class MasaPajakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return MasaPajak::create([
            'id' => Uuid::uuid4(),
            'bulan' => 5,
            'tahun' => 2022,
        ]);
    }
}
