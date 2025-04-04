<?php

namespace App\Repositories\Interfaces;

interface KecamatanRepositoryInterfaces
{
    public function getAll();
    public function create(array $data);
    public function update($id, array $data);
    public function find($id);
    public function delete($id);
}
