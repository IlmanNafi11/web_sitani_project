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
        $datas = $this->komoditasService->getAll();

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

        if ($result) {
            return redirect()->route('komoditas.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('komoditas.index')->with('failed', 'Data gagal disimpan');
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
        $komoditas = $this->komoditasService->getById($id);

        return view('pages.komoditas.update', compact('komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KomoditasRequest $request, string $id)
    {
        $result = $this->komoditasService->update($id, $request->validated());

        if ($result) {
            return redirect()->route('komoditas.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('komoditas.index')->with('failed', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->komoditasService->delete($id);

        return redirect()->route('komoditas.index')->with('success', 'Data berhasil dihapus');
    }

    public function getAll()
    {

    }

    public function getById($id)
    {

    }
}
