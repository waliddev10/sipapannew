<?php

namespace Database\Seeders;

use App\Models\JenisUsaha;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class JenisUsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return JenisUsaha::insert(
            [
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Non Niaga',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Niaga Kecil',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Niaga Besar',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Industri Kecil',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Industri Besar',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'BUMD',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]
        );
    }
}
