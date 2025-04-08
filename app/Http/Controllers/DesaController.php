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
        $desas = $this->desaService->getAllWithKecamatan();
        return view('pages.desa.index', compact('desas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KecamatanService $kecamatanService)
    {
        $kecamatans = $kecamatanService->getAll();
        return view('pages.desa.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesaRequest $request)
    {
        $result = $this->desaService->create($request->validated());

        if ($result) {
            return redirect()->route('desa.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('desa.index')->with('failed', 'Data gagal disimpan');
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
        $kecamatans = $kecamatanService->getAll();
        $desa = $this->desaService->getById($id);
        return view('pages.desa.update', compact('kecamatans', 'desa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesaRequest $request, string $id)
    {
        $result = $this->desaService->update($id, $request->validated());

        if ($result) {
            return redirect()->route('desa.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('desa.index')->with('failed', 'Gagal memperbarui data desa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->desaService->delete($id);

        return redirect()->route('desa.index')->with('success', 'Data berhasil dihapus');
    }

    public function getByKecamatanId($id)
    {
        $desas = $this->desaService->getByKecamatanId($id);
        if ($desas->isNotEmpty()) {
            return response()->json($desas);
        }

        return response()->json([
            "message" => "Data desa kosong",
        ]);
    }
}
