<?php
namespace App\Repositories;

use App\Models\Kecamatan;
use App\Repositories\Interfaces\CrudInterface;

class KecamatanRepository implements CrudInterface {

    public function getAll($withRelations = false): \Illuminate\Database\Eloquent\Collection|array
    {
        return Kecamatan::all('id', 'nama');
    }

    public function create(array $data): ?\Illuminate\Database\Eloquent\Model
    {
        return Kecamatan::create($data);
    }

    public function update($id, array $data): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return Kecamatan::where('id', $id)->update($data);
    }

    public function find($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|null
    {
        return Kecamatan::find($id);
    }

    public function delete($id): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return Kecamatan::destroy($id);
    }
}
