<?php
namespace App\Repositories;

use App\Models\LaporanBantuanAlat;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class LaporanBantuanAlatRepository implements CrudInterface
{
    public function getAll($withRelations = false): Collection|array
    {
        if ($withRelations) {
            return LaporanBantuanAlat::with([
                'kelompokTani:id,nama',
                'penyuluh:id,penyuluh_terdaftar_id',
                'penyuluh.penyuluhTerdaftar:id,nama,no_hp',
                'bantuanAlatDetail'
            ])->select(['id', 'kelompok_tani_id', 'penyuluh_id', 'status', 'created_at'])->get();
        }

        return LaporanBantuanAlat::all();
    }

    public function find($id): Model|Collection|null
    {
        return LaporanBantuanAlat::with([
            'kelompokTani:id,nama',
            'penyuluh:id,penyuluh_terdaftar_id',
            'penyuluh.penyuluhTerdaftar:id,nama,no_hp',
            'bantuanAlatDetail'
        ])->select(['id', 'kelompok_tani_id', 'penyuluh_id', 'status', 'created_at'])
          ->where('id', $id)
          ->first();
    }

    public function create(array $data): ?Model
    {
        return LaporanBantuanAlat::create($data);
    }

    public function update(string|int $id, array $data): Model|int|bool
    {
        return LaporanBantuanAlat::where('id', $id)->update($data);
    }

    public function delete(string|int $id): Model|int|bool
    {
        return LaporanBantuanAlat::destroy($id);
    }
}
