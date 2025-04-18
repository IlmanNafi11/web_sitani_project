<?php
namespace App\Repositories;

use App\Models\BibitBerkualitas;
use App\Repositories\Interfaces\CrudInterface;

class BibitRepository implements CrudInterface {

    public function getAll($withRelations = false): \Illuminate\Database\Eloquent\Collection|array
    {
        return BibitBerkualitas::all();
    }
    public function find($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|null
    {
        return BibitBerkualitas::find($id);
    }
    public function create(array $data): ?\Illuminate\Database\Eloquent\Model
    {
        return BibitBerkualitas::create($data);
    }
    public function update($id, array $data): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return BibitBerkualitas::where('id', $id)->update($data);
    }
    public function delete($id): \Illuminate\Database\Eloquent\Model|bool|int
    {
        return BibitBerkualitas::destroy($id);
    }
}
