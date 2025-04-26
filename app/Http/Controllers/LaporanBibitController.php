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
        $laporans = null;
        $data = $this->laporanService->getAll(true);

        if ($data['success']) {
            $laporans = $data['data'];
        }
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
        $result = $this->laporanService->create($request->validated());

        if ($result['success']) {
            return response()->json([
                'message' => 'Report sent successfully',
                'data' => $result['data'],
            ], 201);
        }

        return response()->json($result, 400);
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
        $laporan = null;
        $data = $this->laporanService->getById($id);
        if ($data['success']) {
            $laporan = $data['data'];
        }

        return view('pages.laporan_bibit.verifikasi-bibit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaporanBibitRequest $request, string $id)
    {
        $validated = $request->validated();
        $result = $this->laporanService->update($id, ['status' => $validated['status']]);

        if ($result['success']) {
            return redirect()->route('laporan-bibit.index')->with('success', 'Laporan berhasil diverifikasi');
        }
        return redirect()->route('laporan-bibit.index')->with('error', 'Laporan gagal diverifikasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->laporanService->delete($id);
        if ($result['success']) {
            return redirect()->route('laporan-bibit.index')->with('success', 'Laporan berhasil dihapus');
        }
        return redirect()->route('laporan-bibit.index')->with('error', 'Laporan gagal dihapus');
    }
}
