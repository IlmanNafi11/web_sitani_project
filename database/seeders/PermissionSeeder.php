<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Dashboard
            'dashboard.lihat',

            // Bibit Berkualitas
            'bibit.lihat',
            'bibit.tambah',
            'bibit.ubah',
            'bibit.hapus',

            // Komoditas
            'komoditas.lihat',
            'komoditas.tambah',
            'komoditas.ubah',
            'komoditas.hapus',

            // Penyuluh Terdaftar
            'penyuluh.lihat',
            'penyuluh.tambah',
            'penyuluh.ubah',
            'penyuluh.hapus',

            // Kelompok Tani
            'kelompok-tani.lihat',
            'kelompok-tani.tambah',
            'kelompok-tani.ubah',
            'kelompok-tani.hapus',

            // Desa
            'desa.lihat',
            'desa.tambah',
            'desa.ubah',
            'desa.hapus',

            // Kecamatan
            'kecamatan.lihat',
            'kecamatan.tambah',
            'kecamatan.ubah',
            'kecamatan.hapus',

            // Laporan Bibit
            'laporan-bibit.lihat',
            'laporan-bibit.ubah',
            'laporan-bibit.hapus',

            // Laporan Hibah
            'laporan-hibah.lihat',
            'laporan-hibah.ubah',
            'laporan-hibah.hapus',

            // Admin
            'admin.lihat',
            'admin.tambah',
            'admin.ubah',
            'admin.hapus',

            // Role & Permission
            'role-permission.lihat',
            'role-permission.tambah',
            'role-permission.ubah',
            'role-permission.hapus',

            // Panel. Jangan dihapus biar bisa akses ke panel admin
            'akses-panel.Akses ke Panel Admin',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }
    }
}
