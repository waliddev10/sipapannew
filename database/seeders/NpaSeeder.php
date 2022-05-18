<?php

namespace Database\Seeders;

use App\Models\JenisUsaha;
use App\Models\Npa;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class NpaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $industri_besar = JenisUsaha::where('nama', 'Industri Besar')->first();

        $bumd = JenisUsaha::where('nama', 'BUMD')->first();

        return Npa::insert(
            [
                [
                    'id' => Uuid::uuid4(),
                    'volume_min' => 0,
                    'volume_max' => 50,
                    'nilai' => 1091,
                    'jenis_usaha_id' => $industri_besar->id,
                    'tgl_berlaku' => Carbon::yesterday(),
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'volume_min' => 51,
                    'volume_max' => 500,
                    'nilai' => 1141,
                    'jenis_usaha_id' => $industri_besar->id,
                    'tgl_berlaku' => Carbon::yesterday(),
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'volume_min' => 501,
                    'volume_max' => 1000,
                    'nilai' => 1190,
                    'jenis_usaha_id' => $industri_besar->id,
                    'tgl_berlaku' => Carbon::yesterday(),
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'volume_min' => 1001,
                    'volume_max' => 2500,
                    'nilai' => 1240,
                    'jenis_usaha_id' => $industri_besar->id,
                    'tgl_berlaku' => Carbon::yesterday(),
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'volume_min' => 2501,
                    'volume_max' => null,
                    'nilai' => 1290,
                    'jenis_usaha_id' => $industri_besar->id,
                    'tgl_berlaku' => Carbon::yesterday(),
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'volume_min' => 0,
                    'volume_max' => null,
                    'nilai' => 100,
                    'jenis_usaha_id' => $bumd->id,
                    'created_at' => Carbon::now(),
                    'tgl_berlaku' => Carbon::yesterday(),
                    'keterangan' => 'PERATURAN GUBERNUR KALIMANTAN TIMUR NO.10 TAHUN 2011',
                    'updated_at' => Carbon::now()
                ],
            ]
        );
    }
}
