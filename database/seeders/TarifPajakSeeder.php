<?php

namespace Database\Seeders;

use App\Models\TarifPajak;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class TarifPajakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return TarifPajak::create([
            'nilai' => 10 / 100,
            'tgl_berlaku' => '2022-01-01',
            'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
        ]);
    }
}
