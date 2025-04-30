<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface DesaRepositoryInterface
{
    /**
     * Mengambil data desa berdasarkan Id kecamatan
     *
     * @param int|string $id Id kecamatan
     * @return Collection
     */
    public function getByKecamatanId(int|string $id): Collection;
}
