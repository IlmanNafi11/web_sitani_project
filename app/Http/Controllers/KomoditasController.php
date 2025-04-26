<?php

namespace App\Http\Controllers;

use App\Http\Requests\KomoditasRequest;
use App\Services\KomoditasService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

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
    public function index(): View
    {
        $data = $this->komoditasService->getAll();
        $datas = [];
        if ($data['success']) {
            $datas = $data['data'];
        }

        return view('pages.komoditas.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.komoditas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KomoditasRequest $request): RedirectResponse
    {
        $result = $this->komoditasService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('komoditas.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('komoditas.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $data = $this->komoditasService->getById($id);
        $komoditas = [];
        if ($data['success']) {
            $komoditas = $data['data'];
        }

        return view('pages.komoditas.update', compact('komoditas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KomoditasRequest $request, string $id): RedirectResponse
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
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->komoditasService->delete($id);
        if ($result['success']) {
            return redirect()->route('komoditas.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('komoditas.index')->with('error', 'Data Gagal dihapus');
    }
}
