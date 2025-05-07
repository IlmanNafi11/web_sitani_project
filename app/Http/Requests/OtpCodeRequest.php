<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OtpCodeRequest extends FormRequest
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
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|digits:1',
        ];
    }

    public function messages(): array
    {
        return [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.array' => 'Kode OTP harus berupa array.',
            'otp.size' => 'Kode OTP harus terdiri dari 6 angka.',
            'otp.*.required' => 'Setiap digit kode OTP wajib diisi.',
            'otp.*.digits' => 'Setiap digit kode OTP harus berupa satu angka.',
        ];
    }

}
