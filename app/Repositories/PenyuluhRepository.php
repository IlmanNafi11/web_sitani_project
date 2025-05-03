<?php

namespace App\Repositories;

use App\Models\Penyuluh;
use App\Models\User;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhRepositoryInterface;
use App\Trait\LoggingError;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Throwable;

class PenyuluhRepository implements CrudInterface, PenyuluhRepositoryInterface
{
    use LoggingError;

    /**
     * Mendapatkan semua data penyuluh beserta relasi relasi.
     *
     * @param bool $withRelations set true untuk mengambil data beserta relasi(default false)
     * @return Collection|array
     */
    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Penyuluh::select(['id', 'user_id', 'penyuluh_terdaftar_id']);

            if ($withRelations) {
                $query->with([
                    'user:id,email,created_at',
                    'penyuluhTerdaftar:id,nama,no_hp,alamat',
                ]);
            }

            return $query->get();

        } catch (QueryException $e) {
            $this->LogSqlException($e);
            return Collection::make();
        } catch (Exception $e) {
            return Collection::make();
        }
    }

    /**
     * Mengambil data penyuluh berdasarkan ID.
     *
     * @param string|int $id Id penyuluh
     * @return Model|Collection|array|null
     */
    public function getById(string|int $id): array|Collection|Model|null
    {
        try {
            return Penyuluh::where('id', $id)->with([
                'user:id,email',
                'penyuluhTerdaftar:id,nama,no_hp,alamat',
            ])->first();
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Membuat data penyuluh baru beserta user terkait.
     *
     * @param array $data Data penyuluh
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'is_password_set' => true,
                ]);

                $user->assignRole('penyuluh');

                $penyuluh = Penyuluh::create([
                    'user_id' => $user->id,
                    'penyuluh_terdaftar_id' => $data['penyuluh_terdaftar_id'],
                ]);

                return $penyuluh->load('user:id,email,created_at', 'penyuluhTerdaftar:id,nama,no_hp,alamat,kecamatan_id');
            });
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            return null;
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * Memperbarui data penyuluh berdasarkan ID.
     *
     * @param string|int $id
     * @param array $data
     * @return bool
     */
    public function update(string|int $id, array $data): bool
    {
        try {
            return Penyuluh::findOrFail($id)->update($data);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Menghapus data penyuluh berdasarkan ID.
     *
     * @param string|int $id
     * @return bool
     */
    public function delete(string|int $id): bool
    {
        try {
            $deleted = Penyuluh::destroy($id);
            return $deleted > 0;
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public function calculateTotal(): int
    {
        try {
            return Penyuluh::count();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            throw new \Exception('Terjadi Kesalahan pada query', 500);
        } catch (\Exception $e) {
            throw new \Exception('Terjadi Kesalahan di server saat menghitung total record', 500);
        }
    }
}
