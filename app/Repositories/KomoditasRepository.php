<?php
namespace App\Repositories;

use App\Models\Komoditas;
use App\Repositories\Interfaces\CrudInterface;
class KomoditasRepository implements CrudInterface {

    public function getAll($withRelations = false): \Illuminate\Database\Eloquent\Collection|array
    {
        return Komoditas::all();
    }
    public function find($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|null
    {
        return Komoditas::find($id);
    }
    public function create(array $data): ?\Illuminate\Database\Eloquent\Model
    {
        return Komoditas::create($data);
    }
    public function update($id, array $data): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return Komoditas::where('id', $id)->update($data);
    }
    public function delete($id): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return Komoditas::destroy($id);
    }
}
