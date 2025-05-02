<?php

namespace App\Services\TestLetter;

use App\Helpers\CertificateHelper;
use App\Helpers\Helper;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use LaravelEasyRepository\ServiceApi;
use App\Repositories\TestLetter\TestLetterRepository;
use PhpOffice\PhpWord\TemplateProcessor;
use Yajra\DataTables\Facades\DataTables;

class TestLetterServiceImplementBackup extends ServiceApi implements TestLetterService{

    /**
     * set title message api for CRUD
     * @param string $title
     */
     protected $title = "";
     /**
     * uncomment this to override the default message
     * protected $create_message = "";
     * protected $update_message = "";
     * protected $delete_message = "";
     */

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(TestLetterRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    /**
     * @param $data
     * @return mixed
     */
    public function upsert_form($data)
    {
        DB::beginTransaction();
        try {
            $testLetter = $this->mainRepository->find($data['id']);
//            if (!@$data['old_sop_component_installation']) {
//                if (@$testLetter->sop_component_installation) {
//                    if (file_exists(storage_path('app/public/'.@$testLetter->sop_component_installation))) {
//                        unlink(storage_path('app/public/'.@$testLetter->sop_component_installation));
//                    }
//                }
//                // file application letter
//                $fileSopComponentInstallation = $data['sop_component_installation'];
//                $originalNameSopComponentInstallation = $fileSopComponentInstallation->getClientOriginalName();
//                $extensionSopComponentInstallation = $fileSopComponentInstallation->getClientOriginalExtension();
//                $newFileNameSopComponentInstallation = 'SOP_Pemasangan_Komponen_Konversi_' . uniqid() . '.' . $extensionSopComponentInstallation;
//                $filePathSopComponentInstallation = $fileSopComponentInstallation->storeAs('documents', $newFileNameSopComponentInstallation, 'public');
//                $data['sop_component_installation'] = $filePathSopComponentInstallation;
//            } else {
//                $data['sop_component_installation'] = $data['old_sop_component_installation'];
//                unset($data['old_sop_component_installation']);
//            }
//
//            if (!@$data['old_technical_drawing']) {
//                if (@$testLetter->technical_drawing) {
//                    if (file_exists(storage_path('app/public/'.@$testLetter->technical_drawing))) {
//                        unlink(storage_path('app/public/'.@$testLetter->technical_drawing));
//                    }
//                }
//                // file technical_drawing
//                $fileTechnicalDrawing = $data['technical_drawing'];
//                $originalNameTechnicalDrawing = $fileTechnicalDrawing->getClientOriginalName();
//                $extensionTechnicalDrawing = $fileTechnicalDrawing->getClientOriginalExtension();
//                $newFileNameTechnicalDrawing = 'Gambar_Teknik_' . uniqid() . '.' . $extensionTechnicalDrawing;
//                $filePathTechnicalDrawing = $fileTechnicalDrawing->storeAs('documents', $newFileNameTechnicalDrawing, 'public');
//                $data['technical_drawing'] = $filePathTechnicalDrawing;
//            } else {
//                $data['technical_drawing'] = $data['old_technical_drawing'];
//                unset($data['old_technical_drawing']);
//            }
//
//            if (!@$data['old_conversion_workshop_certificate']) {
//                if (@$testLetter->conversion_workshop_certificate) {
//                    if (file_exists(storage_path('app/public/'.@$testLetter->conversion_workshop_certificate))) {
//                        unlink(storage_path('app/public/'.@$testLetter->conversion_workshop_certificate));
//                    }
//                }
//                // file conversion_workshop_certificate
//                $fileConversionWorkshopCertificate = $data['conversion_workshop_certificate'];
//                $originalNameConversionWorkshopCertificate = $fileConversionWorkshopCertificate->getClientOriginalName();
//                $extensionConversionWorkshopCertificate = $fileConversionWorkshopCertificate->getClientOriginalExtension();
//                $newFileNameConversionWorkshopCertificate = 'Sertifikat_Bengkel_Konversi_' . uniqid() . '.' . $extensionConversionWorkshopCertificate;
//                $filePathConversionWorkshopCertificate = $fileConversionWorkshopCertificate->storeAs('documents', $newFileNameConversionWorkshopCertificate, 'public');
//                $data['conversion_workshop_certificate'] = $filePathConversionWorkshopCertificate;
//            } else {
//                $data['conversion_workshop_certificate'] = $data['old_conversion_workshop_certificate'];
//                unset($data['old_conversion_workshop_certificate']);
//            }
//
//            if (!@$data['old_electrical_diagram']) {
//                if (@$testLetter->electrical_diagram) {
//                    if (file_exists(storage_path('app/public/'.@$testLetter->electrical_diagram))) {
//                        unlink(storage_path('app/public/'.@$testLetter->electrical_diagram));
//                    }
//                }
//                // file electrical_diagram
//                $fileElectricalDiagram = $data['electrical_diagram'];
//                $originalNameElectricalDiagram = $fileElectricalDiagram->getClientOriginalName();
//                $extensionElectricalDiagram = $fileElectricalDiagram->getClientOriginalExtension();
//                $newFileNameElectricalDiagram = 'Elektrikal_Diagram_' . uniqid() . '.' . $extensionElectricalDiagram;
//                $filePathElectricalDiagram = $fileElectricalDiagram->storeAs('documents', $newFileNameElectricalDiagram, 'public');
//                $data['electrical_diagram'] = $filePathElectricalDiagram;
//            } else {
//                $data['electrical_diagram'] = $data['old_electrical_diagram'];
//                unset($data['old_electrical_diagram']);
//            }
//
//            if (!@$data['old_photocopy_stnk']) {
//                if (@$testLetter->photocopy_stnk) {
//                    if (file_exists(storage_path('app/public/'.@$testLetter->photocopy_stnk))) {
//                        unlink(storage_path('app/public/'.@$testLetter->photocopy_stnk));
//                    }
//                }
//                // file photocopy_stnk
//                $filePhotoCopySTNK = $data['photocopy_stnk'];
//                $originalNamePhotoCopySTNK = $filePhotoCopySTNK->getClientOriginalName();
//                $extensionPhotoCopySTNK = $filePhotoCopySTNK->getClientOriginalExtension();
//                $newFileNamePhotoCopySTNK = 'Fotokopi_STNK_' . uniqid() . '.' . $extensionPhotoCopySTNK;
//                $filePathPhotoCopySTNK = $filePhotoCopySTNK->storeAs('documents', $newFileNamePhotoCopySTNK, 'public');
//                $data['photocopy_stnk'] = $filePathPhotoCopySTNK;
//            } else {
//                $data['photocopy_stnk'] = $data['old_photocopy_stnk'];
//                unset($data['old_photocopy_stnk']);
//            }
//
//            if (!@$data['old_physical_inspection']) {
//                if (@$testLetter->physical_inspection) {
//                    if (file_exists(storage_path('app/public/'.@$testLetter->physical_inspection))) {
//                        unlink(storage_path('app/public/'.@$testLetter->physical_inspection));
//                    }
//                }
//                // file physical_inspection
//                $filePhysicalInspection = $data['physical_inspection'];
//                $originalNamePhysicalInspection = $filePhysicalInspection->getClientOriginalName();
//                $extensionPhysicalInspection = $filePhysicalInspection->getClientOriginalExtension();
//                $newFileNamePhysicalInspection = 'Fisik_Inspeksi_' . uniqid() . '.' . $extensionPhysicalInspection;
//                $filePathPhysicalInspection = $filePhysicalInspection->storeAs('documents', $newFileNamePhysicalInspection, 'public');
//                $data['physical_inspection'] = $filePathPhysicalInspection;
//            } else {
//                $data['physical_inspection'] = $data['old_physical_inspection'];
//                unset($data['old_physical_inspection']);
//            }
//
//            if (!@$data['old_test_report']) {
//                if (@$testLetter->test_report) {
//                    if (file_exists(storage_path('app/public/'.@$testLetter->test_report))) {
//                        unlink(storage_path('app/public/'.@$testLetter->test_report));
//                    }
//                }
//                // file test_report
//                $fileTestReport = $data['test_report'];
//                $originalNameTestReport = $fileTestReport->getClientOriginalName();
//                $extensionTestReport = $fileTestReport->getClientOriginalExtension();
//                $newFileNameTestReport = 'Laporan_Pengujian_' . uniqid() . '.' . $extensionTestReport;
//                $filePathTestReport = $fileTestReport->storeAs('documents', $newFileNameTestReport, 'public');
//                $data['test_report'] = $filePathTestReport;
//            } else {
//                $data['test_report'] = $data['old_test_report'];
//                unset($data['old_test_report']);
//            }
//
//
            if ($data['form_step'] == 14) {
                $data['is_form_completed'] = 1;
                $attachments = [
                    'sop_component_installation' => @$data['sop_component_installation'],
                    'technical_drawing' => @$data['technical_drawing'],
                    'conversion_workshop_certificate' => @$data['conversion_workshop_certificate'],
                    'electrical_diagram' => @$data['electrical_diagram'],
                    'photocopy_stnk' => @$data['photocopy_stnk'],
                    'physical_inspection' => @$data['physical_inspection'],
                    'test_report' => @$data['test_report'],
                    'conversion_type_test_application_letter' => @$data['conversion_type_test_application_letter'],
                ];

                foreach ($attachments as $key => $value) {
                    $fileName = $key;
                    switch ($fileName) {
                        case 'sop_component_installation':
                            $fileName = "SOP_Pemasangan_Komponen_Konversi_";
                            break;
                        case 'technical_drawing':
                            $fileName = "Gambar_Teknik_";
                            break;
                        case 'conversion_workshop_certificate':
                            $fileName = "Sertifikat_Bengkel_Konversi_";
                            break;
                        case 'electrical_diagram':
                            $fileName = "Elektrikal_Diagram_";
                            break;
                        case 'photocopy_stnk':
                            $fileName = "Fotokopi_STNK_";
                            break;
                        case 'physical_inspection':
                            $fileName = "Fisik_Inspeksi_";
                            break;
                        case 'test_report':
                            $fileName = "Laporan_Pengujian_";
                            break;
                        case 'conversion_type_test_application_letter':
                            $fileName = "Surat_Permohonan_Uji_Tipe_Konversi_";
                            break;
                        default:
                            break;
                    }

                    if (@$data[$key]) {
                        if (@$testLetter->$key) {
                            if (file_exists(storage_path('app/public/'.@$testLetter->$key))) {
                                unlink(storage_path('app/public/'.@$testLetter->$key));
                            }
                        }

                        // file application letter
                        $file = $data[$key];
                        $originalName = $file->getClientOriginalName();
                        $extension = $file->getClientOriginalExtension();
                        $newFileName = $fileName . uniqid() . '.' . $extension;
                        $filePath = $file->storeAs('documents', $newFileName, 'public');
                        $data[$key] = $filePath;
                    }

                    if (@$data['old_'.$key]) {
                        $data[$key] = $data['old_'.$key];
                        unset($data['old_'.$key]);
                    }
                }
            }

            $data['user_id'] = auth()->user()->id;
            $data['is_verified'] = 0;
            $data['status'] = 'Menunggu Verifikasi';

            if ($data['form_step'] == 4) {
                $data['drive_motor'] = [
                    'brand' => $data['brand_drive_motor'],
                    'type' => $data['type_drive_motor'],
                    'location' => $data['location_drive_motor'],
                    'voltage' => $data['voltage_drive_motor'],
                    'ampere' => $data['ampere_drive_motor'],
                    'power' => $data['power_drive_motor'],
                    'power_max' => $data['power_max_drive_motor'],
                    'rotation' => $data['rotation_drive_motor'],
                ];

                unset(
                    $data['brand_drive_motor'],
                    $data['type_drive_motor'],
                    $data['location_drive_motor'],
                    $data['voltage_drive_motor'],
                    $data['ampere_drive_motor'],
                    $data['power_drive_motor'],
                    $data['power_max_drive_motor'],
                    $data['rotation_drive_motor']
                );
            }

            if ($data['form_step'] == 5) {
                $data['fuel_system'] = [
                    'conversion_voltage' => $data['conversion_voltage_fuel_system'],
                    'electrical_voltage' => $data['electrical_voltage_fuel_system'],
                    'battery_capacity' => $data['battery_capacity_fuel_system'],
                ];

                unset(
                    $data['conversion_voltage_fuel_system'],
                    $data['electrical_voltage_fuel_system'],
                    $data['battery_capacity_fuel_system']
                );
            }

            if ($data['form_step'] == 6) {
                $data['vehicle_dimension'] = [
                    'total_length' => $data['total_length_vehicle_dimension'],
                    'total_width' => $data['total_width_vehicle_dimension'],
                    'total_height' => $data['total_height_vehicle_dimension'],
                    'axis_distance' => $data['axis_distance_vehicle_dimension'],
                    'front_over' => $data['front_over_vehicle_dimension'],
                    'rear_over' => $data['rear_over_vehicle_dimension'],
                    'ground_clearance' => $data['ground_clearance_vehicle_dimension'],
                ];

                unset(
                    $data['total_length_vehicle_dimension'],
                    $data['total_width_vehicle_dimension'],
                    $data['total_height_vehicle_dimension'],
                    $data['axis_distance_vehicle_dimension'],
                    $data['front_over_vehicle_dimension'],
                    $data['rear_over_vehicle_dimension'],
                    $data['ground_clearance_vehicle_dimension'],
                );
            }

            if ($data['form_step'] == 7) {
                $data['tire_size'] = [
                    'axis_1' => $data['axis_1_tire_size'],
                    'axis_2' => $data['axis_2_tire_size'],
                ];

                unset(
                    $data['axis_1_tire_size'],
                    $data['axis_2_tire_size'],
                );
            }

            if ($data['form_step'] == 8) {
                $data['vehicle_weight'] = [
                    'axis_1_empty_vehicle_weight' => $data['axis_1_empty_vehicle_weight'],
                    'axis_2_empty_vehicle_weight' => $data['axis_2_empty_vehicle_weight'],
                    'axis_empty_vehicle_weight_total' => $data['axis_1_empty_vehicle_weight'] + $data['axis_2_empty_vehicle_weight'],
                    'axis_1_axis_design_strength' => $data['axis_1_axis_design_strength'],
                    'axis_2_axis_design_strength' => $data['axis_2_axis_design_strength'],
                    'axis_axis_design_strength_total' => $data['axis_1_axis_design_strength'] + $data['axis_2_axis_design_strength'],
                    'axis_1_jbb' => $data['axis_1_jbb'],
                    'axis_2_jbb' => $data['axis_2_jbb'],
                    'axis_jbb_total' => $data['axis_1_jbb'] + $data['axis_2_jbb'],
                ];

                unset(
                    $data['axis_1_empty_vehicle_weight'],
                    $data['axis_2_empty_vehicle_weight'],
                    $data['axis_1_axis_design_strength'],
                    $data['axis_2_axis_design_strength'],
                    $data['axis_1_jbb'],
                    $data['axis_2_jbb'],
                );
            }

            if ($data['form_step'] == 9) {
                $data['power_forwarder'] = [
                    'transmission_type' => $data['transmission_type_power_forwarder'],
                    'transmission_control_system' => $data['transmission_control_system_power_forwarder'],
                    'clutch_type' => $data['clutch_type_power_forwarder'],
                    'gear_1' => $data['gear_1_power_forwarder'] ?? '-',
                    'gear_2' => $data['gear_2_power_forwarder'] ?? '-',
                    'gear_3' => $data['gear_3_power_forwarder'] ?? '-',
                    'gear_4' => $data['gear_4_power_forwarder'] ?? '-',
                    'gear_5' => $data['gear_5_power_forwarder'] ?? '-',
                    'gear_6' => $data['gear_6_power_forwarder'] ?? '-',
                    'gear_7' => $data['gear_7_power_forwarder'] ?? '-',
                    'reverse_gear' => $data['reverse_gear_power_forwarder'] ?? '-',
                    'final_gear' => $data['final_gear_power_forwarder'] ?? '-',
                ];

                unset(
                    $data['transmission_type_power_forwarder'],
                    $data['transmission_control_system_power_forwarder'],
                    $data['clutch_type_power_forwarder'],
                    $data['gear_1_power_forwarder'],
                    $data['gear_2_power_forwarder'],
                    $data['gear_3_power_forwarder'],
                    $data['gear_4_power_forwarder'],
                    $data['gear_5_power_forwarder'],
                    $data['gear_6_power_forwarder'],
                    $data['gear_7_power_forwarder'],
                    $data['reverse_gear_power_forwarder'],
                    $data['final_gear_power_forwarder'],
                );
            }

            if ($data['form_step'] == 10) {
                $data['braking_system'] = [
                    'control' => $data['control_braking_system'],
                    'front_brake_type' => $data['front_brake_type_braking_system'],
                    'rear_brake_type' => $data['rear_brake_type_braking_system'],
                    'main_brake' => $data['main_brake_braking_system'] ?? '-',
                    'type_operation' => $data['type_operation_braking_system'] ?? '-',
                    'work_on_operation' => $data['work_on_operation_braking_system'] ?? '-',
                ];

                unset(
                    $data['control_braking_system'],
                    $data['front_brake_type_braking_system'],
                    $data['rear_brake_type_braking_system'],
                    $data['main_brake_braking_system'],
                    $data['type_operation_braking_system'],
                    $data['work_on_operation_braking_system'],
                );
            }

            if ($data['form_step'] == 11) {
                $data['suspension_system'] = [
                    'front_type' => $data['front_type_suspension_system'],
                    'front_spring_type' => $data['front_spring_type_suspension_system'],
                    'front_shock_absorber_type' => $data['front_shock_absorber_type_suspension_system'],
                    'front_stabilizer_system' => $data['front_stabilizer_system_suspension_system'] ?? '-',
                    'rear_type' => $data['rear_type_suspension_system'],
                    'rear_spring_type' => $data['rear_spring_type_suspension_system'],
                    'rear_shock_absorber_type' => $data['rear_shock_absorber_type_suspension_system'],
                    'rear_stabilizer_system' => $data['rear_stabilizer_system_suspension_system'] ?? '-',
                ];

                unset(
                    $data['front_type_suspension_system'],
                    $data['front_spring_type_suspension_system'],
                    $data['front_shock_absorber_type_suspension_system'],
                    $data['front_stabilizer_system_suspension_system'],
                    $data['rear_type_suspension_system'],
                    $data['rear_spring_type_suspension_system'],
                    $data['rear_shock_absorber_type_suspension_system'],
                    $data['rear_stabilizer_system_suspension_system'],
                );
            }

            if ($data['form_step'] == 12) {
                $data['steering_system'] = [
                    'type' => $data['type_steering_system'] ?? '-',
                    'placement' => $data['placement_steering_system'] ?? '-',
                    'wheel' => $data['wheel_steering_system'] ?? '-',
                    'amount_wheel' => $data['amount_wheel_steering_system'] ?? '-',
                    'setting_wheel' => $data['setting_wheel_steering_system'] ?? '-',
                ];

                unset(
                    $data['type_steering_system'],
                    $data['placement_steering_system'],
                    $data['wheel_steering_system'],
                    $data['amount_wheel_steering_system'],
                    $data['setting_wheel_steering_system'],
                );
            }


            if ($data['form_step'] == 13) {
                $data['other'] = [
                    'body_and_frame_arrangement' => $data['body_and_frame_arrangement_other'] ?? '-',
                    'main_light' => $data['main_light_other'] ?? '-',
                    'main_light_amount' => $data['main_light_amount_other'] ?? '-',
                    'main_light_color' => $data['main_light_color_other'] ?? '-',
                    'main_light_power' => $data['main_light_power_other'] ?? '-',
                    'center_light' => $data['center_light_other'] ?? '-',
                    'center_light_amount' => $data['center_light_amount_other'] ?? '-',
                    'center_light_color' => $data['center_light_color_other'] ?? '-',
                    'center_light_power' => $data['center_light_power_other'] ?? '-',
                    'side_light' => $data['side_light_other'] ?? '-',
                    'side_light_amount' => $data['side_light_amount_other'] ?? '-',
                    'side_light_color' => $data['side_light_color_other'] ?? '-',
                    'side_light_power' => $data['side_light_power_other'] ?? '-',
                    'number_plate_light' => $data['number_plate_light_other'] ?? '-',
                    'number_plate_light_amount' => $data['number_plate_light_amount_other'] ?? '-',
                    'number_plate_light_color' => $data['number_plate_light_color_other'] ?? '-',
                    'number_plate_light_power' => $data['number_plate_light_power_other'] ?? '-',
                    'stop_light' => $data['stop_light_other'] ?? '-',
                    'stop_light_amount' => $data['stop_light_amount_other'] ?? '-',
                    'stop_light_color' => $data['stop_light_color_other'] ?? '-',
                    'stop_light_power' => $data['stop_light_power_other'] ?? '-',
                    'reverse_light' => $data['reverse_light_other'] ?? '-',
                    'reverse_light_amount' => $data['reverse_light_amount_other'] ?? '-',
                    'reverse_light_color' => $data['reverse_light_color_other'] ?? '-',
                    'reverse_light_power' => $data['reverse_light_power_other'] ?? '-',
                    'front_turn_signal_light' => $data['front_turn_signal_light_other'] ?? '-',
                    'front_turn_signal_light_amount' => $data['front_turn_signal_light_amount_other'] ?? '-',
                    'front_turn_signal_light_color' => $data['front_turn_signal_light_color_other'] ?? '-',
                    'front_turn_signal_light_power' => $data['front_turn_signal_light_power_other'] ?? '-',
                    'rear_turn_signal_light' => $data['rear_turn_signal_light_other'] ?? '-',
                    'rear_turn_signal_light_amount' => $data['rear_turn_signal_light_amount_other'] ?? '-',
                    'rear_turn_signal_light_color' => $data['rear_turn_signal_light_color_other'] ?? '-',
                    'rear_turn_signal_light_power' => $data['rear_turn_signal_light_power_other'] ?? '-',
                    'side_turn_signal_light' => $data['side_turn_signal_light_other'] ?? '-',
                    'side_turn_signal_light_amount' => $data['side_turn_signal_light_amount_other'] ?? '-',
                    'side_turn_signal_light_color' => $data['side_turn_signal_light_color_other'] ?? '-',
                    'side_turn_signal_light_power' => $data['side_turn_signal_light_power_other'] ?? '-',
                    'additional_light' => $data['additional_light_other'] ?? '-',
                    'additional_light_amount' => $data['additional_light_amount_other'] ?? '-',
                    'additional_light_color' => $data['additional_light_color_other'] ?? '-',
                    'additional_light_power' => $data['additional_light_power_other'] ?? '-',
                    'reflector_light' => $data['reflector_light_other'] ?? '-',
                    'reflector_light_amount' => $data['reflector_light_amount_other'] ?? '-',
                    'reflector_light_color' => $data['reflector_light_color_other'] ?? '-',
                    'reflector_light_power' => $data['reflector_light_power_other'] ?? '-',
                    'fog_light' => $data['fog_light_other'] ?? '-',
                    'fog_light_amount' => $data['fog_light_amount_other'] ?? '-',
                    'fog_light_color' => $data['fog_light_color_other'] ?? '-',
                    'fog_light_power' => $data['fog_light_power_other'] ?? '-',
                    'wiper' => $data['wiper_other'] ?? '-',
                    'wiper_type' => $data['wiper_type_other'] ?? '-',
                    'wiper_amount' => $data['wiper_amount_other'] ?? '-',
                    'speedometer' => $data['speedometer_other'] ?? '-',
                    'drive_type_speedometer' => $data['drive_type_speedometer_other'] ?? '-',
                    'method_speedometer' => $data['method_speedometer_other'] ?? '-',
                    'horn' => $data['horn_other'] ?? '-',
                    'type_horn' => $data['type_horn_other'] ?? '-',
                    'amount_horn' => $data['amount_horn_other'] ?? '-',
                ];

                unset(
                    $data['body_and_frame_arrangement_other'],
                    $data['main_light_other'],
                    $data['main_light_amount_other'],
                    $data['main_light_color_other'],
                    $data['main_light_power_other'],
                    $data['center_light_other'],
                    $data['center_light_amount_other'],
                    $data['center_light_color_other'],
                    $data['center_light_power_other'],
                    $data['side_light_other'],
                    $data['side_light_amount_other'],
                    $data['side_light_color_other'],
                    $data['side_light_power_other'],
                    $data['number_plate_light_other'],
                    $data['number_plate_light_amount_other'],
                    $data['number_plate_light_color_other'],
                    $data['number_plate_light_power_other'],
                    $data['stop_light_other'],
                    $data['stop_light_amount_other'],
                    $data['stop_light_color_other'],
                    $data['stop_light_power_other'],
                    $data['reverse_light_other'],
                    $data['reverse_light_amount_other'],
                    $data['reverse_light_color_other'],
                    $data['reverse_light_power_other'],
                    $data['front_turn_signal_light_other'],
                    $data['front_turn_signal_light_amount_other'],
                    $data['front_turn_signal_light_color_other'],
                    $data['front_turn_signal_light_power_other'],
                    $data['rear_turn_signal_light_other'],
                    $data['rear_turn_signal_light_amount_other'],
                    $data['rear_turn_signal_light_color_other'],
                    $data['rear_turn_signal_light_power_other'],
                    $data['side_turn_signal_light_other'],
                    $data['side_turn_signal_light_amount_other'],
                    $data['side_turn_signal_light_color_other'],
                    $data['side_turn_signal_light_power_other'],
                    $data['additional_light_other'],
                    $data['additional_light_amount_other'],
                    $data['additional_light_color_other'],
                    $data['additional_light_power_other'],
                    $data['reflector_light_other'],
                    $data['reflector_light_amount_other'],
                    $data['reflector_light_color_other'],
                    $data['reflector_light_power_other'],
                    $data['fog_light_other'],
                    $data['fog_light_amount_other'],
                    $data['fog_light_color_other'],
                    $data['fog_light_power_other'],
                    $data['wiper_other'],
                    $data['wiper_type_other'],
                    $data['wiper_amount_other'],
                    $data['speedometer_other'],
                    $data['drive_type_speedometer_other'],
                    $data['method_speedometer_other'],
                    $data['horn_other'],
                    $data['type_horn_other'],
                    $data['amount_horn_other'],
                );
            }

            if (@$data['id']) {
                $this->mainRepository->update($data['id'], $data);
            }

            if (!@$data['id']) {
                unset($data['id']);
                $data['code'] = Helper::generateTestLetterCode();
                $testLetter = $this->mainRepository->create($data);
            }

            if ($data['form_step'] == 14) {
                $redirect = redirect()->intended(URL::route('test.letter.index'));
            } else {
                $redirect = redirect()->intended(URL::route('test.letter.form', ['id' => Helper::encrypt($testLetter->id)]) . '?form-step=' . $data['form_step']+1);
            }


            DB::commit();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    public function findAllByUserId()
    {
        try {
            $result = $this->mainRepository->findAllByUserId();
            return $this->setStatus(true)
                ->setCode(200)
                ->setResult($result);
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function table()
    {
        return DataTables::of($this->mainRepository->table())
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $menuCertificate = '';

                if ($row->physical_test_bpljskb != null) {
                    $menuCertificate = '
                        <a class="dropdown-item generate" href="'.route('test.letter.certificate', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Buat Surat dan Sertifikat
                                </a>
                    ';
                }

                $html = '<span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-circle-horizontal"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M8 12l0 .01" /><path d="M12 12l0 .01" /><path d="M16 12l0 .01" /></svg></button>
                              <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item" href="'.route('test.letter.verification', ['id' => Helper::encrypt($row->id)]).'" data-id="'.$row->id.'">
                                  Verifikasi <a/>
                                '.$menuCertificate.'
                              </div>
                            </span>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function approve($data)
    {
        DB::beginTransaction();
        try {
            $id = $data['id'];
            unset($data['id']);
            $data['status'] = "Terverifikasi";
            $path = $this->generate_physical_test_cover_letter();
            $data['physical_test_cover_letter']  = $path;

            $this->mainRepository->update($id, $data);
            $redirect = redirect()->intended(URL::route('test.letter.index'));
            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setResult(['redirect' => $redirect->getTargetUrl()])
                ->setMessage("Data berhasil di verifikasi");
        } catch (Exception $e) {
            DB::rollBack();
            return $this->exceptionResponse($e);
        }
    }

    /**
     * @return \LaravelEasyRepository\Traits\ResultService|string
     */
    public function generate_physical_test_cover_letter()
    {
        try {
            $templatePath = storage_path('app/templates/Surat_Pengantar_Uji.docx');
            $templateProcessor = new TemplateProcessor($templatePath);

            $outputPath = storage_path('app/public/surat-pengantar/'.'SPUF-342986737.docx');
            $templateProcessor->saveAs($outputPath);
            return  Str::after($outputPath, 'app/public/');
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }

    public function upload_physical_test_letter($data)
    {
        DB::beginTransaction();
        try {
            $id = $data['id'];
            unset($data['id']);

            $testLetter = $this->mainRepository->find($id);

            // file physical_test_bpljskb
            $file = $data['physical_test_bpljskb'];
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $newFileName = 'Hasil_Uji_Fisk_BPLJSKB_' . uniqid() . '.' . $extension;
            $filePath = $file->storeAs('sertifikat-uji', $newFileName, 'public');
            $data['physical_test_bpljskb'] = $filePath;

            $this->mainRepository->update($id, $data);

            DB::commit();

            return $this->setStatus(true)
                ->setCode(200)
                ->setMessage("File berhasil diupload");
        } catch (Exception $e) {
            return $this->exceptionResponse($e);
        }
    }
}
