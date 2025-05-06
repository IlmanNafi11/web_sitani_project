<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface LaporanBibitRepositoryInterface extends BaseRepositoryInterface
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
     * @param int|null $penyuluhId Id penyuluh, kirim id penyuluh jika mengambil total laporan berdasarkan penyuluh(pelapor), default = null(keseluruhan)
     * @return array Hasil rekap Penggunaan Bibit(berkualitas, tidak berkualitas, dan laporan yang masih pending)
     */
    public function getLaporanStatusCounts(?int $penyuluhId = null): array;

}
