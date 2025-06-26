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
            'foto_fisik' => ['required', 'file', 'mimes:jpg', 'max:2048'],
            'no_induk_berusaha' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.email' => 'Gunakan format email yang benar.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi',
            'foto_fisik.required' => 'Foto wajib diisi.',
            'foto_fisik.file' => 'Foto harus berupa file.',
            'foto_fisik.mimes' => 'Foto wajib berformat jpg.',
            'foto_fisik.max' => 'Foto tidak boleh berukuran lebih dari 2mb.',
            'no_induk_berusaha.required' => 'No induk berusaha wajib diisi.',
            'no_induk_berusaha.file' => 'No induk berusaha harus berupa file.',
            'no_induk_berusaha.mimes' => 'No induk berusaha wajib berformat pdf.',
            'no_induk_berusaha.max' => 'No induk berusaha tidak boleh berukuran lebih dari 2mb.',
        ];
    }
}
