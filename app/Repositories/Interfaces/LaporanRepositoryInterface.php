<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface LaporanRepositoryInterface
{
    /**
     * Mengambil data laporan berdasarkan penyuluh Id
     *
     * @param array $conditions Kondisi(where) untuk filter data
     * @param array $relations Relasi
     * @return Collection|array
     */
    public function getByPenyuluhId(array $conditions = [], array $relations = []): Collection|array;

    /**
     * Menghitung total laporan yang masuk ke aplikasi
     *
     * @return int Total Data laporan
     */
    public function calculateTotal(): int;

    /**
     * Menghitung total penggunaan bibit berkualitas
     *
     * @return array Hasil rekap Penggunaan Bibit(berkualitas, tidak berkualitas, dan laporan yang masih pending)
     */
    public function getLaporanStatusCounts(): array;

}
