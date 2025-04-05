<?php
namespace App\Repositories;

use App\Models\Komoditas;
use App\Repositories\Interfaces\KomoditasRepositoryInterface;

class KomoditasRepository implements KomoditasRepositoryInterface {

    public function getAll()
    {
        return Komoditas::all();
    }
    public function find($id)
    {
        return Komoditas::find($id);
    }
    public function create(array $data)
    {
        return Komoditas::create($data);
    }
    public function update($id, array $data)
    {
        return Komoditas::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        return Komoditas::destroy($id);
    }
}
