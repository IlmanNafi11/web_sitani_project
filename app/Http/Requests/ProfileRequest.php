<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'nama' => ['required', 'min:3', 'max:255', 'regex:/^[A-Za-z\s\',\.]+$/'],
            'no_hp' => ['required', 'starts_with:08', 'digits_between:11,13'],
            'alamat' => ['required', 'min:3', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 255 karakter',
            'nama.regex' => 'Nama hanya boleh terdiri dari huruf, tanda petik satu, koma, titik dan spasi.',
            'no_hp.required' => 'No. Hp tidak boleh kosong',
            'no_hp.starts_with' => 'No Hp wajib berformat 08xxx',
            'no_hp.digits_between' => 'No Hp wajib terdiri dari 11 - 13 digit',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.min' => 'Alamat minimal 3 karakter',
            'alamat.max' => 'Alamat maksimal 255 karakter',
        ];
    }
}
