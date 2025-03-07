<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class UserRequest extends FormRequest
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
        $password = $this->id ? '' : ['required','min:8'];
        return [
            'name' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id ?? null)
            ],
            'password' => $password,
            'telephone' => ['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Gunakan format email yang benar.',
            'email.unique' => 'Email harus bersifat unik.',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password harus memiliki panjang 8 karakter',
            'telephone.required' => 'Telepon wajib diisi',
            'telephone.min' => 'Telepon harus memiliki panjang 8 karakter',
        ];
    }
}
