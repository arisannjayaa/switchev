<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormChangePassword extends FormRequest
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
            'password_old' => ['required'],
            'password_new' => ['required', 'min:8'],
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!Hash::check($this->input('password_old'), Auth::user()->password)) {
                $validator->errors()->add('password_old', 'Kata sandi lama tidak sesuai.');
            }
        });
    }

    public function messages()
    {
        return [
            'password_old.required.required' => 'Kata sandi lama wajib diisi.',
            'password_new.required' => 'Password wajib diisi',
            'password_new.min' => 'Kata sandi baru minimal 8 karakter',
        ];
    }
}
