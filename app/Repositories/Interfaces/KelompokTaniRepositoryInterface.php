<?php

namespace App\Repositories\Interfaces;

interface KelompokTaniRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function update($id, array $data);
    public function find($id);
    public function delete($id);
    public function syncPenyuluh($kelompokTaniId, array $penyuluhIds): void;
}
