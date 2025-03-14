<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormResponsibleWorkshopRequest extends FormRequest
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
            'type' => ['required'],
            'workshop' => ['required', 'max:255'],
            'address' => ['required', 'max:255'],
            'person_responsible' => ['required', 'max:255'],
            'whatapp_responsible' => ['required', 'regex:/^(?:\+62|62|0)8\d{8,11}$/'],
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Tipe wajib diisi.',
            'workshop.required' => 'Nama Bengkel wajib diisi.',
            'workshop.max' => 'Jumlah karakter maksimal 255.',
            'address.required' => 'Alamat wajib diisi.',
            'address.max' => 'Jumlah karakter maksimal 255.',
            'person_responsible.required' => 'Penanggung Jawab wajib diisi.',
            'person_responsible.max' => 'Jumlah karakter maksimal 255.',
            'whatapp_responsible.required' => 'No whatsapp wajib diisi.',
            'whatapp_responsible.regex' => 'Format no whatsapp salah.',
        ];
    }
}
