<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class CandidateRequest extends FormRequest
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
            'name' => [
                'required',
            ],
            'photo' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
            'vision' => [
                'required',
            ],
            'mission' => [
                'required',
            ],
        ];

        if ($this->photo == null || $this->photo == '') {
            if (empty($_FILES['photo']['name'])) {
                return $rules;
            }
        }

        if($this->hasFile('photo')) {
            return $rules;
        }

        $rules['photo'] = [
            'nullable',
        ];

        return  $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'photo.required' => 'Foto wajib diisi.',
            'photo.file' => 'Foto harus berupa file.',
            'photo.mimes' => 'Foto wajib berformat jpg,jpeg,png.',
            'photo.max' => 'Foto tidak boleh berukuran lebih dari 2mb.',
            'vision.required' => 'Visi wajib diisi.',
            'mission.required' => 'misi wajib diisi.',
        ];
    }
}
