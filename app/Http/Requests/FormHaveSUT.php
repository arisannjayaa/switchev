<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormHaveSUT extends FormRequest
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

        $rules['quality_control'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['type_test_attachment'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['conversion_type_test_application_letter'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['sop_component_installation'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['technical_drawing'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['conversion_workshop_certificate'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['electrical_diagram'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['photocopy_stnk'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['physical_inspection'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['test_report'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        $rules['workshop_type'] = ['required'];
        $rules['responsible_person'] = ['required'];
        $rules['telephone'] = ['required', 'regex:/^(?:\+62|62|0)8\d{8,11}$/'];
        $rules['workshop'] = ['required'];
        $rules['address'] = ['required'];

        if ($this->has('old_quality_control') && $this->input('old_quality_control')) {
            unset($rules['quality_control']);
        }

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

        if ($this->has('old_conversion_type_test_application_letter') && $this->input('old_conversion_type_test_application_letter')) {
            unset($rules['conversion_type_test_application_letter']);
        }
        if ($this->has('old_type_test_attachment') && $this->input('old_type_test_attachment')) {
            unset($rules['type_test_attachment']);
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
            'workshop_type.required' => 'Tipe wajib diisi.',
            'responsible_person.required' => 'Penanggung jawab wajib diisi.',
            'telephone.required' => 'Telepon wajib diisi.',
            'telephone.regex' => 'Format telepon salah.',
            'workshop.required' => 'Bengkel wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
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
            'conversion_type_test_application_letter.required' => 'Surat permohonan uji tipe konversi Kendaraan Bermotor  wajib diisi.',
            'conversion_type_test_application_letter.file' => 'Surat permohonan uji tipe konversi Kendaraan Bermotor  harus berupa file.',
            'conversion_type_test_application_letter.mimes' => 'Surat permohonan uji tipe konversi Kendaraan Bermotor  wajib berformat pdf.',
            'conversion_type_test_application_letter.max' => 'Surat permohonan uji tipe konversi Kendaraan Bermotor  tidak boleh berukuran lebih dari 2mb.',
            'test_report.required' => 'Laporan pengujian wajib diisi.',
            'test_report.file' => 'Laporan pengujian harus berupa file.',
            'test_report.mimes' => 'Laporan pengujian wajib berformat pdf.',
            'test_report.max' => 'Laporan pengujian tidak boleh berukuran lebih dari 2mb.',
            'type_test_attachment.required' => 'Lampiran SUT wajib diisi.',
            'type_test_attachment.file' => 'Lampiran SUT harus berupa file.',
            'type_test_attachment.mimes' => 'Lampiran SUT wajib berformat pdf.',
            'type_test_attachment.max' => 'Lampiran SUT tidak boleh berukuran lebih dari 2mb.',
        ];
    }
}
