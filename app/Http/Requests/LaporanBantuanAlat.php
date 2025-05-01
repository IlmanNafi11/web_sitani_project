<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaporanBantuanAlat extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kelompok_tani_id' => 'required|exists:kelompok_tani_id',
            'penyuluh_id' => 'required|exist:penyuluh_id',
            'alat_diminta' => 'required', 'regex:/^[a-zA-Z0-9\s]+$/',
            'path_proposal' => 'required|string',
            'status' => 'required|string',
        ];
    }
}
