<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormArchiveTestLetterCertificateRequest extends FormRequest
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
            'sk_attachment' => ['required', 'file', 'max:2048', 'mimes:pdf'],
            'type_test_attachment' => ['required', 'file', 'max:2048', 'mimes:pdf'],
            'registration_attachment' => ['required', 'file', 'max:2048', 'mimes:pdf'],
            'certificate_attachment' => ['required', 'file', 'max:2048', 'mimes:pdf'],
        ];


        if ($this->has('old_sk_attachment') && $this->input('old_sk_attachment')) {
            unset($rules['sk_attachment']);
        }

        if ($this->has('old_type_test_attachment') && $this->input('old_type_test_attachment')) {
            unset($rules['type_test_attachment']);
        }

        if ($this->has('old_registration_attachment') && $this->input('old_registration_attachment')) {
            unset($rules['registration_attachment']);
        }

        if ($this->has('old_certificate_attachment') && $this->input('old_certificate_attachment')) {
            unset($rules['certificate_attachment']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'sk_attachment.required' => 'Surat Keterangan wajib diisi.',
            'type_test_attachment.file' => 'Sertifikat SUT harus berupa file.',
            'type_test_attachment.mimes' => 'Sertifikat SUT harus berupa pdf.',
            'type_test_attachment.required' => 'Sertifikat SUT wajib diisi.',
            'sk_attachment.file' => 'Surat Keterangan harus berupa file.',
            'sk_attachment.mimes' => 'Surat Keterangan harus berupa pdf.',
            'registration_attachment.file' => 'Sertifikat SRUT harus berupa file.',
            'registration_attachment.mimes' => 'Sertifikat SRUT harus berupa pdf.',
            'registration_attachment.required' => 'Sertifikat SRUT wajib diisi.',
            'certificate_attachment.file' => 'Lampiran harus berupa file.',
            'certificate_attachment.mimes' => 'Lampiran harus berupa pdf.',
            'certificate_attachment.required' => 'Lampiran wajib diisi.',
        ];
    }
}
