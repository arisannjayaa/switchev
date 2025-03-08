<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class ConversionRequest extends FormRequest
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
            'application_letter' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'technician_competency' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'equipment' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'sop' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'wiring_diagram' => ['required', 'file', 'mimes:pdf', 'max:2048'],
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
            'application_letter.required' => 'Surat Permohonan wajib diisi.',
            'application_letter.file' => 'Surat Permohonan harus berupa file.',
            'application_letter.mimes' => 'Surat Permohonan wajib berformat pdf.',
            'application_letter.max' => 'Surat Permohonan tidak boleh berukuran lebih dari 2mb.',
            'technician_competency.required' => 'Lampiran wajib diisi.',
            'technician_competency.file' => 'Lampiran harus berupa file.',
            'technician_competency.mimes' => 'Lampiran wajib berformat pdf.',
            'technician_competency.max' => 'Lampiran tidak boleh berukuran lebih dari 2mb.',
            'equipment.required' => 'Data Peralatan wajib diisi.',
            'equipment.file' => 'Data Peralatan harus berupa file.',
            'equipment.mimes' => 'Data Peralatan wajib berformat pdf.',
            'equipment.max' => 'Data Peralatan tidak boleh berukuran lebih dari 2mb.',
            'sop.required' => 'SOP wajib diisi.',
            'sop.file' => 'SOP harus berupa file.',
            'sop.mimes' => 'SOP wajib berformat pdf.',
            'sop.max' => 'SOP tidak boleh berukuran lebih dari 2mb.',
            'wiring_diagram.required' => 'Wiring Diagram wajib diisi.',
            'wiring_diagram.file' => 'Wiring Diagram harus berupa file.',
            'wiring_diagram.mimes' => 'Wiring Diagram wajib berformat pdf.',
            'wiring_diagram.max' => 'Wiring Diagram tidak boleh berukuran lebih dari 2mb.',
        ];
    }
}
