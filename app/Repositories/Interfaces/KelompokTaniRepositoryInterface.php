<?php

namespace App\Repositories\Interfaces;

interface KelompokTaniRepositoryInterface
{
    public function getAll($withRelations = false);
    public function create(array $data);
    public function update($id, array $data);
    public function find($id);
    public function delete($id);
}
