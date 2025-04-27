<?php

namespace App\Http\Controllers;

use App\Exports\BibitExport;
use App\Exports\template\BibitTemplate;
use App\Http\Requests\BibitRequest;
use App\Http\Requests\FileExcelRequest;
use App\Imports\BibitImport;
use App\Services\BibitService;
use App\Services\KomoditasService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class BibitBerkualitasController extends Controller
{
    protected BibitService $bibitService;

    public function __construct(BibitService $bibitService)
    {
        $this->bibitService = $bibitService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = $this->bibitService->getAll(true);
        $datas = [];
        if ($data['success']) {
            $datas = $data['data'];
        }

        return view('pages.bibit.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KomoditasService $komoditasService): View
    {
        $data = $komoditasService->getAll();
        $datas = [];
        if ($data['success']) {
            $datas = $data['data'];
        }

        return view('pages.bibit.create', compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BibitRequest $request): RedirectResponse
    {
        $result = $this->bibitService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('bibit.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('bibit.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, KomoditasService $komoditasService): View
    {
        $dataBibit = $this->bibitService->getById($id);
        $dataKomoditas = $komoditasService->getAll();

        $bibit = [];
        $komoditas = [];

        if ($dataBibit['success'] && $dataKomoditas['data']) {
            $bibit = $dataBibit['data'];
            $komoditas = $dataKomoditas['data'];
        }

        return view('pages.bibit.update', compact('bibit', 'komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BibitRequest $request, string $id): RedirectResponse
    {
        $result = $this->bibitService->update($id, $request->validated());

        if ($result['success']) {
            return redirect()->route('bibit.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('bibit.index')->with('error', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->bibitService->delete($id);

        if ($result['success']) {
            return redirect()->route('bibit.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('bibit.index')->with('error', 'Data gagal dihapus');
    }

    public function downloadTemplate()
    {
        return Excel::download(new BibitTemplate(), 'bibit_berkualitas.xlsx');
    }

    public function import(FileExcelRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $import = new BibitImport();
            Excel::import($import, $data['file']);

            $failures = $import->getFailures();

            if (!empty($failures)) {
                return redirect()->route('bibit.index')->with([
                    'success' => 'Data berhasil diimport, namun ada beberapa data yang gagal.',
                    'failures' => $failures
                ]);
            }

            return redirect()->route('bibit.index')->with('success', 'Data berhasil diimport');
        } catch (\Exception $e) {
            return redirect()->route('bibit.index')->with('error', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new BibitExport(), 'bibit_berkualitas.xlsx');
    }
}
