<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanBibitRequest;
use App\Services\LaporanBibitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
    public function index(): View
    {
        $laporans = [];
        $data = $this->laporanService->getAll(true);

        if ($data['success']) {
            $laporans = $data['data'];
        }
        return view('pages.laporan_bibit.index', compact('laporans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $laporan = [];
        $data = $this->laporanService->getById($id);
        if ($data['success']) {
            $laporan = $data['data'];
        }

        return view('pages.laporan_bibit.verifikasi-bibit', compact('laporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaporanBibitRequest $request, string $id): RedirectResponse
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
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->laporanService->delete($id);
        if ($result['success']) {
            return redirect()->route('laporan-bibit.index')->with('success', 'Laporan berhasil dihapus');
        }
        return redirect()->route('laporan-bibit.index')->with('error', 'Laporan gagal dihapus');
    }
}
