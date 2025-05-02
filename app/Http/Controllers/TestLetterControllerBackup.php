<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\FormTestLetterRequest;
use App\Http\Requests\UploadPhysicalTestRequest;
use App\Services\TestLetter\TestLetterService;
use Illuminate\Http\Request;

class TestLetterControllerBackup extends Controller
{
    protected $testLetterService;
    public function __construct(TestLetterService $testLetterService)
    {
        $this->testLetterService = $testLetterService;
    }

    public function index(Request $request)
    {
        $data['test_letters'] = $this->testLetterService->findAllByUserId()->getResult();

        return view('apps.test-letter.index', $data);
    }

    public function form(Request $request, $id = null)
    {
        if (auth()->user()->isGuest() && auth()->user()->isVerified()) {
            $data['test_letter'] = @$this->testLetterService->find(Helper::decrypt($id))->getResult();
            $data['form_step'] = $request->query('form-step');
            return view('apps.test-letter.form', $data);
        }

        return abort(403);
    }

    public function upsert_form(FormTestLetterRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['workshop_type',
            'sop_component_installation',
            'technical_drawing',
            'conversion_workshop_certificate',
            'electrical_diagram',
            'photocopy_stnk',
            'physical_inspection',
            'test_report',
            'id',
            'responsible_person',
            'telephone',
            'address',
            'workshop','form_step',
            'brand',
            'type',
            'type_vehicle',
            'trademark',
            'country_of_origin',
            'variant',
            'allotment',
            'transmission',
            'drive_system',
            'chassis',
            'chassis_place_number',
            'chassis_method_number',
            'pre_conversion_engine',
            'pre_conversion_engine_place_number',
            'pre_conversion_engine_method_number',
            'post_conversion_engine',
            'post_conversion_engine_place_number',
            'post_conversion_engine_method_number',
            'brand_drive_motor',
            'type_drive_motor',
            'location_drive_motor',
            'voltage_drive_motor',
            'ampere_drive_motor',
            'power_drive_motor',
            'power_max_drive_motor',
            'rotation_drive_motor',
            'conversion_voltage_fuel_system','electrical_voltage_fuel_system','battery_capacity_fuel_system',
            'total_length_vehicle_dimension','total_width_vehicle_dimension','total_height_vehicle_dimension','axis_distance_vehicle_dimension',
            'front_over_vehicle_dimension','rear_over_vehicle_dimension','ground_clearance_vehicle_dimension',
            'axis_1_tire_size','axis_2_tire_size',
            'axis_1_empty_vehicle_weight','axis_2_empty_vehicle_weight','axis_1_axis_design_strength','axis_2_axis_design_strength','axis_1_jbb','axis_2_jbb',
            'transmission_type_power_forwarder','transmission_control_system_power_forwarder','clutch_type_power_forwarder',
            'gear_1_power_forwarder','gear_2_power_forwarder','gear_3_power_forwarder','gear_4_power_forwarder','gear_5_power_forwarder',
            'gear_6_power_forwarder','gear_7_power_forwarder','reverse_gear_power_forwarder','final_gear_power_forwarder',
            'control_braking_system','front_brake_type_braking_system','rear_brake_type_braking_system','type_operation_braking_system','work_on_operation_braking_system',
            'front_type_suspension_system','front_spring_type_suspension_system','front_shock_absorber_type_suspension_system','front_stabilizer_system_suspension_system','rear_type_suspension_system','rear_spring_type_suspension_system','rear_shock_absorber_type_suspension_system','rear_stabilizer_system_suspension_system',
            'body_and_frame_arrangement_other','main_light_other','main_light_amount_other','main_light_color_other','main_light_power_other','center_light_other','center_light_amount_other','center_light_color_other','center_light_power_other','side_light_other','side_light_amount_other','side_light_color_other','side_light_power_other','number_plate_light_other','number_plate_light_amount_other','number_plate_light_color_other','number_plate_light_power_other','stop_light_other','stop_light_amount_other','stop_light_color_other','stop_light_power_other','reverse_light_other','reverse_light_amount_other','reverse_light_color_other','reverse_light_power_other','front_turn_signal_light_other','front_turn_signal_light_amount_other','front_turn_signal_light_color_other','front_turn_signal_light_power_other','rear_turn_signal_light_other','rear_turn_signal_light_amount_other','rear_turn_signal_light_color_other','rear_turn_signal_light_power_other','side_turn_signal_light_other','side_turn_signal_light_amount_other','side_turn_signal_light_color_other','side_turn_signal_light_power_other','additional_light_other','additional_light_amount_other','additional_light_color_other','additional_light_power_other','reflector_light_other','reflector_light_amount_other','reflector_light_color_other','reflector_light_power_other','fog_light_other','fog_light_amount_other','fog_light_color_other','fog_light_power_other','wiper_other','wiper_type_other','wiper_amount_other','speedometer_other','drive_type_speedometer_other','method_speedometer_other','horn_other','type_horn_other','amount_horn_other','type_steering_system','placement_steering_system','wheel_steering_system','amount_wheel_steering_system','setting_wheel_steering_system',
            'conversion_type_test_application_letter'
        ]);
        return $this->testLetterService->upsert_form($data)->toJson();
    }

    public function table()
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        return $this->testLetterService->table();
    }

    public function show(Request $request)
    {
        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($request->id))->getResult();
        return view('apps.test-letter.detail', $data);
    }

    public function verification($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($id))->getResult();

        return view('apps.test-letter.verification', $data);
    }

    public function approve(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }


        $data = $request->only(['id','is_verified']);

        return $this->testLetterService->approve($data)->toJson();
    }

    public function upload_physical_test_letter(UploadPhysicalTestRequest $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data = $request->only(['physical_test_bpljskb', 'id']);
        return $this->testLetterService->upload_physical_test_letter($data)->toJson();
    }

    public function show_physical_test_letter(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            return abort(404);
        }

        return $this->testLetterService->findOrFail($request->id)->toJson();
    }

    public function certificate($id)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403);
        }

        $data['test_letter'] = $this->testLetterService->find(Helper::decrypt($id))->getResult();

        return view('apps.test-letter.certificate', $data);
    }
}
