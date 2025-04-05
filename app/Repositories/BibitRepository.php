<?php
namespace App\Repositories;

use App\Models\BibitBerkualitas;
use App\Repositories\Interfaces\BibitRepositoryInterface;

class BibitRepository implements BibitRepositoryInterface {

    public function getAll()
    {
        return BibitBerkualitas::all();
    }
    public function find($id)
    {
        return BibitBerkualitas::find($id);
    }
    public function create(array $data)
    {
        return BibitBerkualitas::create($data);
    }
    public function update($id, array $data)
    {
        return BibitBerkualitas::where('id', $id)->update($data);
    }
    public function delete($id)
    {
        return BibitBerkualitas::destroy($id);
    }
}
