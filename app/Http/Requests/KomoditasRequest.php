<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KomoditasRequest extends FormRequest
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
            'nama' => 'required|min:4|max:50|regex:/^[A-Za-z\s]+$/',
            'deskripsi' => 'max:255',
            'musim' => 'min:1|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi!',
            'regex' => ':attribute hanya boleh terdiri dari huruf',
            'min' => ':attribute minimal terdiri dari :min huruf',
            'max' => ':attribute maksimal terdiri dari :max huruf',
        ];
    }
}
