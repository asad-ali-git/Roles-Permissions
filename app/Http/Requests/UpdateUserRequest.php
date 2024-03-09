<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'The role field is required.',
            'role_id.integer' => 'The role field must be an integer.',
            'role_id.exists' => 'The selected role is invalid.',
        ];
    }
}
