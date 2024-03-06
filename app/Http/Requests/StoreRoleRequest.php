<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
                'unique:roles,name,except,id',
                function ($attribute, $value, $fail) {
                    if ($value === Role::ROLE_SUPER_ADMIN) {
                        $fail('The role name "'.Role::ROLE_SUPER_ADMIN.'" is reserved and cannot be created.');
                    }
                },
            ],
            'description' => 'required|string|max:1500',
        ];
    }
}
