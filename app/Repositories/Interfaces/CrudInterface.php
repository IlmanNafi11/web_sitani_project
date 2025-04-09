<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudInterface
{
    public function getAll($withRelations = false): Collection|array;
    public function find($id): Model|Collection|array|null;
    public function create(array $data): ?Model;
    public function update(string|int $id, array $data): Model|int|bool;
    public function delete(string|int $id): Model|int|bool;
}
