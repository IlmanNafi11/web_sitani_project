<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelompokTaniRequest;
use App\Services\KecamatanService;
use App\Services\KelompokTaniService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
    public function index(): View
    {
        $data = $this->kelompokTaniService->getAll(true);
        $kelompokTanis = [];

        if ($data['success']) {
            $kelompokTanis = $data['data'];
        }
        return view('pages.kelompok_tani.index', compact('kelompokTanis'));
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

        return view('pages.kelompok_tani.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelompokTaniRequest $request): RedirectResponse
    {
        $result = $this->kelompokTaniService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('kelompok-tani.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, KecamatanService $kecamatanService): View
    {
        $kelompokTanis = [];
        $kecamatans = [];
        $dataKelompokTanis = $this->kelompokTaniService->getById($id);
        $dataKecamatans = $kecamatanService->getAll();

        if ($dataKelompokTanis['success'] && $dataKecamatans['success']) {
            $kelompokTanis = $dataKelompokTanis['data'];
            $kecamatans = $dataKecamatans['data'];
        }

        return view('pages.kelompok_tani.update', compact('kelompokTanis', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelompokTaniRequest $request, string $id): RedirectResponse
    {
        $result = $this->kelompokTaniService->update($id, $request->validated());
        if ($result['success']) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('kelompok-tani.index')->with('error', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->kelompokTaniService->delete($id);
        if ($result['success']) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('kelompok-tani.index')->with('error', 'Data gagal dihapus');
    }
}
