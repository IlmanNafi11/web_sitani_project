<?php
namespace App\Repositories;

use App\Models\Desa;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\DesaCustomQueryInterface;

class DesaRepository implements CrudInterface, DesaCustomQueryInterface {

    public function getAll($withRelations = false): \Illuminate\Database\Eloquent\Collection|array
    {
        return Desa::all();
    }

    public function find($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|null
    {
        return Desa::find($id);
    }

    public function create(array $data): ?\Illuminate\Database\Eloquent\Model
    {
        return Desa::create($data);
    }

    public function update($id, array $data): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return Desa::where('id', $id)->update($data);
    }

    public function delete($id): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return Desa::destroy($id);
    }

    public function getByKecamatanId($id): \Illuminate\Database\Eloquent\Collection
    {
        return Desa::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
    }
}
