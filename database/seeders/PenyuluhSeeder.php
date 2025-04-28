<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Penyuluh;
use App\Models\PenyuluhTerdaftar;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenyuluhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatan = Kecamatan::create([
            'nama' => 'Kecamatan test',
        ]);

        $user = User::create([
            'email' => 'officialsitani@gmail.com',
            'password' => bcrypt('Admin1234#'),
            'is_password_set' => true,
        ]);

        $penyuluhTerdaftar = PenyuluhTerdaftar::create([
            'nama' => 'Penyuluh 1',
            'no_hp' => '085666777555',
            'alamat' => 'Jalan imphen',
            'kecamatan_id' => $kecamatan->id,
        ]);

        $user->assignRole('penyuluh', 'api');

        $penyuluh = Penyuluh::create([
            'user_id' => $user->id,
            'penyuluh_terdaftar_id' => $penyuluhTerdaftar->id,
        ]);
    }
}
