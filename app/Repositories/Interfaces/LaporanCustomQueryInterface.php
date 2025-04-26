<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface LaporanCustomQueryInterface
{
    public function getByPenyuluhId(array $conditions = [], array $relations = []): Collection|array;

}
