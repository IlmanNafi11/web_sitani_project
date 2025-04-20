<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function index()
    {
        $admins = $this->service->getAll();
        return view('pages.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RoleService $roleService)
    {
        $roles = $roleService->getAll();
        return view('pages.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {
        $result = $this->service->create($request->validated());

        if ($result) {
            return redirect()->route('admin.index')->with('success', 'Data berhasil disimpan');
        }
        return redirect()->route('admin.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, RoleService $roleService)
    {
        try {
            $admin = $this->service->getById($id);
            if (!$admin) {
                return redirect()->route('admin.index')->withErrors(['error' =>'Data admin tidak ditemukan.']);
            }
            $roles = $roleService->getAll();
            return view('pages.admin.update', compact('admin', 'roles'));
        } catch (\Throwable $e) {
            Log::error('Gagal memuat halaman edit admin', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()->route('admin.index')->withErrors(['error' =>'Gagal memuat data admin.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            $result = $this->service->update($id, $validated);

            if ($result) {
                return redirect()->route('admin.index')->with('success', 'Data admin berhasil diperbarui');
            }

            return back()->withErrors(['error' => 'Gagal memperbarui data admin.'])->withInput();

        } catch (\Throwable $e) {
            Log::error('Gagal update data admin', [
                'id' => $id, 'error' => $e->getMessage(), 'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data admin.'])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $success = $this->service->delete($id);
            if ($success) {
                return redirect()->route('admin.index')->with('success', 'Data berhasil dihapus');
            }
            return redirect()->route('admin.index')->with('error', 'Data gagal dihapus');
        } catch (\Throwable $e) {
            Log::error('Gagal hapus data admin', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('admin.index')->with('error', 'Terjadi kesalahan saat menghapus data admin.');
        }
    }
}
