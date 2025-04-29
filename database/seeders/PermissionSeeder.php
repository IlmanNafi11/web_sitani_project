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

            // Bibit Berkualitas
            'bibit.lihat',
            'bibit.tambah',
            'bibit.ubah',
            'bibit.hapus',
            'bibit.import',
            'bibit.export',

            // Komoditas
            'komoditas.lihat',
            'komoditas.tambah',
            'komoditas.ubah',
            'komoditas.hapus',
            'komoditas.import',
            'komoditas.export',

            // Penyuluh Terdaftar
            'penyuluh.lihat',
            'penyuluh.tambah',
            'penyuluh.ubah',
            'penyuluh.hapus',
            'penyuluh.import',
            'penyuluh.export',

            // Kelompok Tani
            'kelompok-tani.lihat',
            'kelompok-tani.tambah',
            'kelompok-tani.ubah',
            'kelompok-tani.hapus',
            'kelompok-tani.import',
            'kelompok-tani.export',

            // Desa
            'desa.lihat',
            'desa.tambah',
            'desa.ubah',
            'desa.hapus',
            'desa.import',
            'desa.export',

            // Kecamatan
            'kecamatan.lihat',
            'kecamatan.tambah',
            'kecamatan.ubah',
            'kecamatan.hapus',
            'kecamatan.import',
            'kecamatan.export',

            // Laporan Bibit
            'laporan-bibit.lihat',
            'laporan-bibit.ubah',
            'laporan-bibit.hapus',
            'laporan-bibit.export',

            // Laporan Hibah
            'laporan-hibah.lihat',
            'laporan-hibah.ubah',
            'laporan-hibah.hapus',
            'laporan-hibah.export',

            // Admin
            'admin.lihat',
            'admin.tambah',
            'admin.ubah',
            'admin.hapus',
            'admin.import',
            'admin.export',

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
