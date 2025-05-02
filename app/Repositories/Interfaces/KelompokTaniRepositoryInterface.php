<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface KelompokTaniRepositoryInterface
{
    /**
     * Mengambil data kelompok tani berdasarkan penyuluh id
     *
     * @param array $id Id kelompok tani
     * @return Collection|array
     */
    public function getByPenyuluhId(array $id): Collection|array;

    /**
     * Menghitung total kelompok tani yang terdaftar di aplikasi
     *
     * @return int Total Data kelompok tani
     */
    public function calculateTotal(): int;

    /**
     * Mengambil total kelompok tani berdasarkan kecamatan id
     *
     * @param string|int $id kecamatan id
     * @return int
     */
    public function countByKecamatanId(string|int $id): int;
}
