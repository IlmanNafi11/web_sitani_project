<?php

namespace App\Repositories;

use App\Models\KelompokTani;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\KelompokTaniRepositoryInterface;
use App\Repositories\Interfaces\ManyRelationshipManagement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class KelompokTaniRepository implements CrudInterface, ManyRelationshipManagement, KelompokTaniRepositoryInterface
{
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
            Log::error('Gagal mengambil seluruh data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            return Collection::make();
        } catch (Throwable $e) {
            Log::error('Gagal mengambil seluruh data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return Collection::make();
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return KelompokTani::create($data);
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan data kelompok tani', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => $data,
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan data kelompok tani', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);
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
            Log::error('Gagal memperbarui data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => [
                    'id' => $id,
                    'data' => $data,
                ],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal memperbarui data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'id' => $id,
                    'data' => $data,
                ],
            ]);
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
            Log::error('Gagal mengambil data kelompok tani berdasarkan id.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => ['id' => $id],
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal mengambil data kelompok tani berdasarkan id.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['id' => $id],
            ]);
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
            Log::error('Gagal menghapus data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => ['id' => $id],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal menghapus data kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['id' => $id],
            ]);
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
            Log::error('Gagal attach penyuluh ke kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => [
                    'model_id' => $model->id,
                    'related_ids' => $ids,
                    'attributes' => $attributes,
                ],
            ]);
            return false;
        } catch (Throwable $e) {
            Log::error('Gagal attach penyuluh ke kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'model_id' => $model->id,
                    'related_ids' => $ids,
                    'attributes' => $attributes,
                ],
            ]);
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
            Log::error('Gagal detach penyuluh dari kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => [
                    'model_id' => $model->id,
                    'related_ids' => $ids,
                ],
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal detach penyuluh dari kelompok tani.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'model_id' => $model->id,
                    'related_ids' => $ids,
                ],
            ]);
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
            Log::error('Gagal sync penyuluh dengan kelompok tani', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => [
                    'model_id' => $model->id,
                    'relations' => $relations,
                    'detaching' => $detaching,
                ],
            ]);
            return null;
        } catch (Throwable $e) {
            Log::error('Gagal sync penyuluh dengan kelompok tani', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'model_id' => $model->id,
                    'relations' => $relations,
                    'detaching' => $detaching,
                ],
            ]);
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
            Log::error('Gagal mengambil data kelompok tani', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => [
                    'id' => $id,
                ],
            ]);
            return Collection::make();
        } catch (Throwable $e) {
            Log::error('Gagal mengambil data kelompok tani', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'id' => $id,
                ],
            ]);
            return Collection::make();
        }
    }

    public function calculateTotal(): int
    {
        try {
            return KelompokTani::count();
        } catch (QueryException $e) {
            Log::error('Terjadi kesalahan pada query saat mencoba menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            return 0;
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 0;
        }
    }
}
