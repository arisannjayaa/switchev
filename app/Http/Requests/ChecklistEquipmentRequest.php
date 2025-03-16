<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class ChecklistEquipmentRequest extends FormRequest
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
    public function rules()
    {
        return [
            'status' => 'required|array',
            'status.*' => 'required|in:Sesuai,Tidak Sesuai',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status harus diisi.',
            'status.array' => 'Data status tidak valid.',
            'status.*.required' => 'Setiap peralatan harus memiliki status.',
            'status.*.in' => 'Status hanya bisa "Sesuai" atau "Tidak Sesuai".',
        ];
    }
}
