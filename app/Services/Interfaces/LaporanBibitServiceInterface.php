<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface LaporanBibitServiceInterface
{
    public function getAll(bool $withRelations = false): Collection;

    public function getById(string|int $id): Model;

    public function update(string|int $id, array $data): bool;

    public function delete(string|int $id): bool;
}
