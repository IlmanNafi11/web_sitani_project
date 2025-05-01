<?php

namespace App\Repositories;

use App\Models\Penyuluh;
use App\Models\User;
use App\Repositories\Interfaces\CrudInterface;
use App\Repositories\Interfaces\PenyuluhRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class PenyuluhRepository implements CrudInterface, PenyuluhRepositoryInterface
{

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
            Log::error("Gagal mengambil seluruh data penyuluh", [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);

            return Collection::make();

        } catch (Exception $e) {
            Log::error("Gagal mengambil seluruh data penyuluh", [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

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
            Log::error('Gagal mengambil data penyuluh dengan id ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);

            return null;
        } catch (Exception $e) {
            Log::error('Gagal mengambil data penyuluh dengan id ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

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
          Log::error("Gagal menyimpan data penyuluh beserta user baru", [
              'source' => __METHOD__,
              'error' => $e->getMessage(),
              'sql' => $e->getSql(),
              'data' => $data,
          ]);

          return null;
        } catch (Throwable $e) {
            Log::error('Gagal menyimpan data penyuluh beserta user baru.', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);

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
            Log::error('Gagal memperbarui data penyuluh dengan id ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'data' => $data,
            ]);

            return false;
        }
        catch (Throwable $e) {
            Log::error('Gagal memperbarui data penyuluh dengan id ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data,
            ]);

            return false;
        }
    }

    /**
     * Menghapus data penyuluh berdasarkan ID.
     *
     * @param string|int $id
     * @return bool
     */
    public function delete(string|int$id): bool
    {
        try {
            $deleted = Penyuluh::destroy($id);
            return $deleted > 0;
        } catch (QueryException $e) {
          Log::error('Gagal hapus data penyuluh dengan id ' . $id, [
              'source' => __METHOD__,
              'error' => $e->getMessage(),
              'sql' => $e->getSql(),
              'data' => ['id' => $id],
          ]);

          return false;
        } catch (Throwable $e) {
            Log::error('Gagal hapus data penyuluh dengan id ' . $id, [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => ['id' => $id],
            ]);

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
            Log::error('Terjadi kesalahan pada query saat mencoba menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
            ]);
            throw new \Exception('Terjadi Kesalahan pada query', 500);
        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan saat menghitung total record', [
                'source' => __METHOD__,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \Exception('Terjadi Kesalahan di server saat menghitung total record', 500);
        }
    }
}
