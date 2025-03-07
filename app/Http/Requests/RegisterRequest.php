<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class RegisterRequest extends FormRequest
{
    use JsonValidateResponse;
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
            'name' => ['required'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Gunakan format email yang benar.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi',
        ];
    }
}
