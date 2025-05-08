<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormPermohonanSRUTRequest extends FormRequest
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
        $rules = [];

        $rules['permohonan_srut'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['quality_control'] = ['required', 'file', 'mimes:pdf', 'max:2048'];

        if ($this->has('old_permohonan_srut') && $this->input('old_permohonan_srut')) {
            unset($rules['permohonan_srut']);
        }

        if ($this->has('old_quality_control') && $this->input('old_quality_control')) {
            unset($rules['quality_control']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'permohonan_srut.required' => 'Permohonan SRUT wajib diisi.',
            'permohonan_srut.file' => 'Permohonan SRUT harus berupa file.',
            'permohonan_srut.mimes' => 'Permohonan SRUT wajib berformat pdf.',
            'permohonan_srut.max' => 'Permohonan SRUT tidak boleh berukuran lebih dari 2mb.',
            'quality_control.required' => 'Quality Control wajib diisi.',
            'quality_control.file' => 'Quality Control harus berupa file.',
            'quality_control.mimes' => 'Quality Control wajib berformat pdf.',
            'quality_control.max' => 'Quality Control tidak boleh berukuran lebih dari 2mb.',
        ];
    }
}
