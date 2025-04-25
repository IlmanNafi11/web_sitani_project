<?php

namespace App\Http\Controllers;

use App\Http\Requests\KomoditasRequest;
use App\Services\KomoditasService;
use Illuminate\Http\Request;

class KomoditasController extends Controller
{

    protected KomoditasService $komoditasService;

    public function __construct(KomoditasService $komoditasService)
    {
        $this->komoditasService = $komoditasService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->komoditasService->getAll();
        $datas = null;
        if ($data['success']) {
            $datas = $data['data'];
        }

        return view('pages.komoditas.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.komoditas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KomoditasRequest $request)
    {
        $result = $this->komoditasService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('komoditas.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('komoditas.index')->with('error', 'Data gagal disimpan');
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
        $data = $this->komoditasService->getById($id);
        $komoditas = null;
        if ($data['success']) {
            $komoditas = $data['data'];
        }

        return view('pages.komoditas.update', compact('komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KomoditasRequest $request, string $id)
    {
        $result = $this->komoditasService->update($id, $request->validated());

        if ($result['success']) {
            return redirect()->route('komoditas.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('komoditas.index')->with('error', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->komoditasService->delete($id);
        if ($result['success']) {
            return redirect()->route('komoditas.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('komoditas.index')->with('error', 'Data Gagal dihapus');
    }
}
