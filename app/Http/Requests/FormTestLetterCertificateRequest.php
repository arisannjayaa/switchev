<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEasyRepository\Traits\JsonValidateResponse;

class FormTestLetterCertificateRequest extends FormRequest
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
        'brand' => ['required'],
        'vehicle_type' => ['required'],
        'type' => ['required'],
        'purpose_vehicle' => ['required'],
        'chassis' => ['required'],
        'electric_motor_number' => ['required'],
        'machine' => ['required'],
        'goods_capacity' => ['required'],
        'year_build' => ['required','digits:4'],
        'axis_1_2' => ['required'],
        'width_total' => ['required'],
        'length_total' => ['required'],
        'height_total' => ['required'],
        'julur_front' => ['required'],
        'julur_rear' => ['required'],
        'power_max' => ['required'],
        'battery_max' => ['required'],
        'tire_axis_1' => ['required'],
        'tire_axis_2' => ['required'],
        'jbb' => ['required'],
        'empty_weight' => ['required'],
        'jbi' => ['required'],
        'carry_capacity' => ['required'],
        'road_class' => ['required'],
        'date_bpljskb' => ['required', 'date'],
        'workshop' => ['required'],
        'address' => ['required'],
        'responsible_person' => ['required'],
        'testing_null' => ['required'],
    ];

        if ($this->input('workshop_type') == "A" && $this->input('test_letter_step') != 'create_certificate_srut') {
            unset($rules['machine']);
        }

        if (!$this->has('testing_null')) {
            unset($rules['testing_null']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'brand.required' => 'Merek wajib diisi.',
            'vehicle_type.required' => 'Jenis kendaraan wajib diisi.',
            'type.required' => 'Tipe kendaraan wajib diisi.',
            'purpose_vehicle.required' => 'Tujuan kendaraan wajib diisi.',
            'chassis.required' => 'Nomor rangka wajib diisi.',
            'electric_motor_number.required' => 'Nomor motor listrik wajib diisi.',
            'machine.required' => 'Nomor mesin wajib diisi.',
            'goods_capacity.required' => 'Daya angkut barang wajib diisi.',
            'year_build.required' => 'Tahun pembuatan wajib diisi.',
            'year_build.integer' => 'Tahun pembuatan harus berupa angka.',
            'year_build.digits' => 'Tahun pembuatan harus terdiri dari 4 digit.',
            'axis_1_2.required' => 'Jarak sumbu 1-2 wajib diisi.',
            'width_total.required' => 'Lebar total wajib diisi.',
            'length_total.required' => 'Panjang total wajib diisi.',
            'height_total.required' => 'Tinggi total wajib diisi.',
            'julur_front.required' => 'Julur depan wajib diisi.',
            'julur_rear.required' => 'Julur belakang wajib diisi.',
            'power_max.required' => 'Daya maksimum wajib diisi.',
            'battery_max.required' => 'Kapasitas baterai wajib diisi.',
            'tire_axis_1.required' => 'Ban sumbu 1 wajib diisi.',
            'tire_axis_2.required' => 'Ban sumbu 2 wajib diisi.',
            'jbb.required' => 'JBB wajib diisi.',
            'empty_weight.required' => 'Berat kosong wajib diisi.',
            'jbi.required' => 'JBI wajib diisi.',
            'carry_capacity.required' => 'Daya angkut wajib diisi.',
            'road_class.required' => 'Kelas jalan wajib diisi.',
            'date_bpljskb.required' => 'Tanggal BPLJSKB wajib diisi.',
            'date_bpljskb.date' => 'Format tanggal BPLJSKB tidak valid.',
            'place_test_bpljskb.required' => 'Tempat pengujian BPLJSKB wajib diisi.',
            'responsible_person.required' => 'Penanggung jawab wajib diisi.',
            'workshop.required' => 'Bengkel wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'testing_null.required' => 'Hasil uji tidak boleh kosong.',
        ];

    }
}
