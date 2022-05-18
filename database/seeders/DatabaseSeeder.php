<?php

use Database\Seeders\UserSeeder;
use Database\Seeders\CaraPelaporanSeeder;
use Database\Seeders\TanggalLiburSeeder;
use Database\Seeders\JenisUsahaSeeder;
use Database\Seeders\KotaPenandatanganSeeder;
use Database\Seeders\MasaPajakSeeder;
use Database\Seeders\NpaSeeder;
use Database\Seeders\PenandatanganSeeder;
use Database\Seeders\SanksiAdministrasiSeeder;
use Database\Seeders\SanksiBungaSeeder;
use Database\Seeders\TarifPajakSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(KotaPenandatanganSeeder::class);
        $this->call(PenandatanganSeeder::class);
        $this->call(JenisUsahaSeeder::class);
        $this->call(MasaPajakSeeder::class);
        $this->call(TarifPajakSeeder::class);
        $this->call(CaraPelaporanSeeder::class);
        $this->call(NpaSeeder::class);
        $this->call(TanggalLiburSeeder::class);
        $this->call(SanksiAdministrasiSeeder::class);
        $this->call(SanksiBungaSeeder::class);
    }
}
