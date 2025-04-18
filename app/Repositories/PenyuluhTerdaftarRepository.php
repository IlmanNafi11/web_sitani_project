<?php
namespace App\Repositories;

use App\Models\PenyuluhTerdaftar;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhRepositoryInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarCustomQueryInterface;

class PenyuluhTerdaftarRepository implements CrudInterface, PenyuluhTerdaftarCustomQueryInterface {

    public function getAll($withRelations = false): \Illuminate\Database\Eloquent\Collection|array
    {
        return PenyuluhTerdaftar::all();
    }
    public function find($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|null
    {
        return PenyuluhTerdaftar::find($id);
    }
    public function create(array $data): ?\Illuminate\Database\Eloquent\Model
    {
        return PenyuluhTerdaftar::create($data);
    }
    public function update($id, array $data): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return PenyuluhTerdaftar::where('id', $id)->update($data);
    }
    public function delete($id): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return PenyuluhTerdaftar::destroy($id);
    }

    public function getByKecamatanId(int|string $id): \Illuminate\Database\Eloquent\Collection
    {
        return PenyuluhTerdaftar::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
    }
}
