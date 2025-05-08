<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class UploadPhysicalTestRequest extends FormRequest
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
        $rules =  [
            'physical_test_bpljskb' => ['required', 'file', 'max:2048'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'physical_test_bpljskb.file' => 'Lampiran harus berupa file.',
            'physical_test_bpljskb.required' => 'Lampiran wajib diisi.',
            'physical_test_bpljskb.max' => 'Lampiran max ukuran 2mb.',
        ];
    }
}
