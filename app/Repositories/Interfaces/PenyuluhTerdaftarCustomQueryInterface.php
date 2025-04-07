<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PenyuluhTerdaftarCustomQueryInterface
{
    /**
     * Mengambil data penyuluh terdaftar berdasarkan Id kecamatan
     *
     * @param string|int $id
     * @return Collection
     */
    public function getByKecamatanId(string|int $id): Collection;
}
