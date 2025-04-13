<?php
namespace App\Repositories;

use App\Models\LaporanKondisi;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class LaporanBibitRepository implements CrudInterface{

    public function getAll($withRelations = false): Collection|array
    {
        return LaporanKondisi::all();
    }

    public function find($id): Model|Collection|null
    {
        return LaporanKondisi::find($id);
    }

    public function create(array $data): ?Model
    {
        return LaporanKondisi::create($data);
    }

    public function update(string|int $id, array $data): Model|int|bool
    {
        return LaporanKondisi::where('id', $id)->update($data);
    }

    public function delete(string|int $id): Model|int|bool
    {
        return LaporanKondisi::destroy($id);
    }
}
