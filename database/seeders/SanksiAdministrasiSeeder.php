<?php

namespace Database\Seeders;

use App\Models\SanksiAdministrasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

class SanksiAdministrasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return SanksiAdministrasi::insert(
            [
                [
                    'id' => Uuid::uuid4(),
                    'nilai' => 25000,
                    'tgl_batas' => 3,
                    'hari_min' => 20,
                    'tgl_berlaku' => '2022-01-01',
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }
}
