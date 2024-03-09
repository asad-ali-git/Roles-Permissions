<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,except,id',
            'password' => 'required|min:6',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'The role field is required.',
        ];
    }
}
