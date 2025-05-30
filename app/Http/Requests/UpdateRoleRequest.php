<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        $roleId = $this->route('id');

        return [
            'name' => 'required|string|unique:roles,name,' . $roleId,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama role wajib diisi!',
            'name.string' => 'Nama role harus berupa string.',
            'name.unique' => 'Nama role sudah terdaftar.',
            'permissions.array' => 'Permission harus berupa array.',
            'permissions.*.exists' => 'Permission tidak terdaftar.',
        ];
    }
}
