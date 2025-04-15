<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LaporanBibitRequest;
use App\Services\LaporanBibitService;

class LaporanBibitController extends Controller
{
    protected LaporanBibitService $laporanService;
    public function __construct(LaporanBibitService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporans = $this->laporanService->getAll();
        return view('pages.laporan_bibit.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaporanBibitRequest $request)
    {
        $validated = $request->validated();

        $laporan = $this->laporanService->create($validated);

        if ($laporan) {
            return response()->json([
                'message' => 'Report sent successfully',
                'data' => $laporan,
            ], 201);
        }

        return response()->json([
            'message' => 'Laporan gagal disimpan'
        ], 400);
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
        $laporan = $this->laporanService->getById($id);
        return view('pages.laporan_bibit.verifikasi-bibit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required'
        ], ['status.required' => 'Silahkan pilih opsi kualitas bibit yang tersedia']);
        // dd($request->status);
        $result = $this->laporanService->update($id, ['status' => $request->status]);

        if ($result) {
            return redirect()->route('laporan-bibit.index')->with('success', 'Laporan berhasil diverifikasi');
        }

        return redirect()->route('laporan-bibit.index')->with('failed', 'Laporan gagal diverifikasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->laporanService->delete($id);

        return redirect()->route('laporan-bibit.index')->with('success', 'Data berhasil dihapus');
    }
}
