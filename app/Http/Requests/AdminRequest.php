<?php

namespace App\Http\Requests;

use App\Models\Admin;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends FormRequest
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
        $email = [];
        $admin = null;
        if (request()->method() === 'POST') {
            $email = ['required', 'email', 'unique:users,email'];
        } else if (request()->method() === 'PUT') {
            $id = request()->segment('3');
            $admin = Admin::findOrFail($id);
            $email = ['required', 'email', Rule::unique('users')->ignore($admin->user_id)];
        }

        return [
            'nama' => ['required', 'min:3', 'max:255', 'regex:/^[A-Za-z\s\',\.]+$/'],
            'no_hp' => [
                'required',
                'starts_with:08',
                'digits_between:11,13',
                Rule::unique('admins', 'no_hp')->ignore($this->id),
            ],
            'alamat' => ['required', 'min:3', 'max:255'],
            'email' => $email,
            'role' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi!',
            'nama.min' => 'Nama minimal terdiri dari :min karakter.',
            'nama.max' => 'Nama maksimal terdiri dari :max karakter.',
            'nama.regex' => 'Nama hanya boleh terdiri dari huruf, tanda petik satu, koma, titik dan spasi.',
            'no_hp.required' => 'Nomor HP wajib diisi!',
            'no_hp.starts_with' => 'Nomor HP harus dimulai dengan angka 08.',
            'no_hp.digits_between' => 'Nomor HP harus terdiri dari 11 hingga 13 digit angka.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar, gunakan nomor lain.',
            'alamat.required' => 'Alamat wajib diisi!',
            'alamat.min' => 'Alamat minimal terdiri dari :min karakter.',
            'alamat.max' => 'Alamat maksimal terdiri dari :max karakter.',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required' => 'Pilih opsi role yang tersedia!',
        ];
    }
}
