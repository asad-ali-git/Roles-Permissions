<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($this->role->id),
                function ($attribute, $value, $fail) {
                    if ($value === Role::ROLE_SUPER_ADMIN) {
                        $fail('The role name "'.Role::ROLE_SUPER_ADMIN.'" is reserved and cannot be created.');
                    }
                },
            ],
            'description' => 'nullable|string|max:1500',
            'permission_ids' => 'required|array|min:1',
            'permission_ids.*' => 'exists:permissions,id',
        ];
    }

    public function messages()
    {
        return [
            'permission_ids.required' => 'Please select at least one permission.',
            'permission_ids.array' => 'The permissions field must be an array.',
            'permission_ids.min' => 'Please select at least one permission.',
            'permission_ids.*.exists' => 'The selected permissions are invalid.',
        ];
    }
}
