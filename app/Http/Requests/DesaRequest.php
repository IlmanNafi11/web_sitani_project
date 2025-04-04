<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|min:3|max:255|regex:/^[A-Za-z\s]+$/',
            'kecamatan_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'nama wajib diisi!',
            'min' => ':attribute minimal terdiri dari :min',
            'max' => ':attribute maksimal terdiri dari :max',
            'kecamatan_id.required' => 'Silahkan pilih kecamatan yang tersedia!',
        ];
    }
}
