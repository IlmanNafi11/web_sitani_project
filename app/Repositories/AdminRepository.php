<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\User;
use App\Repositories\Interfaces\CrudInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRepository implements CrudInterface
{

    public function getAll($withRelations = false): Collection|array
    {
        if ($withRelations) {
            return Admin::select(['id', 'nama', 'no_hp', 'alamat', 'user_id'])->with([
                'user' => function ($query) {
                    $query->select(['id', 'email',]);
                },
                'user.roles' => function ($query) {
                    $query->select(['id', 'name']);
                },
            ])->get();
        }

        return Admin::all();
    }

    public function find($id): Model|Collection|array|null
    {
        return Admin::with([
            'user' => function ($query) {
                $query->select(['id', 'email']);
            },
            'user.roles' => function ($query) {
                $query->select(['id', 'name']);
            },
        ])->find($id);
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
        } catch (\Throwable $e) {
            Log::error('Gagal menyimpan data admin beserta user baru', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return null;
        }
    }

    public function update(int|string $id, array $data): Model|int|bool
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $admin = Admin::find($id);
                if (!$admin) {
                    Log::error("[Admin Update] Admin id {$id} tidak ditemukan");
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
                    Log::error("[Admin Update] User untuk admin id {$id} tidak ditemukan");
                    throw new \Exception("User untuk admin tidak ditemukan");
                }

                $admin->save();

                return $admin;
            }, 3);
        } catch (\Throwable $e) {
            Log::error('Error updating admin', [
                'id' => $id,
                'data' => $data,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }

    public function delete(int|string $id): Model|int|bool
    {
        try {
            return DB::transaction(function () use ($id) {
                $admin = Admin::find($id);

                if (!$admin) {
                    Log::warning("[Admin Delete] Admin id {$id} tidak ditemukan.");
                    return false;
                }

                if ($admin->user) {
                    $admin->user->delete();
                } else {
                    Log::warning("[Admin Delete] User untuk admin id {$id} tidak ditemukan.");
                }

                $admin->delete();
                return true;
            });
        } catch (\Throwable $e) {
            Log::error("[Admin Delete] Gagal menghapus admin", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return false;
        }
    }
}
