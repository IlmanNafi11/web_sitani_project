<?php

namespace App\Repositories;

use App\Models\KelompokTani;
use App\Repositories\Interfaces\KelompokTaniRepositoryInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class KelompokTaniRepository implements KelompokTaniRepositoryInterface, ManyRelationshipManagement
{

    public function getAll($withRelations = false)
    {
        if ($withRelations) {
            return KelompokTani::with(relations: [
                'kecamatan' => function($query) {
                    $query->select('id', 'nama');
                },
                'desa' => function($query) {
                    $query->select('id', 'nama');
                },
            ])->with('penyuluhTerdaftars')->get();
        }

        return KelompokTani::all();
    }

    public function create(array $data)
    {
        return KelompokTani::create($data);
    }
    public function update($id, array $data)
    {
        $model = KelompokTani::find($id);
        $model->update($data);
        return $model;
    }
    public function find($id)
    {
        return KelompokTani::find($id);
    }
    public function delete($id)
    {
        $model = KelompokTani::find($id);
        $model->delete($id);
        return $model;
    }

    public function attach(Model $model, array|int|\Illuminate\Database\Eloquent\Collection $ids, array $attributes = []): bool
    {
        if ($model instanceof KelompokTani) {
            $model->penyuluhTerdaftars()->attach($ids, $attributes);
            return true;
        }

        return false;
    }

    public function detach(Model $model, array|int|\Illuminate\Database\Eloquent\Collection|null $ids = null): int|null
    {
        if ($model instanceof KelompokTani) {
            return $model->penyuluhTerdaftars()->detach($ids);
        }

        return null;
    }

    public function sync(Model $model, array $relations, bool $detaching = true): array|null
    {
        if ($model instanceof KelompokTani) {
            return $model->penyuluhTerdaftars()->sync($relations, $detaching);
        }

        return null;
    }
}
