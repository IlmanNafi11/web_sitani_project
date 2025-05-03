<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\User;
use App\Repositories\Interfaces\CrudInterface;
use App\Trait\LoggingError;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRepository implements CrudInterface
{

    use LoggingError;

    public function getAll(bool $withRelations = false): Collection|array
    {
        try {
            $query = Admin::select(['id', 'nama', 'no_hp', 'alamat', 'user_id']);
            if ($withRelations) {
                $query->with([
                    'user' => function ($query) {
                        $query->select(['id', 'email',]);
                    },
                    'user.roles' => function ($query) {
                        $query->select(['id', 'name']);
                    },
                ]);
            }
            return $query->get();
        } catch (QueryException $e) {
            $this->LogSqlException($e);
            return Collection::make();
        } catch (\Throwable $e) {
            return Collection::make();
        }
    }

    public function getById(string|int $id): Model|Collection|array|null
    {
        try {
            return Admin::with([
                'user' => function ($query) {
                    $query->select(['id', 'email']);
                },
                'user.roles' => function ($query) {
                    $query->select(['id', 'name']);
                },
            ])->find($id);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => 'id']);
            return null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function create(array $data): ?Model
    {
        try {
            return DB::transaction(function () use ($data) {
                $user = User::create([
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'is_password_set' => $data['is_password_set'],
                ]);

                $user->assignRole($data['role']);

                $admin = Admin::create([
                    'nama' => $data['nama'],
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['alamat'],
                    'user_id' => $user->id,
                ]);

                return $admin;
            });
        } catch (QueryException $e) {
            $this->LogSqlException($e, $data);
            return null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function update(string|int $id, array $data): Model|int|bool
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $admin = Admin::find($id);
                if (!$admin) {
                    Log::error("Admin id {$id} tidak ditemukan");
                    throw new \Exception("Admin tidak ditemukan");
                }

                $admin->nama = $data['nama'] ?? $admin->nama;
                $admin->no_hp = $data['no_hp'] ?? $admin->no_hp;
                $admin->alamat = $data['alamat'] ?? $admin->alamat;

                if ($admin->user) {
                    $admin->user->email = $data['email'] ?? $admin->user->email;
                    $admin->user->save();

                    if (isset($data['role'])) {
                        $admin->user->syncRoles([$data['role']]);
                    }
                } else {
                    Log::error("User untuk admin id {$id} tidak ditemukan");
                    throw new \Exception("User untuk admin tidak ditemukan");
                }

                $admin->save();

                return $admin;
            }, 3);
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id, 'data_baru' => $data]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function delete(string|int $id): Model|int|bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $admin = Admin::find($id);

                if (!$admin) {
                    Log::warning("Admin id {$id} tidak ditemukan.");
                    return false;
                }

                if ($admin->user) {
                    $admin->user->delete();
                } else {
                    Log::warning("User untuk admin id {$id} tidak ditemukan.");
                }

                $admin->delete();
                return true;
            });
        } catch (QueryException $e) {
            $this->LogSqlException($e, ['id' => $id]);
            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
