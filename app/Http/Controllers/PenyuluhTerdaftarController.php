<?php

namespace App\Http\Controllers;

use App\Exports\PenyuluhTerdaftarExport;
use App\Exports\template\PenyuluhTerdaftarTemplate;
use App\Http\Requests\FileExcelRequest;
use App\Http\Requests\PenyuluhTerdaftarRequest;
use App\Imports\PenyuluhTerdaftarImport;
use App\Services\KecamatanService;
use App\Services\PenyuluhTerdaftarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class PenyuluhTerdaftarController extends Controller
{
    protected PenyuluhTerdaftarService $penyuluhService;

    public function __construct(PenyuluhTerdaftarService $penyuluhService)
    {
        $this->penyuluhService = $penyuluhService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = $this->penyuluhService->getAll(true);
        $penyuluhs = [];

        if ($data['success']) {
            $penyuluhs = $data['data'];
        }

        return view('pages.penyuluh_terdaftar.index', compact('penyuluhs'));
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

        return view('pages.penyuluh_terdaftar.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenyuluhTerdaftarRequest $request): RedirectResponse
    {
        $result = $this->penyuluhService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('penyuluh-terdaftar.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, KecamatanService $kecamatanService): View
    {
        $dataPenyuluh = $this->penyuluhService->getById($id);
        $dataKecamatan = $kecamatanService->getAll();
        $penyuluh = [];
        $kecamatans = [];

        if ($dataPenyuluh['success'] && $dataKecamatan['data']) {
            $penyuluh = $dataPenyuluh['data'];
            $kecamatans = $dataKecamatan['data'];
        }

        return view('pages.penyuluh_terdaftar.update', compact('penyuluh', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenyuluhTerdaftarRequest $request, string $id): RedirectResponse
    {
        $result = $this->penyuluhService->update($id, $request->validated());

        if ($result['success']) {
            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('penyuluh-terdaftar.index')->with('error', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->penyuluhService->delete($id);

        if ($result['success']) {
            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('penyuluh-terdaftar.index')->with('error', 'Data gagal dihapus');
    }

    /**
     * Mengambil data penyuluh terdaftar berdasarkan kecamatan id
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function getByKecamatanId(string|int $id): JsonResponse
    {
        $result = $this->penyuluhService->getByKecamatanId($id);

        if ($result['success']) {
            return response()->json($result['data']);
        }

        return response()->json($result['message']);
    }

    public function downloadTemplate()
    {
        return Excel::download(new PenyuluhTerdaftarTemplate(), 'penyuluh_terdaftar.xlsx');
    }

    public function import(FileExcelRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $import = new PenyuluhTerdaftarImport();
            Excel::import($import, $data['file']);

            $failures = $import->getFailures();

            if (!empty($failures)) {
                return redirect()->route('penyuluh-terdaftar.index')->with([
                    'success' => 'Data berhasil diimport, namun ada beberapa data yang gagal.',
                    'failures' => $failures
                ]);
            }

            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('penyuluh-terdaftar.index')->with('error', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new PenyuluhTerdaftarExport(), 'penyuluh_terdaftar.xlsx');
    }
}
