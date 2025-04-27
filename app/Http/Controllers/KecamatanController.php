<?php

namespace App\Http\Controllers;

use App\Exports\KecamatanExport;
use App\Exports\template\KecamatanTemplate;
use App\Http\Requests\FileExcelRequest;
use App\Http\Requests\KecamatanRequest;
use App\Imports\KecamatanImport;
use App\Imports\KomoditasImport;
use App\Services\KecamatanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class KecamatanController extends Controller
{
    protected KecamatanService $kecamatanService;

    public function __construct(KecamatanService $kecamatanService)
    {
        $this->kecamatanService = $kecamatanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = $this->kecamatanService->getAll();
        $kecamatans = [];

        if ($data['success']) {
            $kecamatans = $data['data'];
        }

        return view('pages.kecamatan.index', compact('kecamatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KecamatanRequest $request): RedirectResponse
    {
        $result = $this->kecamatanService->create($request->validated());
        if ($result['success']) {
            return redirect()->route('kecamatan.index')->with('success', 'Data Berhasil disimpan');
        }

        return redirect()->route('kecamatan.create')->with('error', 'Data Gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data = $this->kecamatanService->getById($id);
        $kecamatan = [];

        if ($data['success']) {
            $kecamatan = $data['data'];
        }
        return view('pages.kecamatan.update', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KecamatanRequest $request, string $id): RedirectResponse
    {
        $result = $this->kecamatanService->update($id, $request->validated());

        if ($result['success']) {
            return redirect()->route('kecamatan.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('kecamatan.index')->with('error', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->kecamatanService->delete($id);
        if ($result['success']) {
            return redirect()->route('kecamatan.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('kecamatan.index')->with('error', 'Data gagal dihapus');
    }

    public function downloadTemplate()
    {
        return Excel::download(new KecamatanTemplate(), 'kecamatan.xlsx');
    }

    public function import(FileExcelRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $import = new KecamatanImport();
            Excel::import($import, $data['file']);

            $failures = $import->getFailures();

            if (!empty($failures)) {
                return redirect()->route('kecamatan.index')->with([
                    'success' => 'Data berhasil diimport, namun ada beberapa data yang gagal.',
                    'failures' => $failures
                ]);
            }

            return redirect()->route('kecamatan.index')->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('kecamatan.index')->with('error', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new KecamatanExport(), 'kecamatan.xlsx');
    }
}
