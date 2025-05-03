<?php

namespace App\Repositories;

use App\Models\KelompokTani;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\KelompokTaniRepositoryInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use App\Trait\LoggingError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Throwable;

class KelompokTaniRepository implements CrudInterface, ManyRelationshipManagement, KelompokTaniRepositoryInterface
{
    use LoggingError;

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = KelompokTani::select(['id', 'nama', 'kecamatan_id', 'desa_id']);
            if ($withRelations) {
                $query->with([
                    'kecamatan' => function ($q) {
                        $q->select('id', 'nama');
                    },
                    'desa' => function ($q) {
                        $q->select('id', 'nama');
                    },
                    'penyuluhTerdaftars' => function ($q) {
                        $q->select('penyuluh_terdaftars.id', 'nama');
                    }
                ]);
            }
            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            return Collection::make();
        } catch (Throwable $e) {
            return Collection::make();
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return KelompokTani::create($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }

    public function update(string|int $id, array $data): Model|bool|int
    {
        try {
            $model = KelompokTani::findOrFail($id);
            $model->update($data);
            return $model;
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return KelompokTani::select(['id', 'nama', 'desa_id', 'kecamatan_id'])->where('id', $id)->with([
                'penyuluhTerdaftars' => function ($q) {
                    $q->select('penyuluh_terdaftars.id', 'nama', 'no_hp', 'alamat');
                },
                'kecamatan' => function ($q) {
                    $q->select('id', 'nama');
                }, 'desa' => function ($q) {
                    $q->select('id', 'nama');
                }
            ])->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }

    public function delete(string|int $id): Model|bool|int
    {
        try {
            $model = KelompokTani::find($id);
            $model->delete();
            return $model;
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function attach(Model $model, array|int|Collection $ids, array $attributes = []): bool
    {
        try {
            if ($model instanceof KelompokTani) {
                $model->penyuluhTerdaftars()->attach($ids, $attributes);
                return true;
            }
            return false;
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $ids]);
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    public function detach(Model $model, array|int|Collection|null $ids = null): int|null
    {
        try {
            if ($model instanceof KelompokTani) {
                return $model->penyuluhTerdaftars()->detach($ids);
            }
            return null;
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $ids]);
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }

    public function sync(Model $model, array $relations, bool $detaching = true): ?array
    {
        try {
            if ($model instanceof KelompokTani) {
                return $model->penyuluhTerdaftars()->sync($relations, $detaching);
            }
            return null;
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }

    public function getByPenyuluhId(array $id): Collection|array
    {
        try {
            return KelompokTani::whereHas('penyuluhTerdaftars', function ($query) use ($id) {
                $query->whereIn('penyuluh_terdaftar_id', $id);
            })
                ->with([
                    'desa:id,nama,kecamatan_id',
                    'desa.kecamatan:id,nama',
                    'penyuluhTerdaftars:id,nama,no_hp,alamat',
                ])
                ->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return Collection::make();
        } catch (Throwable $e) {
            return Collection::make();
        }
    }

    /**
     * @throws Exception
     */
    public function calculateTotal(): int
    {
        try {
            return KelompokTani::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new QueryException($e->getConnectionName(), $e->getSql(), $e->getBindings(), $e->getPrevious());
        } catch (\Exception $e) {
            throw new Exception('Terjadi Kesalahan di server saat menghitung total record', 500);
        }
    }

    /**
     * @throws Exception
     */
    public function countByKecamatanId(int|string $id): int
    {
        try {
            return KelompokTani::where('kecamatan_id', $id)->count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new Exception('Terjadi kesalahan pada query', 500);
        } catch (\Throwable $e) {
            throw new Exception('Terjadi kesalahan pada repository', 500);
        }
    }
}
