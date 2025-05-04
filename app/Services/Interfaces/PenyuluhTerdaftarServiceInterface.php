<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

interface PenyuluhTerdaftarServiceInterface
{
    public function getAll(bool $withRelations = false): Collection;

    public function getById(string|int $id): Model;

    public function create(array $data): Model;

    public function update(string|int $id, array $data): bool;

    public function delete(string|int $id): bool;

    public function getByKecamatanId(string|int $id): Collection;

    public function calculateTotal(): int;

    public function import(mixed $file): array;

    public function export(): FromCollection;
}
