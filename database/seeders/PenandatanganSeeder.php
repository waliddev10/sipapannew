<?php

namespace Database\Seeders;

use App\Models\Penandatangan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PenandatanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Penandatangan::insert(
            [
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'Donny Marisya, S.E.',
                    'jabatan' => 'Kasi Pendataan & Penetapan',
                    'nip' => '19760201 200212 1 009',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Uuid::uuid4(),
                    'nama' => 'H. Arifin, S.Sos.',
                    'jabatan' => 'Kepala',
                    'nip' => '19661104 199002 2 002',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]
        );
    }
}
