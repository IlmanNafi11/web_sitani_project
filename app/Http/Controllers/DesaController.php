<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesaRequest;
use App\Services\DesaService;
use App\Services\KecamatanService;
use Illuminate\Http\Request;

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
    public function index()
    {
        $data = $this->desaService->getAll(true);
        $desas = null;

        if ($data['success']) {
            $desas = $data['data'];
        }

        return view('pages.desa.index', compact('desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KecamatanService $kecamatanService)
    {
        $data = $kecamatanService->getAll();
        $kecamatans = null;

        if ($data['success']) {
            $kecamatans = $data['data'];
        }

        return view('pages.desa.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesaRequest $request)
    {
        $result = $this->desaService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('desa.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('desa.index')->with('error', 'Data gagal disimpan');
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
    public function edit(string $id, KecamatanService $kecamatanService)
    {
        $kecamatans = null;
        $desa = null;
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
    public function update(DesaRequest $request, string $id)
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
    public function destroy(string $id)
    {
        $result = $this->desaService->delete($id);
        if ($result['success']) {
            return redirect()->route('desa.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('desa.index')->with('error', 'Data gagal dihapus');
    }

    public function getByKecamatanId($id)
    {
        $desas = $this->desaService->getByKecamatanId($id);
        if ($desas['success']) {
            return response()->json($desas['data'], 200);
        }

        return response()->json($desas['message']);
    }
}
