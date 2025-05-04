<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface KelompokTaniApiServiceInterface
{
    public function getAllByPenyuluhId(array $penyuluhIds): Collection;

    public function getById(string|int $id): Model;

    public function calculateTotal(): int;

    public function countByKecamatanId(string|int $id): int;
}
