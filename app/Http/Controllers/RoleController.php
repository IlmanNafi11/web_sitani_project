<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Throwable;

class RoleController extends Controller
{
    protected RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $roles = $this->service->getAll();
            return view('pages.role.index', compact('roles'));
        } catch (Throwable $e) {
            Log::error('Gagal fetch roles', ['error' => $e->getMessage()]);
            return back()->withErrors('Gagal mengambil data role.');
        }
    }

    public function create()
    {
        try {
            $permissions = Permission::all();
            return view('pages.role.create', compact('permissions'));
        } catch (Throwable $e) {
            Log::error('gagal memuat permissions untuk halaman create role', ['error' => $e->getMessage()]);
            return back()->withErrors('Gagal memuat data permissions.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:roles,name',
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            Log::warning('RoleController@store validasi gagal', [
                'errors' => $ex->errors(),
                'input' => $request->all(),
            ]);
            return back()->withErrors($ex->errors())->withInput();
        }

        DB::beginTransaction();
        try {
            $role = $this->service->create([
                'name' => $validated['name'],
                'guard_name' => 'web',
            ]);

            $this->service->syncPermissions($role->id, $validated['permissions'] ?? []);

            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dibuat');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal membuat role', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);
            return back()->withErrors('Gagal membuat role.')->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $role = $this->service->getById($id);
            $permissions = Permission::all();
            return view('pages.role.update', compact('role', 'permissions'));
        } catch (Throwable $e) {
            Log::error('Gagal memuat role untuk edit', ['id' => $id, 'error' => $e->getMessage()]);
            return back()->withErrors('Gagal memuat data role.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|unique:roles,name,' . $id,
                'permissions' => 'array',
                'permissions.*' => 'exists:permissions,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $ex) {
            Log::warning('RoleController@update validation failed', [
                'errors' => $ex->errors(),
                'input' => $request->all(),
                'role_id' => $id,
            ]);
            return back()->withErrors($ex->errors())->withInput();
        }

        \DB::beginTransaction();
        try {
            $this->service->updateRoleAndPermissions($id, [
                'name' => $validated['name'],
                'guard_name' => 'web',
            ], $validated['permissions'] ?? []);

        \DB::commit();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role berhasil diupdate');
    } catch (\Throwable $e) {
        \DB::rollBack();
        Log::error('Gagal memperbarui role', [
            'role_id' => $id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'input' => $request->all(),
        ]);
        return back()->withErrors('Gagal memperbarui role.')->withInput();
    }
}

    public function destroy($id)
    {
        try {
            $deleted = $this->service->delete($id);
            if ($deleted) {
                return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus');
            }
            return back()->withErrors('Tidak dapat menghapus role. Role tidak ditemukan.');
        } catch (Throwable $e) {
            Log::error('RoleController@destroy failed', [
                'role_id' => $id,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors('Gagal menghapus role.');
        }
    }
}
