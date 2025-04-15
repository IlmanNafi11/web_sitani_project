<?php
namespace App\Repositories;

use App\Models\LaporanKondisi;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class LaporanBibitRepository implements CrudInterface{

    public function getAll($withRelations = false): Collection|array
    {
        if ($withRelations) {
            return LaporanKondisi::select(['id', 'status', 'created_at', 'kelompok_tani_id', 'komoditas_id', 'penyuluh_id'])->with([
                'kelompokTani' => function($query){
                    $query->select(['id', 'nama']);
                },
                'komoditas' => function ($query) {
                    $query->select(['id', 'nama', 'musim']);
                },
                'penyuluh' => function ($query) {
                    $query->select(['id', 'penyuluh_terdaftar_id']);
                },
                'penyuluh.penyuluhTerdaftar' => function ($query) {
                    $query->select(['id', 'nama', 'no_hp']);
                },
            ])->with('laporanKondisiDetail')->get();
        }

        return LaporanKondisi::all();
    }

    public function find($id): Model|Collection|null
    {
        return LaporanKondisi::with([
            'kelompokTani' => function ($query) {
                $query->select(['id', 'nama', 'desa_id', 'kecamatan_id']);
            },
            'kelompokTani.desa' => function ($query) {
                $query->select(['id', 'nama']);
            },
            'kelompokTani.kecamatan' => function ($query) {
                $query->select(['id', 'nama']);
            },
            'komoditas' => function ($query) {
                $query->select(['id', 'nama', 'musim']);
            },
            'penyuluh' => function ($query) {
                $query->select(['id', 'penyuluh_terdaftar_id']);
            },
            'penyuluh.penyuluhTerdaftar' => function ($query) {
                $query->select(['id', 'nama', 'no_hp']);
            },
            'laporanKondisiDetail'
        ])
            ->select(['id', 'status', 'created_at', 'kelompok_tani_id', 'komoditas_id', 'penyuluh_id'])
            ->where('id', $id)
            ->first();
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
