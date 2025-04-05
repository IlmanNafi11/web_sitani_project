<?php

namespace App\Http\Controllers;

use App\Http\Requests\BibitRequest;
use App\Services\BibitService;
use App\Services\KomoditasService;
use Illuminate\Http\Request;

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
    public function index()
    {
        $datas = $this->bibitService->getAllWithKomoditas();

        return view('pages.bibit.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KomoditasService $komoditasService)
    {
        $datas = $komoditasService->getAll();
        return view('pages.bibit.create', compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BibitRequest $request)
    {
        $result = $this->bibitService->create($request->validated());

        if ($result) {
            return redirect()->route('bibit.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('bibit.index')->with('failed', 'Data gagal disimpan');
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
    public function edit(string $id, KomoditasService $komoditasService)
    {
        $bibit = $this->bibitService->getById($id);
        $komoditas = $komoditasService->getAll();

        return view('pages.bibit.update', compact('bibit', 'komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BibitRequest $request, string $id)
    {
        $result = $this->bibitService->update($id, $request->validated());

        if ($result) {
            return redirect()->route('bibit.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('bibit.index')->with('success', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->bibitService->delete($id);

        return redirect()->route('bibit.index')->with('success', 'Data berhasil dihapus');
    }
}
