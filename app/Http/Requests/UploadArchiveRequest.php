<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class UploadArchiveRequest extends FormRequest
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
            'sk_attachment' => ['required', 'file', 'max:2048'],
            'sft_attachment' => ['required', 'file', 'max:2048'],
        ];


        if ($this->has('old_sk_attachment') && $this->input('old_sk_attachment')) {
            unset($rules['sk_attachment']);
        }

        if ($this->has('old_sft_attachment') && $this->input('old_sft_attachment')) {
            unset($rules['sft_attachment']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'sk_attachment.required' => 'Surat Keterangan wajib diisi.',
            'sft_attachment.file' => 'Sertifikat harus berupa file.',
            'sft_attachment.required' => 'Sertifikat wajib diisi.',
            'sk_attachment.file' => 'Surat Keterangan harus berupa file.',
        ];
    }
}
