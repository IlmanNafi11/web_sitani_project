<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudInterface
{
    /**
     * Mengambil seluruh data
     *
     * @param bool $withRelations Default false, set true untuk mengambil data beserta relasi
     * @return Collection|array Data
     */
    public function getAll(bool $withRelations = false): Collection|array;

    /**
     * Mengambil data berdasarkan id
     *
     * @param string|int $id Id data
     * @return Model|Collection|array|null
     */
    public function getById(string|int $id): Model|Collection|array|null;

    /**
     * Membuat data baru
     *
     * @param array $data Data baru
     * @return Model|null
     */
    public function create(array $data): ?Model;

    /**
     * Memperbarui data
     *
     * @param string|int $id Id data
     * @param array $data Data baru
     * @return Model|int|bool
     */
    public function update(string|int $id, array $data): Model|int|bool;

    /**
     * Menghapus data
     *
     * @param string|int $id Id data
     * @return Model|int|bool
     */
    public function delete(string|int $id): Model|int|bool;
}
