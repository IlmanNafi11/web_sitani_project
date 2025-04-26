<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected AdminService $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = $this->service->getAll();
        $admins = [];
        if ($data['success']) {
            $admins = $data['data'];
        }

        return view('pages.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RoleService $roleService): View
    {
        $data = $roleService->getAll();
        $roles = [];
        if ($data['success']) {
            $roles = $data['data'];
        }

        return view('pages.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request): RedirectResponse
    {
        $result = $this->service->create($request->validated());

        if ($result['success']) {
            return redirect()->route('admin.index')->with('success', 'Data berhasil disimpan');
        }
        return redirect()->route('admin.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, RoleService $roleService): View
    {
        $dataAdmin = $this->service->getById($id);
        $dataRole = $roleService->getAll();
        $admin = [];
        $roles = [];

        if ($dataAdmin['success'] && $dataRole['data']) {
            $admin = $dataAdmin['data'];
            $roles = $dataRole['data'];
        }

        return view('pages.admin.update', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, $id): RedirectResponse
    {
        $validated = $request->validated();
        $result = $this->service->update($id, $validated);

        if ($result['success']) {
            return redirect()->route('admin.index')->with('success', 'Data admin berhasil diperbarui');
        }
        return back()->withErrors(['error' => 'Gagal memperbarui data admin.'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->service->delete($id);
        if ($result['success']) {
            return redirect()->route('admin.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('admin.index')->with('error', 'Data gagal dihapus');
    }
}
