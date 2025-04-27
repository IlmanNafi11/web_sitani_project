<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FileExcelRequest extends FormRequest
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
            'file' => 'required|mimes:xlsx,xls'
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'File tidak boleh kosong',
            'file.mimes' => 'File harus berupa file Excel',
        ];
    }
}
