<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PenyuluhRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'penyuluh_terdaftar_id' => 'required|exists:penyuluh_terdaftars,id',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'penyuluh_terdaftar_id.required' => 'Penyuluh terdaftar id harus disertakan',
            'penyuluh_terdaftar_id.exists' => 'Penyuluh tidak terdaftar',
        ];
    }
}
