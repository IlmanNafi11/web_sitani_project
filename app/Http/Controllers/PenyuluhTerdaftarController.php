<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenyuluhTerdaftarRequest;
use App\Services\KecamatanService;
use App\Services\PenyuluhTerdaftarService;

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
    public function index()
    {
        $data = $this->penyuluhService->getAll(true);
        $penyuluhs = null;

        if ($data['success']) {
            $penyuluhs = $data['data'];
        }

        return view('pages.penyuluh_terdaftar.index', compact('penyuluhs'));
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

        return view('pages.penyuluh_terdaftar.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenyuluhTerdaftarRequest $request)
    {
        $result = $this->penyuluhService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('penyuluh-terdaftar.index')->with('error', 'Data gagal disimpan');
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
        $dataPenyuluh = $this->penyuluhService->getById($id);
        $dataKecamatan = $kecamatanService->getAll();
        $penyuluh = null;
        $kecamatans = null;

        if ($dataPenyuluh['success'] && $dataKecamatan['data']) {
            $penyuluh = $dataPenyuluh['data'];
            $kecamatans = $dataKecamatan['data'];
        }

        return view('pages.penyuluh_terdaftar.update', compact('penyuluh', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenyuluhTerdaftarRequest $request, string $id)
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
    public function destroy(string $id)
    {
        $result = $this->penyuluhService->delete($id);

        if ($result['success']) {
            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('penyuluh-terdaftar.index')->with('error', 'Data gagal dihapus');
    }

    public function getByKecamatanId($id)
    {
        $result = $this->penyuluhService->getByKecamatanId($id);

        if ($result['success']) {
            return response()->json($result['data']);
        }

        return response()->json($result['message']);
    }
}
