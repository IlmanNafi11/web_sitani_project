<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface LaporanBibitApiServiceInterface
{
    public function create(array $data): Model;

    public function getByPenyuluhId(string|int $penyuluhId): Collection;

    public function getLaporanStatusCounts(string|int $penyuluhId): array;
}
