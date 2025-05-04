<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface KomoditasApiServiceInterface
{
    public function getAllApi(bool $withRelations = false): Collection;

    public function getById(string|int $id): Model;

    public function GetMusim(): Collection;

    public function calculateTotal(): int;
}
