<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PenyuluhTerdaftarCustomQueryInterface
{
    /**
     * Mengambil data penyuluh terdaftar berdasarkan Id kecamatan
     *
     * @param string|int $id
     * @return Collection
     */
    public function getByKecamatanId(string|int $id): Collection;

    /**
     * Mengambil data penyuluh terdaftar berdasarkan no hp
     *
     * @param string $phone Nomor hp Penyuluh
     * @return Model|null
     */
    public function getByPhone(string $phone): ?Model;
}
