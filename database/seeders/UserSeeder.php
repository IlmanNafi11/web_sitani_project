<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'fajarfadhilah510@gmail.com',
            'password' => bcrypt("sitani"),
            'is_password_set' => false,
        ]);

        $user->assignRole('super admin');

        Admin::firstOrCreate([
            'user_id' => $user->id,
            'nama' => 'Ilman Nafi',
            'no_hp' => "085555123456",
            'alamat' => "Jl. Merapi No. 123",
        ]);
    }
}
