<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormSendSpuRequest extends FormRequest
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
        $rules = [
            'spu_attachment' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'spu_attachment.required' => 'Surat Pengantar Uji wajib diisi.',
            'spu_attachment.file' => 'Surat Pengantar Uji harus berupa file.',
            'spu_attachment.mimes' => 'Surat Pengantar Uji wajib berformat pdf.',
            'spu_attachment.max' => 'Surat Pengantar Uji tidak boleh berukuran lebih dari 2mb.',
        ];

    }
}
