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
//        $rules =  [
//            'type' => ['required'],
//            'sop_component_installation' => ['required', 'file', 'mimes:pdf', 'max:2048'],
//            'technical_drawing' => ['required', 'file', 'mimes:pdf', 'max:2048'],
//            'conversion_workshop_certificate' => ['required', 'file', 'mimes:pdf', 'max:2048'],
//            'electrical_diagram' => ['required', 'file', 'mimes:pdf', 'max:2048'],
//            'photocopy_stnk' => ['required', 'file', 'mimes:pdf', 'max:2048'],
//            'physical_inspection' => ['required', 'file', 'mimes:pdf', 'max:2048'],
//            'test_report' => ['required', 'file', 'mimes:pdf', 'max:2048'],
//        ];

        $rules = [];

        if ($this->input('form_step') == 14) {
            $rules['conversion_type_test_application_letter'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['sop_component_installation'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['technical_drawing'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['conversion_workshop_certificate'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['electrical_diagram'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['photocopy_stnk'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['physical_inspection'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
            $rules['test_report'] = ['required', 'file', 'mimes:pdf', 'max:2048'];
        }

        if ($this->input('form_step') == 1) {
            $rules['workshop_type'] = ['required'];
            $rules['responsible_person'] = ['required'];
            $rules['telephone'] = ['required'];
            $rules['workshop'] = ['required'];
            $rules['address'] = ['required'];
        }

        if ($this->input('form_step') == 2) {
            $rules['brand'] = ['required'];
            $rules['type'] = ['required'];
            $rules['type_vehicle'] = ['required'];
            $rules['trademark'] = ['required'];
            $rules['country_of_origin'] = ['required'];
            $rules['variant'] = ['required'];
            $rules['allotment'] = ['required'];
            $rules['transmission'] = ['required'];
            $rules['drive_system'] = ['required'];
        }

        if ($this->input('form_step') == 3) {
            $rules['chassis'] = ['required'];
            $rules['chassis_place_number'] = ['required'];
            $rules['chassis_method_number'] = ['required'];
            $rules['pre_conversion_engine'] = ['required'];
            $rules['pre_conversion_engine_place_number'] = ['required'];
            $rules['pre_conversion_engine_method_number'] = ['required'];
            $rules['post_conversion_engine'] = ['required'];
            $rules['post_conversion_engine_place_number'] = ['required'];
            $rules['post_conversion_engine_method_number'] = ['required'];
        }

        if ($this->input('form_step') == 4) {
            $rules['brand_drive_motor'] = ['required'];
            $rules['type_drive_motor'] = ['required'];
            $rules['location_drive_motor'] = ['required'];
            $rules['voltage_drive_motor'] = ['required'];
            $rules['ampere_drive_motor'] = ['required'];
            $rules['power_drive_motor'] = ['required'];
            $rules['power_max_drive_motor'] = ['required'];
            $rules['rotation_drive_motor'] = ['required'];
        }

        if ($this->input('form_step') == 5) {
            $rules['conversion_voltage_fuel_system'] = ['required'];
            $rules['electrical_voltage_fuel_system'] = ['required'];
            $rules['battery_capacity_fuel_system'] = ['required'];
        }

        if ($this->input('form_step') == 6) {
            $rules['total_length_vehicle_dimension'] = ['required'];
            $rules['total_width_vehicle_dimension'] = ['required'];
            $rules['total_height_vehicle_dimension'] = ['required'];
            $rules['axis_distance_vehicle_dimension'] = ['required'];
            $rules['front_over_vehicle_dimension'] = ['required'];
            $rules['rear_over_vehicle_dimension'] = ['required'];
            $rules['ground_clearance_vehicle_dimension'] = ['required'];
        }

        if ($this->input('form_step') == 7) {
            $rules['axis_1_tire_size'] = ['required'];
            $rules['axis_2_tire_size'] = ['required'];
        }

        if ($this->input('form_step') == 8) {
            $rules['axis_1_empty_vehicle_weight'] = ['required'];
            $rules['axis_2_empty_vehicle_weight'] = ['required'];
            $rules['axis_1_axis_design_strength'] = ['required'];
            $rules['axis_2_axis_design_strength'] = ['required'];
            $rules['axis_1_jbb'] = ['required'];
            $rules['axis_2_jbb'] = ['required'];
        }

        if ($this->input('form_step') == 9) {
            $rules['transmission_type_power_forwarder'] = ['required'];
            $rules['transmission_control_system_power_forwarder'] = ['required'];
            $rules['clutch_type_power_forwarder'] = ['required'];
        }

        if ($this->input('form_step') == 10) {
            $rules['control_braking_system'] = ['required'];
            $rules['front_brake_type_braking_system'] = ['required'];
            $rules['rear_brake_type_braking_system'] = ['required'];
        }

        if ($this->input('form_step') == 11) {
            $rules['front_type_suspension_system'] = ['required'];
            $rules['front_spring_type_suspension_system'] = ['required'];
            $rules['front_shock_absorber_type_suspension_system'] = ['required'];
            $rules['rear_type_suspension_system'] = ['required'];
            $rules['rear_spring_type_suspension_system'] = ['required'];
            $rules['rear_shock_absorber_type_suspension_system'] = ['required'];
        }

        if ($this->input('form_step') == 12) {
            $rules['type_steering_system'] = ['required'];
            $rules['placement_steering_system'] = ['required'];
            $rules['wheel_steering_system'] = ['required'];
            $rules['amount_wheel_steering_system'] = ['required'];
            $rules['setting_wheel_steering_system'] = ['required'];
        }

        if ($this->input('form_step') == 13) {
            $rules['body_and_frame_arrangement_other'] = ['required'];
            $rules['main_light_other'] = ['required'];
            $rules['main_light_amount_other'] = ['required'];
            $rules['main_light_color_other'] = ['required'];
            $rules['main_light_power_other'] = ['required'];
            $rules['stop_light_other'] = ['required'];
            $rules['stop_light_amount_other'] = ['required'];
            $rules['stop_light_color_other'] = ['required'];
            $rules['stop_light_power_other'] = ['required'];
            $rules['front_turn_signal_light_other'] = ['required'];
            $rules['front_turn_signal_light_amount_other'] = ['required'];
            $rules['front_turn_signal_light_color_other'] = ['required'];
            $rules['front_turn_signal_light_power_other'] = ['required'];
            $rules['rear_turn_signal_light_other'] = ['required'];
            $rules['rear_turn_signal_light_amount_other'] = ['required'];
            $rules['rear_turn_signal_light_color_other'] = ['required'];
            $rules['rear_turn_signal_light_power_other'] = ['required'];
            $rules['speedometer_other'] = ['required'];
            $rules['drive_type_speedometer_other'] = ['required'];
            $rules['method_speedometer_other'] = ['required'];
            $rules['horn_other'] = ['required'];
            $rules['amount_horn_other'] = ['required'];
            $rules['type_horn_other'] = ['required'];
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

        return $rules;
    }

    public function messages()
    {
        return [
            'workshop_type.required' => 'Tipe wajib diisi.',
            'responsible_person.required' => 'Penanggung jawab wajib diisi.',
            'telephone.required' => 'Telepon wajib diisi.',
            'workshop.required' => 'Bengkel wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'brand.required' => 'Merek wajib diisi.',
            'type.required' => 'Tipe kendaraan wajib diisi.',
            'type_vehicle.required' => 'Jenis kendaraan wajib diisi.',
            'trademark.required' => 'Merek dagang wajib diisi.',
            'country_of_origin.required' => 'Negara asal wajib diisi.',
            'variant.required' => 'Varian wajib diisi.',
            'allotment.required' => 'Peruntukan wajib diisi.',
            'transmission.required' => 'Transmisi wajib diisi.',
            'drive_system.required' => 'Sistem penggerak wajib diisi.',
            'chassis.required' => 'Nomor rangka wajib diisi.',
            'chassis_place_number.required' => 'Tempat penomoran rangka wajib diisi.',
            'chassis_method_number.required' => 'Cara penomoran rangka wajib diisi.',
            'pre_conversion_engine.required' => 'Nomor mesin pra konversi wajib diisi.',
            'pre_conversion_engine_place_number.required' => 'Tempat penomoran mesin pra konversi wajib diisi.',
            'pre_conversion_engine_method_number.required' => 'Cara penomoran mesin pra konversi wajib diisi.',
            'post_conversion_engine.required' => 'Nomor mesin pasca konversi wajib diisi.',
            'post_conversion_engine_place_number.required' => 'Tempat penomoran mesin pasca konversi wajib diisi.',
            'post_conversion_engine_method_number.required' => 'Cara penomoran mesin pasca konversi wajib diisi.',
            'brand_drive_motor.required' => 'Merek wajib diisi.',
            'type_drive_motor.required' => 'Jenis wajib diisi.',
            'location_drive_motor.required' => 'Letak wajib diisi.',
            'voltage_drive_motor.required' => 'Tegangan kerja motor (Volt) wajib diisi.',
            'ampere_drive_motor.required' => 'Arus maksimum motor (Ampere) wajib diisi.',
            'power_drive_motor.required' => 'Daya motor (kW) wajib diisi.',
            'rotation_drive_motor.required' => 'Putaran maksimum motor (rpm) wajib diisi.',
            'power_max_drive_motor.required' => 'Daya motor maksimum (kW) wajib diisi.',
            'conversion_voltage_fuel_system.required' => 'Tegangan kerja sistem konversi wajib diisi.',
            'electrical_voltage_fuel_system.required' => 'Tegangan kerja kelistrikan kendaraan wajib diisi.',
            'battery_capacity_fuel_system.required' => 'Kapasitas Baterai wajib diisi.',
            'total_length_vehicle_dimension.required' => 'Panjang total wajib diisi.',
            'total_width_vehicle_dimension.required' => 'Lebar total wajib diisi.',
            'total_height_vehicle_dimension.required' => 'Tinggi total wajib diisi.',
            'axis_distance_vehicle_dimension.required' => 'Jarak sumbu I-II total wajib diisi.',
            'front_over_vehicle_dimension.required' => 'Julur depan total wajib diisi.',
            'rear_over_vehicle_dimension.required' => 'Julur belakang total wajib diisi.',
            'ground_clearance_vehicle_dimension.required' => 'Julur bebas total wajib diisi.',
            'axis_1_tire_size.required' => 'Sumbu I wajib diisi.',
            'axis_2_tire_size.required' => 'Sumbu II wajib diisi.',
            'axis_1_empty_vehicle_weight.required' => 'Sumbu I wajib diisi.',
            'axis_2_empty_vehicle_weight.required' => 'Sumbu II wajib diisi.',
            'axis_1_axis_design_strength.required' => 'Sumbu I wajib diisi.',
            'axis_2_axis_design_strength.required' => 'Sumbu II wajib diisi.',
            'axis_1_jbb.required' => 'Sumbu I wajib diisi.',
            'axis_2_jbb.required' => 'Sumbu II wajib diisi.',
            'transmission_type_power_forwarder.required' => 'Tipe transmisi wajib diisi.',
            'transmission_control_system_power_forwarder.required' => 'Sistem kendali transmisi wajib diisi.',
            'clutch_type_power_forwarder.required' => 'Tipe kopling wajib diisi.',
            'control_braking_system.required' => 'Pengendalian wajib diisi.',
            'front_brake_type_braking_system.required' => 'Tipe rem depan wajib diisi.',
            'rear_brake_type_braking_system.required' => 'Tipe rem belakang wajib diisi.',
            'front_type_suspension_system.required' => 'Tipe suspensi wajib diisi.',
            'front_spring_type_suspension_system.required' => 'Tipe pegas wajib diisi.',
            'front_shock_absorber_type_suspension_system.required' => 'Jenis peredam kejut wajib diisi.',
            'front_stabilizer_system_suspension_system.required' => 'JSistem stabilizer wajib diisi.',
            'rear_type_suspension_system.required' => 'Tipe suspensi wajib diisi.',
            'rear_spring_type_suspension_system.required' => 'Tipe pegas wajib diisi.',
            'rear_shock_absorber_type_suspension_system.required' => 'Jenis peredam kejut wajib diisi.',
            'rear_stabilizer_system_suspension_system.required' => 'Sistem stabilizer wajib diisi.',
            'body_and_frame_arrangement_other.required' => 'Susunan body dan frame wajib diisi.',
            'main_light_other.required' => 'Lampu utama wajib diisi.',
            'main_light_amount_other.required' => 'Jumlah lampu wajib diisi.',
            'main_light_color_other.required' => 'Warna lampu wajib diisi.',
            'main_light_power_other.required' => 'Daya lampu wajib diisi.',
            'stop_light_other.required' => 'Lampu berhenti wajib diisi.',
            'stop_light_amount_other.required' => 'Jumlah lampu wajib diisi.',
            'stop_light_color_other.required' => 'Warna lampu wajib diisi.',
            'stop_light_power_other.required' => 'Daya lampu wajib diisi.',
            'front_turn_signal_light_other.required' => 'Lampu sein depan berhenti wajib diisi.',
            'front_turn_signal_light_amount_other.required' => 'Jumlah lampu wajib diisi.',
            'front_turn_signal_light_color_other.required' => 'Warna lampu wajib diisi.',
            'front_turn_signal_light_power_other.required' => 'Daya lampu wajib diisi.',
            'rear_turn_signal_light_other.required' => 'Lampu sein belakang berhenti wajib diisi.',
            'rear_turn_signal_light_amount_other.required' => 'Jumlah lampu wajib diisi.',
            'rear_turn_signal_light_color_other.required' => 'Warna lampu wajib diisi.',
            'rear_turn_signal_light_power_other.required' => 'Daya lampu wajib diisi.',
            'speedometer_other.required' => 'Speedometer wajib diisi.',
            'drive_type_speedometer_other.required' => 'Tipe penggerak wajib diisi.',
            'method_speedometer_other.required' => 'Unjuk kerja wajib diisi.',
            'horn_other.required' => 'Klakson wajib diisi.',
            'amount_horn_other.required' => 'Jumlah klakson wajib diisi.',
            'type_horn_other.required' => 'Tipe klakson wajib diisi.',
            'type_steering_system.required' => 'Tipe wajib diisi.',
            'placement_steering_system.required' => 'Penempatan wajib diisi.',
            'wheel_steering_system.required' => 'Lingkar kemudi wajib diisi.',
            'amount_wheel_steering_system.required' => 'Jumlah perputaran wajib diisi.',
            'setting_wheel_steering_system.required' => 'Setelan roda wajib diisi.',
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
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'voltage_drive_motor' => $this->convertToNumber($this->voltage_drive_motor),
            'ampere_drive_motor' => $this->convertToNumber($this->ampere_drive_motor),
            'power_drive_motor' => $this->convertToNumber($this->power_drive_motor),
            'power_max_drive_motor' => $this->convertToNumber($this->power_max_drive_motor),
            'rotation_drive_motor' => $this->convertToNumber($this->rotation_drive_motor),
            'conversion_voltage_fuel_system' => $this->convertToNumber($this->conversion_voltage_fuel_system),
            'electrical_voltage_fuel_system' => $this->convertToNumber($this->electrical_voltage_fuel_system),
            'battery_capacity_fuel_system' => $this->convertToNumber($this->battery_capacity_fuel_system),
            'total_length_vehicle_dimension' => $this->convertToNumber($this->total_length_vehicle_dimension),
            'total_width_vehicle_dimension' => $this->convertToNumber($this->total_width_vehicle_dimension),
            'total_height_vehicle_dimension' => $this->convertToNumber($this->total_height_vehicle_dimension),
            'axis_distance_vehicle_dimension' => $this->convertToNumber($this->axis_distance_vehicle_dimension),
            'front_over_vehicle_dimension' => $this->convertToNumber($this->front_over_vehicle_dimension),
            'rear_over_vehicle_dimension' => $this->convertToNumber($this->rear_over_vehicle_dimension),
            'ground_clearance_vehicle_dimension' => $this->convertToNumber($this->ground_clearance_vehicle_dimension),
            'axis_1_empty_vehicle_weight' => $this->convertToNumber($this->axis_1_empty_vehicle_weight),
            'axis_2_empty_vehicle_weight' => $this->convertToNumber($this->axis_2_empty_vehicle_weight),
            'axis_1_axis_design_strength' => $this->convertToNumber($this->axis_1_axis_design_strength),
            'axis_2_axis_design_strength' => $this->convertToNumber($this->axis_2_axis_design_strength),
            'axis_1_jbb' => $this->convertToNumber($this->axis_1_jbb),
            'axis_2_jbb' => $this->convertToNumber($this->axis_2_jbb),
            'wheel_steering_system' => $this->convertToNumber($this->wheel_steering_system),
        ]);
    }

    // Fungsi untuk mengubah nilai menjadi angka
    private function convertToNumber($value)
    {
        $value = preg_replace('/[^0-9.,-]/', '', $value);
        $value = str_replace(',', '.', $value);
        return (float) $value;
    }
}
