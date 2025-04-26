<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected RoleService $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        $data = $this->service->getAll();
        $roles = [];
        if ($data['success']) {
            $roles = $data['data'];
        }
        return view('pages.role.index', compact('roles'));
    }

    public function create(): View
    {
        $permissions = Permission::all();
        return view('pages.role.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $result = $this->service->createWithPermissions([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ], $validated['permissions'] ?? []);

        if ($result['success']) {
            return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dibuat');
        }
        return back()->withErrors(['Gagal membuat role.'])->withInput();
    }

    public function edit($id): View
    {
        $data = $this->service->getById($id);
        $permissions = Permission::all();
        $role = [];
        if ($data['success']) {
            $role = $data['data'];
        }
        return view('pages.role.update', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, $id): RedirectResponse
    {
        $validated = $request->validated();
        $result = $this->service->updateRoleAndPermissions($id, [
            'name' => $validated['name'],
            'guard_name' => 'web',
        ], $validated['permissions'] ?? []);

        if ($result['success']) {
            return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diupdate');
        }
        return back()->withErrors(['Gagal memperbarui role.'])->withInput();
    }

    public function destroy($id): RedirectResponse
    {
        $deleted = $this->service->delete($id);
        if ($deleted['success']) {
            return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus');
        }
        return back()->withErrors('Gagal menghapus role.');
    }
}
