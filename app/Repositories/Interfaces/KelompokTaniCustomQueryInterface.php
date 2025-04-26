<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface KelompokTaniCustomQueryInterface
{
    /**
     * Mengambil data kelompok tani berdasarkan penyuluh id
     *
     * @param array $id Id kelompok tani
     * @return Collection|array
     */
    public function getByPenyuluhId(array $id): Collection|array;
}
