<?php

namespace App\Http\Controllers;

use App\Http\Requests\PenyuluhTerdaftarRequest;
use App\Services\KecamatanService;
use App\Services\PenyuluhTerdaftarService;
use Illuminate\Http\Request;

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
        $penyuluhs = $this->penyuluhService->getAllWithKecamatan();

        return view('pages.penyuluh_terdaftar.index', compact('penyuluhs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KecamatanService $kecamatanService)
    {
        $kecamatans = $kecamatanService->getAll();

        return view('pages.penyuluh_terdaftar.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PenyuluhTerdaftarRequest $request)
    {
        $result = $this->penyuluhService->create($request->validated());

        if ($result) {
            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('penyuluh-terdaftar.index')->with('failed', 'Data gagal disimpan');
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
        $penyuluh = $this->penyuluhService->getById($id);
        $kecamatans = $kecamatanService->getAll();

        return view('pages.penyuluh_terdaftar.update', compact('penyuluh', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PenyuluhTerdaftarRequest $request, string $id)
    {
        $result = $this->penyuluhService->update($id, $request->validated());

        if ($result) {
            return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('penyuluh-terdaftar.index')->with('failed', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->penyuluhService->delete($id);

        return redirect()->route('penyuluh-terdaftar.index')->with('success', 'Data berhasil dihapus');
    }
}
