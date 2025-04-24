<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenyuluhTerdaftarApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:penyuluh_terdaftars,id',
            'nama_penyuluh' => 'required|min:3|max:255|regex:/^[A-Za-z\s\',\.]+$/',
            'alamat_penyuluh' => 'required|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'ID Penyuluh Terdaftar wajib diisi.',
            'id.exists' => 'Penyuluh Terdaftar Tidak Ditemukan',
            'nama_penyuluh.required' => 'Nama Penyuluh wajib diisi.',
            'nama_penyuluh.min' => 'Nama Penyuluh Minimal 3 karakter.',
            'nama_penyuluh.max' => 'Nama Penyuluh Maksimal 255 karakter.',
            'nama_penyuluh.regex' => 'Nama penyuluh hanya boleh terdiri dari huruf, tanda petik satu, koma, titik dan spasi.',
            'alamat_penyuluh.required' => 'Alamat Penyuluh wajib diisi.',
            'alamat_penyuluh.min' => 'Alamat Penyuluh Minimal 3 karakter.',
            'alamat_penyuluh.max' => 'Alamat Penyuluh Maksimal 255 karakter.',
        ];
    }
}
