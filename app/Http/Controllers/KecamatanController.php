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
        $kecamatans = $this->kecamatanService->getAll();
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
        $validated = $this->kecamatanService->create($request->validated());
        if ($validated) {
            return redirect()->route('kecamatan.index')->with('success', 'Data Berhasil disimpan');
        }

        return redirect()->route('kecamatan.create')->with('failed', 'Data Gagal disimpan');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->kecamatanService->delete($id);
        return redirect()->route('kecamatan.index')->with('success', 'Data berhasil dihapus!');
    }
}
