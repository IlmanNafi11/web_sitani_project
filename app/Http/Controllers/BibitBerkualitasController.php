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
        $data = $this->bibitService->getAll(true);
        $datas = null;
        if ($data['success']) {
            $datas = $data['data'];
        }

        return view('pages.bibit.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KomoditasService $komoditasService)
    {
        $data = $komoditasService->getAll();
        $datas = null;
        if ($data['success']) {
            $datas = $data['data'];
        }

        return view('pages.bibit.create', compact('datas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BibitRequest $request)
    {
        $result = $this->bibitService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('bibit.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('bibit.index')->with('error', 'Data gagal disimpan');
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
        $dataBibit = $this->bibitService->getById($id);
        $dataKomoditas = $komoditasService->getAll();

        $bibit = null;
        $komoditas = null;

        if ($dataBibit['success'] && $dataKomoditas['data']) {
            $bibit = $dataBibit['data'];
            $komoditas = $dataKomoditas['data'];
        }

        return view('pages.bibit.update', compact('bibit', 'komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BibitRequest $request, string $id)
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
    public function destroy(string $id)
    {
        $result = $this->bibitService->delete($id);

        if ($result['success']) {
            return redirect()->route('bibit.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('bibit.index')->with('error', 'Data gagal dihapus');
    }
}
