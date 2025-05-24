<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KecamatanRequest extends FormRequest
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
                Rule::unique('kecamatans', 'nama')->ignore($this->kecamatan),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi!',
            'regex' => ':attribute hanya boleh terdiri dari huruf',
            'min' => ':attribute minimal terdiri dari :min huruf',
            'max' => ':attribute maksimal terdiri dari :max huruf',
            'unique' => ':attribute sudah ada.',
        ];
    }
}
