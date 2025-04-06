<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelompokTaniRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|min:3|max:255|regex:/^[A-Za-z\s\',.]+$/',
            'desa_id' => 'required|exists:desas,id',
            'kecamatan_id' => 'required|exists:kecamatans,id',
            'penyuluh_terdaftar_id' => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            // nama
            'nama.required' => 'Nama wajib diisi!',
            'nama.min' => 'Nama minimal terdiri dari :min karakter.',
            'nama.max' => 'Nama maksimal terdiri dari :max karakter.',
            'nama.regex' => 'Nama hanya boleh terdiri dari huruf, tanda petik satu, koma, titik dan spasi.',

            // desa
            'desa_id.required' => 'Silakan pilih desa yang tersedia!',
            'desa_id.exists' => 'Desa yang dipilih tidak terdaftar.',

            // kecamatan
            'kecamatan_id.required' => 'Silakan pilih kecamatan yang tersedia!',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak terdaftar.',

            // penyuluh terdaftar
            'penyuluh_terdaftar_id.required' => 'Silakan pilih penyuluh yang tersedia!',
            'penyuluh_terdaftar_id.exists' => 'Penyuluh yang dipilih tidak terdaftar.',
        ];
    }
}
