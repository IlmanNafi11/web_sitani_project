<?php

namespace App\Http\Controllers;

use App\Http\Requests\KecamatanRequest;
use App\Services\KecamatanService;
use Illuminate\Http\Request;

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
    public function index()
    {
        $data = $this->kecamatanService->getAll();
        $kecamatans = null;

        if ($data['success']) {
            $kecamatans = $data['data'];
        }

        return view('pages.kecamatan.index', compact('kecamatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KecamatanRequest $request)
    {
        $result = $this->kecamatanService->create($request->validated());
        if ($result['success']) {
            return redirect()->route('kecamatan.index')->with('success', 'Data Berhasil disimpan');
        }

        return redirect()->route('kecamatan.create')->with('error', 'Data Gagal disimpan');
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
    public function edit(string $id)
    {
        $data = $this->kecamatanService->getById($id);
        $kecamatan = null;

        if ($data['success']) {
            $kecamatan = $data['data'];
        }
        return view('pages.kecamatan.update', compact('kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KecamatanRequest $request, string $id)
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
    public function destroy(string $id)
    {
        $result = $this->kecamatanService->delete($id);
        if ($result['success']) {
            return redirect()->route('kecamatan.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('kecamatan.index')->with('error', 'Data gagal dihapus');
    }
}
