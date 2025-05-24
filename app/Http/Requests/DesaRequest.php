<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DesaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'min:4',
                'max:255',
                'regex:/^[A-Za-z\s]+$/',
                Rule::unique('desas', 'nama')->ignore($this->desa),
            ],
            'kecamatan_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'nama wajib diisi!',
            'nama.unique' => 'desa sudah terdaftar.',
            'min' => ':attribute minimal terdiri dari :min',
            'max' => ':attribute maksimal terdiri dari :max',
            'kecamatan_id.required' => 'Silahkan pilih kecamatan yang tersedia!',
        ];
    }
}
