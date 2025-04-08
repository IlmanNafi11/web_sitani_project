<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ManyRelationshipManagement
{
    /**
     * Menambahkan relasi dengan model utama ditable pivot
     *
     * @param \Illuminate\Database\Eloquent\Model $model Model utama
     * @param array|\Illuminate\Database\Eloquent\Collection|int $ids Id model terkait yang akan ditambahkan relasinya dari model utama
     * @param array $attributes Attribute tambahan di table pivot(opsional)
     * @return void
     */
    public function attach(Model $model, array|Collection|int $ids, array $attributes = []): bool;
    /**
     * Menghapus relasi dengan model utama ditable pivot
     *
     * @param \Illuminate\Database\Eloquent\Model $model Model utama
     * @param array|\Illuminate\Database\Eloquent\Collection|int|null $ids Id model terkait yang akan dihapus relasinya dari model utama
     * @return void
     */
    public function detach(Model $model, array|Collection|int|null $ids = null): int|null;

    /**
     * Menyinkronkan relasi many to many dengan model utama
     *
     * @param \Illuminate\Database\Eloquent\Model $model Model utama
     * @param array $relations Berisi informasi terkait model model yang seharusnya terhubung dengan model utama
     * @param bool $detaching Penentu apakah model yang tidak ada di @var array $relations harus di detach
     * @return void
     */
    public function sync(Model $model, array $relations, bool $detaching = true): array|null;
}
