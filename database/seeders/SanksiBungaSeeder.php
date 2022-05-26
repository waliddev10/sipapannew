<?php

namespace Database\Seeders;

use App\Models\SanksiBunga;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

class SanksiBungaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return SanksiBunga::insert(
            [
                [
                    'nilai' => 0.02,
                    'hari_min' => 15,
                    'hari_max' => 15 * 30,
                    'hari_pembagi' => 30,
                    'tgl_berlaku' => '2022-01-01',
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]
        );
    }
}
