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
        // dd($laporans);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
