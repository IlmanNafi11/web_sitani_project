<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

interface AdminServiceInterface
{
    public function getAll(): Collection;

    public function getById(string|int $id): Model;

    public function create(array $data): Model;

    public function update(string|int $id, array $data): bool;

    public function delete(string|int $id): bool;

    public function import(mixed $file): array;

    public function export(): FromCollection;
}
