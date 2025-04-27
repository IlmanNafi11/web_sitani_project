<?php

namespace App\Http\Controllers;

use App\Exports\DesaExport;
use App\Exports\template\DesaTemplate;
use App\Http\Requests\DesaRequest;
use App\Http\Requests\FileExcelRequest;
use App\Imports\DesaImport;
use App\Services\DesaService;
use App\Services\KecamatanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DesaController extends Controller
{
    protected DesaService $desaService;

    public function __construct(DesaService $desaService)
    {
        $this->desaService = $desaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = $this->desaService->getAll(true);
        $desas = [];

        if ($data['success']) {
            $desas = $data['data'];
        }

        return view('pages.desa.index', compact('desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KecamatanService $kecamatanService): View
    {
        $data = $kecamatanService->getAll();
        $kecamatans = [];

        if ($data['success']) {
            $kecamatans = $data['data'];
        }

        return view('pages.desa.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesaRequest $request): RedirectResponse
    {
        $result = $this->desaService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('desa.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('desa.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, KecamatanService $kecamatanService): View
    {
        $kecamatans = [];
        $desa = [];
        $dataKecamatans = $kecamatanService->getAll();
        $dataDesa = $this->desaService->getById($id);

        if ($dataKecamatans['success'] && $dataDesa['success']) {
            $kecamatans = $dataKecamatans['data'];
            $desa = $dataDesa['data'];
        }
        return view('pages.desa.update', compact('kecamatans', 'desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesaRequest $request, string $id): RedirectResponse
    {
        $result = $this->desaService->update($id, $request->validated());

        if ($result['success']) {
            return redirect()->route('desa.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('desa.index')->with('error', 'Gagal memperbarui data desa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->desaService->delete($id);
        if ($result['success']) {
            return redirect()->route('desa.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('desa.index')->with('error', 'Data gagal dihapus');
    }

    public function getByKecamatanId($id): JsonResponse
    {
        $desas = $this->desaService->getByKecamatanId($id);
        if ($desas['success']) {
            return response()->json($desas['data']);
        }

        return response()->json($desas['message']);
    }

    public function downloadTemplate()
    {
        return Excel::download(new DesaTemplate(), 'desa.xlsx');
    }

    public function import(FileExcelRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $import = new DesaImport();
            Excel::import($import, $data['file']);

            $failures = $import->getFailures();

            if (!empty($failures)) {
                return redirect()->route('desa.index')->with([
                    'success' => 'Data berhasil diimport, namun ada beberapa data yang gagal.',
                    'failures' => $failures
                ]);
            }

            return redirect()->route('desa.index')->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('desa.index')->with('error', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new DesaExport(), 'desa.xlsx');
    }
}
