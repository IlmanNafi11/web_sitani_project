<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface DesaCustomQueryInterface
{
    /**
     * Mengambil data desa berdasarkan Id kecamatan
     *
     * @param int|string $id Id kecamatan
     * @return Collection
     */
    public function getByKecamatanId($id): Collection;
}
