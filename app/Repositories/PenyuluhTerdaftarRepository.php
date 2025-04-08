<?php
namespace App\Repositories;

use App\Models\PenyuluhTerdaftar;
use App\Repositories\Interfaces\PenyuluhRepositoryInterface;
use App\Repositories\Interfaces\PenyuluhTerdaftarCustomQueryInterface;

class PenyuluhTerdaftarRepository implements PenyuluhRepositoryInterface, PenyuluhTerdaftarCustomQueryInterface {

    public function getAll()
    {
        return PenyuluhTerdaftar::all();
    }
    public function find($id)
    {
        return PenyuluhTerdaftar::find($id);
    }
    public function create(array $data)
    {
        return PenyuluhTerdaftar::create($data);
    }
    public function update($id, array $data)
    {
        return PenyuluhTerdaftar::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        return PenyuluhTerdaftar::destroy($id);
    }

    public function getByKecamatanId(int|string $id): \Illuminate\Database\Eloquent\Collection
    {
        return PenyuluhTerdaftar::select(['id', 'nama'])->where('kecamatan_id', $id)->get();
    }
}
