<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Penyuluh;
use App\Models\PenyuluhTerdaftar;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PenyuluhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatan = Kecamatan::firstOrCreate([
            'nama' => 'Kecamatan test',
        ]);

        $user = User::firstOrCreate(
            [
                'email' => 'officialsitani@gmail.com',],
            [
                'password' => bcrypt('Admin1234#'),
                'is_password_set' => true,
            ]);

        $penyuluhTerdaftar = PenyuluhTerdaftar::firstOrCreate([
            'nama' => 'Penyuluh 1',
            'no_hp' => '085666777555',
            'alamat' => 'Jalan imphen',
            'kecamatan_id' => $kecamatan->id,
        ]);

        $rolePenyuluh = Role::where('name', 'penyuluh')->first();
        if ($rolePenyuluh) {
            $user->assignRole($rolePenyuluh);
        }

        $penyuluh = Penyuluh::firstOrCreate([
            'user_id' => $user->id,
            'penyuluh_terdaftar_id' => $penyuluhTerdaftar->id,
        ]);
    }
}
