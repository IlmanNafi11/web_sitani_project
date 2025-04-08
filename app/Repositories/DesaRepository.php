<?php
namespace App\Repositories;

use App\Models\Desa;
use App\Repositories\Interfaces\DesaCustomQueryInterface;
use App\Repositories\Interfaces\DesaRepositoryInterface;

class DesaRepository implements DesaRepositoryInterface, DesaCustomQueryInterface {

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

    public function getByKecamatanId($id): \Illuminate\Database\Eloquent\Collection
    {
        return Desa::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
    }
}
