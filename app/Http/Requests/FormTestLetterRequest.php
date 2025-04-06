<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormTestLetterRequest extends FormRequest
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
            'type' => ['required'],
            'sop_component_installation' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'technical_drawing' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'conversion_workshop_certificate' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'electrical_diagram' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'photocopy_stnk' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'physical_inspection' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'test_report' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ];

        if ($this->has('old_sop_component_installation') && $this->input('old_sop_component_installation')) {
            unset($rules['sop_component_installation']);
        }

        if ($this->has('old_technical_drawing') && $this->input('old_technical_drawing')) {
            unset($rules['technical_drawing']);
        }

        if ($this->has('old_conversion_workshop_certificate') && $this->input('old_conversion_workshop_certificate')) {
            unset($rules['conversion_workshop_certificate']);
        }

        if ($this->has('old_electrical_diagram') && $this->input('old_electrical_diagram')) {
            unset($rules['electrical_diagram']);
        }

        if ($this->has('old_photocopy_stnk') && $this->input('old_photocopy_stnk')) {
            unset($rules['photocopy_stnk']);
        }

        if ($this->has('old_physical_inspection') && $this->input('old_physical_inspection')) {
            unset($rules['physical_inspection']);
        }

        if ($this->has('old_test_report') && $this->input('old_test_report')) {
            unset($rules['test_report']);
        }

        return $rules;
    }

    public function messages()
    {
        return [

            'type.required' => 'Tipe wajib diisi.',
            'sop_component_installation.required' => 'Sop pemasangan komponen konversi wajib diisi.',
            'sop_component_installation.file' => 'Sop pemasangan komponen konversi harus berupa file.',
            'sop_component_installation.mimes' => 'Sop pemasangan komponen konversi wajib berformat pdf.',
            'sop_component_installation.max' => 'Sop pemasangan komponen konversi tidak boleh berukuran lebih dari 2mb.',
            'technical_drawing.required' => 'Gambar teknik wajib diisi.',
            'technical_drawing.file' => 'Gambar teknik harus berupa file.',
            'technical_drawing.mimes' => 'Gambar teknik wajib berformat pdf.',
            'technical_drawing.max' => 'Gambar teknik tidak boleh berukuran lebih dari 2mb.',
            'conversion_workshop_certificate.required' => 'Sertifikat bengkel konversi wajib diisi.',
            'conversion_workshop_certificate.file' => 'Sertifikat bengkel konversi harus berupa file.',
            'conversion_workshop_certificate.mimes' => 'Sertifikat bengkel konversi wajib berformat pdf.',
            'conversion_workshop_certificate.max' => 'Sertifikat bengkel konversi tidak boleh berukuran lebih dari 2mb.',
            'electrical_diagram.required' => 'Diagram kelistrikan wajib diisi.',
            'electrical_diagram.file' => 'Diagram kelistrikan harus berupa file.',
            'electrical_diagram.mimes' => 'Diagram kelistrikan wajib berformat pdf.',
            'electrical_diagram.max' => 'Diagram kelistrikan tidak boleh berukuran lebih dari 2mb.',
            'photocopy_stnk.required' => 'Fotokopi STNK wajib diisi.',
            'photocopy_stnk.file' => 'Fotokopi STNK harus berupa file.',
            'photocopy_stnk.mimes' => 'Fotokopi STNK wajib berformat pdf.',
            'photocopy_stnk.max' => 'Fotokopi STNK tidak boleh berukuran lebih dari 2mb.',
            'physical_inspection.required' => 'Cek fisik Kendaraan Bermotor  wajib diisi.',
            'physical_inspection.file' => 'Cek fisik Kendaraan Bermotor  harus berupa file.',
            'physical_inspection.mimes' => 'Cek fisik Kendaraan Bermotor  wajib berformat pdf.',
            'physical_inspection.max' => 'Cek fisik Kendaraan Bermotor  tidak boleh berukuran lebih dari 2mb.',
            'test_report.required' => 'Laporan pengujian wajib diisi.',
            'test_report.file' => 'Laporan pengujian harus berupa file.',
            'test_report.mimes' => 'Laporan pengujian wajib berformat pdf.',
            'test_report.max' => 'Laporan pengujian tidak boleh berukuran lebih dari 2mb.',
        ];
    }
}
