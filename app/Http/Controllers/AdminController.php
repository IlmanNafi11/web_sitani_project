<?php

namespace App\Http\Controllers;

use App\Exports\AdminExport;
use App\Exports\template\AdminTemplate;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\FileExcelRequest;
use App\Http\Requests\ProfileRequest;
use App\Imports\AdminImport;
use App\Services\AdminService;
use App\Services\RoleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

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

    public function viewProfile(): View
    {
        $user = \Auth::user();
        $user->load('admin:id,user_id,nama,no_hp,alamat');
        return view('pages.profile.profile', compact('user'));
    }

    public function updateProfile(ProfileRequest $request, $id)
    {
        $result = $this->service->update($id, $request->validated());

        if ($result['success']) {
            return redirect()->back()->with('success', 'Data profile berhasil diperbarui');
        }

        return redirect()->back()->with('error', 'Data profile gagal diperbarui');
    }

    public function downloadTemplate()
    {
        return Excel::download(new AdminTemplate(), 'data_admin.xlsx');
    }

    public function import(FileExcelRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $import = new AdminImport();
            Excel::import($import, $data['file']);

            $failures = $import->getFailures();

            if (!empty($failures)) {
                return redirect()->route('admin.index')->with([
                    'success' => 'Data berhasil diimport, namun ada beberapa data yang gagal.',
                    'failures' => $failures
                ]);
            }

            return redirect()->route('admin.index')->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new AdminExport(), 'data_admin.xlsx');
    }
}
