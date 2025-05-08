<?php

namespace App\Http\Controllers;
use App\Http\Requests\LaporanBantuanAlat;
use App\Services\LaporanBantuanAlatService;

use Illuminate\Http\Request;

class LaporanBantuanAlatController extends Controller
{
    protected LaporanBantuanAlatService $laporanService;
    public function __construct(LaporanBantuanAlatService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index()
    {
        $laporans = $this->laporanService->getAll();
        return view('pages.laporan_alat.index', compact('laporans'));
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
    public function store(LaporanBantuanAlat $request)
    {
        $validated = $request->validated();
        $laporan = $this->laporanService->create($validated);

        if ($laporan) {
            return response()->json([
                'message' => 'Laporan Berhasil Ditambahkan',
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
        return view('pages.laporan_alat.verifikasi-alat', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required'
        ], ['status.required' => 'Silahkan Pilih Status Verifikasi Laporan Bantuan Alat!']);
        // dd($request->status);
        $result = $this->laporanService->update($id, ['status' => $request->status]);

        if ($result) {
            return redirect()->route('laporan-alat.index')->with('success', 'Laporan berhasil diverifikasi');
        }

        return redirect()->route('laporan-alat.index')->with('failed', 'Laporan gagal diverifikasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->laporanService->delete($id);

        return redirect()->route('laporan-alat.index')->with('success', 'Data berhasil dihapus');
    }

}
