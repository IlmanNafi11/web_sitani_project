<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelompokTaniRequest;
use App\Services\DesaService;
use App\Services\KecamatanService;
use App\Services\KelompokTaniService;
use Illuminate\Http\Request;

class KelompokTaniController extends Controller
{
    protected KelompokTaniService $kelompokTaniService;

    public function __construct(KelompokTaniService $kelompokTaniService)
    {
        $this->kelompokTaniService = $kelompokTaniService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompokTanis = $this->kelompokTaniService->getAllWithRelations();
        return view('pages.kelompok_tani.index', compact('kelompokTanis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KecamatanService $kecamatanService)
    {
        $kecamatans = $kecamatanService->getAll();
        return view('pages.kelompok_tani.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelompokTaniRequest $request)
    {
        $result = $this->kelompokTaniService->create($request->validated());

        if ($result) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('kelompok-tani.index')->with('success', 'Data gagal disimpan');
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
        $kelompokTanis = $this->kelompokTaniService->getByIdWithPivot($id);
        $kecamatans = $kecamatanService->getAll();
        return view('pages.kelompok_tani.update', compact('kelompokTanis', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelompokTaniRequest $request, string $id)
    {
        $result = $this->kelompokTaniService->update($id, $request->validated());
        if ($result) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('kelompok-tani.index')->with('failed', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->kelompokTaniService->delete($id);

        return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil dihapus');
    }

    public function getAllByPenyuluh()
    {

    }

    public function getById($id)
    {
        
    }
}
