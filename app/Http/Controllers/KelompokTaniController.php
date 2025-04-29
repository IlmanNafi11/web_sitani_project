<?php

namespace App\Http\Controllers;

use App\Exports\KelompokTaniExport;
use App\Exports\template\KelompokTaniTemplate;
use App\Http\Requests\FileExcelRequest;
use App\Http\Requests\KelompokTaniRequest;
use App\Imports\KelompokTaniImport;
use App\Services\KecamatanService;
use App\Services\KelompokTaniService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class KelompokTaniController extends Controller
{
    protected KelompokTaniService $kelompokTaniService;

    public function __construct(KelompokTaniService $kelompokTaniService)
    {
        $this->kelompokTaniService = $kelompokTaniService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = $this->kelompokTaniService->getAll(true);
        $kelompokTanis = [];

        if ($data['success']) {
            $kelompokTanis = $data['data'];
        }
        return view('pages.kelompok_tani.index', compact('kelompokTanis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(KecamatanService $kecamatanService): View
    {
        $data = $kecamatanService->getAll();
        $kecamatans = [];
        if ($data['success']) {
            $kecamatans = $data['data'];
        }

        return view('pages.kelompok_tani.create', compact('kecamatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelompokTaniRequest $request): RedirectResponse
    {
        $result = $this->kelompokTaniService->create($request->validated());

        if ($result['success']) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil disimpan');
        }

        return redirect()->route('kelompok-tani.index')->with('error', 'Data gagal disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, KecamatanService $kecamatanService): View
    {
        $kelompokTanis = [];
        $kecamatans = [];
        $dataKelompokTanis = $this->kelompokTaniService->getById($id);
        $dataKecamatans = $kecamatanService->getAll();

        if ($dataKelompokTanis['success'] && $dataKecamatans['success']) {
            $kelompokTanis = $dataKelompokTanis['data'];
            $kecamatans = $dataKecamatans['data'];
        }

        return view('pages.kelompok_tani.update', compact('kelompokTanis', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelompokTaniRequest $request, string $id): RedirectResponse
    {
        $result = $this->kelompokTaniService->update($id, $request->validated());
        if ($result['success']) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('kelompok-tani.index')->with('error', 'Data gagal diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $result = $this->kelompokTaniService->delete($id);
        if ($result['success']) {
            return redirect()->route('kelompok-tani.index')->with('success', 'Data berhasil dihapus');
        }
        return redirect()->route('kelompok-tani.index')->with('error', 'Data gagal dihapus');
    }

    /**
     * Download Template
     */
    public function downloadTemplate()
    {
        return Excel::download(new KelompokTaniTemplate(), 'kelompok_tani.xlsx');
    }

    /**
     * Import data
     *
     * @param FileExcelRequest $request Form request
     * @return RedirectResponse
     */
    public function import(FileExcelRequest $request): RedirectResponse
    {
        $request->validated();

        $import = new KelompokTaniImport();

        try {
            Excel::import($import, $request->file('file'));

            $failures = $import->getFailures();

            if ($failures->isNotEmpty()) {
                $formattedFailures = $failures->map(function ($failure) {
                    return [
                        'row' => $failure->row(),
                        'attribute' => $failure->attribute(),
                        'errors' => $failure->errors(),
                    ];
                })->toArray();

                return back()
                ->with('import_status', 'warning')
                ->with('import_message', 'Import selesai dengan beberapa baris data bermasalah.')
                ->with('failures', $formattedFailures);

            }

            return back()
            ->with('import_status', 'success')
                ->with('import_message', 'Data Kelompok Tani berhasil diimpor seluruhnya.');

        } catch (ValidationException $e) {
            $failures = $e->failures();

            $formattedFailures = $failures->map(function ($failure) {
                return [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                ];
            })->toArray();

            return back()
            ->with('import_status', 'danger')
            ->with('import_message', 'Import gagal karena validasi data tidak sesuai aturan yang ditentukan.')
            ->with('failures', $formattedFailures);

        } catch (\Exception $e) {
            Log::error('Terjadi kesalahan umum saat import Kelompok Tani: ' . $e->getMessage(), ['exception' => $e]);
            return back()
            ->with('import_status', 'danger')
                ->with('import_message', 'Terjadi kesalahan umum saat mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Export data
     */
    public function export()
    {
        return Excel::download(new KelompokTaniExport(), 'kelompok_tani.xlsx');
    }
}
