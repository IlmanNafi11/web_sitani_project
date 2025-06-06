<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FcmRequest extends FormRequest
{
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
            'fcm_token' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'fcm_token.required' => 'FCM token tidak boleh kosong.',
            'fcm_token.string' => 'FCM token tidak valid.',
        ];
    }
}
