<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhonePenyuluhRequest extends FormRequest
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
            'no_hp' => 'required|starts_with:08|digits_between:11,13|exists:penyuluh_terdaftars,no_hp',
        ];
    }

    public function messages(): array
    {
        return [
            'no_hp.required' => 'No hp harus diisi',
            'no_hp.starts_with' => 'No hp harus berformat 08xxx',
            'no_hp.digits_between' => 'No Hp harus terdiri dari 11 - 13 digit',
            'no_hp.exists' => 'No Hp Penyuluh Tidak ditemukan',
        ];
    }
}
