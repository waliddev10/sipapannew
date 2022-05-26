<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return User::create([
            'nama' => 'Adelia Ayuningtyas Widiyanto',
            'nip' => '200101022022012002',
            'jabatan' => 'Pengelola Pendapatan',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('@dmin')
        ]);
    }
}
