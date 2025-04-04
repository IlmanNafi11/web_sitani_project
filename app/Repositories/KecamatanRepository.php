<?php
namespace App\Repositories;

use App\Models\Kecamatan;
use App\Repositories\Interfaces\KecamatanRepositoryInterfaces;

class KecamatanRepository implements KecamatanRepositoryInterfaces{

    public function getAll()
    {
        return Kecamatan::all('id', 'nama');
    }

    public function create(array $data)
    {
        return Kecamatan::create($data);
    }

    public function update($id, array $data)
    {

    }

    public function find($id)
    {

    }

    public function delete($id)
    {
        return Kecamatan::destroy($id);
    }
}
