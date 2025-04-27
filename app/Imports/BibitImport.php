<?php

namespace App\Imports;

use App\Models\BibitBerkualitas;
use App\Models\Komoditas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class BibitImport implements ToModel, WithValidation, SkipsOnFailure, WithHeadingRow, SkipsEmptyRows
{
    use SkipsFailures;

    private $failuresList = [];

    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row)
    {
        $komoditas = Komoditas::whereRaw('LOWER(nama) = ?', [strtolower($row['komoditas'])])->first();

        if (!$komoditas) {
            return null;
        }

        return new BibitBerkualitas([
            'nama' => $row['nama_bibit'],
            'deskripsi' => $row['deskripsi'],
            'komoditas_id' => $komoditas->id,
        ]);
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failuresList[] = [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
            ];
        }
    }

    public function rules(): array
    {
        return [
            'nama_bibit' => ['required', 'min:3', 'max:50'],
            'komoditas' => ['required', 'exists:komoditas,nama'],
        ];
    }

    public function getFailures()
    {
        return $this->failuresList;
    }

    public function customValidationMessages(): array
    {
        return [
            'nama_bibit.required' => 'Nama bibit harus diisi.',
            'nama_bibit.min' => 'Nama bibit minimal 3 karakter.',
            'nama_bibit.max' => 'Nama bibit maksimal 50 karakter.',
            'komoditas.required' => 'Nama komoditas harus diisi.',
            'komoditas.exists' => 'Komoditas tidak ditemukan.',
        ];
    }
}
