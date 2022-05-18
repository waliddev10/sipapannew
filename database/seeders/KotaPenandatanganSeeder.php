<?php

namespace Database\Seeders;

use App\Models\KotaPenandatangan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class KotaPenandatanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return KotaPenandatangan::insert(
            [
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Penajam',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Samarinda',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }
}
