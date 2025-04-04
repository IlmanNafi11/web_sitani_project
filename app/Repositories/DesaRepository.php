<?php
namespace App\Repositories;

use App\Models\Desa;
use App\Repositories\Interfaces\DesaRepositoryInterface;

class DesaRepository implements DesaRepositoryInterface {

    public function getAll()
    {
        return Desa::all();
    }

    public function find($id)
    {
        return Desa::find($id);
    }

    public function create(array $data)
    {
        return Desa::create($data);
    }

    public function update($id, array $data)
    {
        return Desa::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Desa::destroy($id);
    }
}
