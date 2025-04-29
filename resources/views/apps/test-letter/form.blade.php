@extends('theme.panel')

@section('title', 'Form Pendaftaran Bengkel Konversi')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="page-header mb-3">
            <div class="row align-items-center">
                <div class="col">
                    <div class="mb-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('test.letter.index') }}">Daftar Penerbitan</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">Form Penerbitan</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Form Pendaftaran</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        <form id="form-test-letter">
            @php
                switch ($form_step) {
                    case 1:
                        $form_step_name = 'General';
                        break;
                    case 2:
                        $form_step_name = 'Identitas Kendaraan';
                        break;
                    case 3:
                        $form_step_name = 'Nomor dan Tempat Penomoran Landasan/Chassis, Engine, dan Motor Kendaraan Uji';
                        break;
                    case 4:
                        $form_step_name = 'Motor Penggerak';
                        break;
                    case 5:
                        $form_step_name = 'Sistem Bahan Bakar';
                        break;
                    case 6:
                        $form_step_name = 'Dimensi Kendaraan';
                        break;
                    case 7:
                        $form_step_name = 'Ukuran Ban dan Lingkar Roda';
                        break;
                    default:
                        $form_step_name = 'form-step-1';
                }
            @endphp
            <div class="card card-md">
                <div class="card-body text-center py-4 p-sm-5">
                    <h1 class="mt-5">Form Penerbitan SUT dan SRUT</h1>
                    <span class="text-muted">{{ ucwords($form_step_name) }}</span>
                </div>
                <div class="hr-text hr-text-center hr-text-spaceless"></div>
                <div class="card-body">
                    <input type="hidden" id="id" name="id" value="{{ @$test_letter->id }}">
                    <input type="hidden" id="form-step" name="form_step" value="{{ $form_step }}">
                    @if($form_step == 1)
                        <div class="row row-cards">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tipe Identitas Bengkel</label>
                                    <select id="workshop_type" class="form-select" name="workshop_type">
                                        <option value="">Pilih Tipe Identitas Bengkel</option>
                                        <option value="A" {{ @$test_letter->workshop_type == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ @$test_letter->workshop_type == 'B' ? 'selected' : '' }}>B</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Penanggung Jawab</label>
                                    <input type="text" class="form-control" placeholder="Nama penanggung jawab" name="responsible_person" value="{{ @$test_letter->responsible_person }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Bengkel</label>
                                    <input type="text" class="form-control" placeholder="Nama bengkel" name="workshop" value="{{ @$test_letter->workshop }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">No Telepon</label>
                                    <input type="text" class="form-control" placeholder="No Telepon" name="telephone" value="{{ @$test_letter->telephone }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Alamat</label>
                                    <textarea class="form-control" name="address"  id="address" rows="6" placeholder="Alamat..">{{ @$test_letter->address }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($form_step == 2)
                        <div class="row row-cards">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Merek</label>
                                    <input type="text" class="form-control" placeholder="Merek" name="brand" value="{{ @$test_letter->brand }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tipe Kendaraan</label>
                                    <input type="text" class="form-control" placeholder="Tipe Kendaraan" name="type" value="{{ @$test_letter->type }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Jenis Kendaraan</label>
                                    <input type="text" class="form-control" placeholder="Jenis Kendaraan" name="type_vehicle" value="{{ @$test_letter->type_vehicle }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Merek Dagang</label>
                                    <input type="text" class="form-control" placeholder="Merek Dagang" name="trademark" value="{{ @$test_letter->trademark }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Negara Asal</label>
                                    <input type="text" class="form-control" placeholder="Negara Asal" name="country_of_origin" value="{{ @$test_letter->country_of_origin }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Varian</label>
                                    <input type="text" class="form-control" placeholder="Varian" name="variant" value="{{ @$test_letter->variant }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Peruntukan</label>
                                    <input type="text" class="form-control" placeholder="Peruntukan" name="allotment" value="{{ @$test_letter->allotment }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tranmisi</label>
                                    <input type="text" class="form-control" placeholder="Tranmisi" name="transmission" value="{{ @$test_letter->transmission }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Sistem Penggerak</label>
                                    <input type="text" class="form-control" placeholder="Sistem Penggerak" name="drive_system" value="{{ @$test_letter->drive_system }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($form_step == 3)
                        <div class="row row-cards">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Nomor Rangka</label>
                                    <input type="text" class="form-control" placeholder="Nomor Rangka" name="chassis" value="{{ @$test_letter->chassis }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tempat Penomoran Rangka</label>
                                    <input type="text" class="form-control" placeholder="Tempat Penomoran Rangka" name="chassis_place_number" value="{{ @$test_letter->chassis_place_number }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Cara Penomoraan Rangka</label>
                                    <input type="text" class="form-control" placeholder="Cara Penomoraan" name="chassis_method_number" value="{{ @$test_letter->chassis_method_number }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">No Mesin (Pra-Konversi)</label>
                                    <input type="text" class="form-control" placeholder="No Mesin (Pra-Konversi)" name="pre_conversion_engine" value="{{ @$test_letter->pre_conversion_engine }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tempat Penomoran Mesin Pra Konversi</label>
                                    <input type="text" class="form-control" placeholder="Tempat Penomoran Mesin Pra Konversi" name="pre_conversion_engine_place_number" value="{{ @$test_letter->pre_conversion_engine_place_number }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Cara Penomoraan Mesin Pra Konversi</label>
                                    <input type="text" class="form-control" placeholder="Cara Penomoraan Mesin Pra Konversi" name="pre_conversion_engine_method_number" value="{{ @$test_letter->pre_conversion_engine_method_number }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">No Mesin (Pasca-Konversi)</label>
                                    <input type="text" class="form-control" placeholder="No Mesin (Pasca-Konversi)" name="post_conversion_engine" value="{{ @$test_letter->post_conversion_engine }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tempat Penomoran Mesin Pasca Konversi</label>
                                    <input type="text" class="form-control" placeholder="Tempat Penomoran Mesin Pasca Konversi" name="post_conversion_engine_place_number" value="{{ @$test_letter->post_conversion_engine_place_number }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Cara Penomoraan Mesin Pasca Konversi</label>
                                    <input type="text" class="form-control" placeholder="Cara Penomoraan Mesin Pasca Konversi" name="post_conversion_engine_method_number" value="{{ @$test_letter->post_conversion_engine_method_number }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($form_step == 4)
                        @php
                            $drive_motor = json_decode(@$test_letter->drive_motor);
                        @endphp
                        <div class="row row-cards">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Merek</label>
                                    <input type="text" class="form-control" placeholder="Merek" name="brand_drive_motor" value="{{ @$drive_motor->brand }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Jenis Motor Penggerak</label>
                                    <input type="text" class="form-control" placeholder="Jenis Motor Penggerak" name="type_drive_motor" value="{{ @$drive_motor->type }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Letak Motor Penggerak</label>
                                    <input type="text" class="form-control" placeholder="Letak Motor Penggerak" name="location_drive_motor" value="{{ @$drive_motor->location }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tegangan Kerja Motor (Volt)</label>
                                    <input type="text" class="form-control" placeholder="Tegangan Kerja Motor (Volt)" name="voltage_drive_motor" value="{{ @$drive_motor->voltage }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Arus Maksimum Motor (Ampere)</label>
                                    <input type="text" class="form-control" placeholder="Arus Maksimum Motor (Ampere)" name="ampere_drive_motor" value="{{ @$drive_motor->ampere }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Daya Motor (kW)</label>
                                    <input type="text" class="form-control" placeholder="Daya Motor (kW)" name="power_drive_motor" value="{{ @$drive_motor->power }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Daya Motor Maksimum (kW)</label>
                                    <input type="text" class="form-control" placeholder="Daya Motor Maksimum (kW)" name="power_max_drive_motor" value="{{ @$drive_motor->power_max }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Putaran Maksimum Motor (rpm)</label>
                                    <input type="text" class="form-control" placeholder="Putaran Maksimum Motor (rpm)" name="rotation_drive_motor" value="{{ @$drive_motor->rotation }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($form_step == 5)
                        @php
                            $fuel_system = json_decode(@$test_letter->fuel_system);
                        @endphp
                        <div class="row row-cards">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tegangan Kerja Sistem Konversi (Volt)</label>
                                    <input type="text" class="form-control" placeholder="Tegangan Kerja Sistem Konversi (Volt)" name="conversion_voltage_fuel_system" value="{{ @$fuel_system->conversion_voltage }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tegangan Kerja Kelistrikan Kendaraan (Volt)</label>
                                    <input type="text" class="form-control" placeholder="Tegangan Kerja Kelistrikan Kendaraan (Volt)" name="electrical_voltage_fuel_system" value="{{ @$fuel_system->electrical_voltage }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Kapasitas Baterai (kWh)</label>
                                    <input type="text" class="form-control" placeholder="Kapasitas Baterai (kWh)" name="battery_capacity_fuel_system" value="{{ @$fuel_system->battery_capacity }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($form_step == 6)
                        @php
                            $vehicle_dimension = json_decode(@$test_letter->vehicle_dimension);
                        @endphp
                        <div class="row row-cards">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Panjang Total (mm)</label>
                                    <input type="text" class="form-control" placeholder="Panjang Total (mm)" name="total_length_vehicle_dimension" value="{{ @$vehicle_dimension->total_length }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lebar Total (mm)</label>
                                    <input type="text" class="form-control" placeholder="Lebar Total (mm)" name="total_width_vehicle_dimension" value="{{ @$vehicle_dimension->total_width }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Tinggi Total (mm)</label>
                                    <input type="text" class="form-control" placeholder="Tinggi Total (mm)" name="total_height_vehicle_dimension" value="{{ @$vehicle_dimension->total_height }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Jarak Sumbu I-II (mm)</label>
                                    <input type="text" class="form-control" placeholder="Jarak Sumbu I-II (mm)" name="axis_distance_vehicle_dimension" value="{{ @$vehicle_dimension->axis_distance }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Julur Depan (Front Over Hang) (mm)</label>
                                    <input type="text" class="form-control" placeholder="Julur Depan (Front Over Hang) (mm)" name="front_over_vehicle_dimension" value="{{ @$vehicle_dimension->front_over }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Julur Belakang (Front Over Hang) (mm)</label>
                                    <input type="text" class="form-control" placeholder="Julur Belakang (Front Over Hang) (mm)" name="rear_over_vehicle_dimension" value="{{ @$vehicle_dimension->rear_over }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Julur Bebas (Ground Clearance) (mm) </label>
                                    <input type="text" class="form-control" placeholder="Julur Bebas (Ground Clearance) (mm) " name="ground_clearance_vehicle_dimension" value="{{ @$vehicle_dimension->ground_clearance }}">
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($form_step == 9)
                        <div class="row row-cards">
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran SOP Pemasangan Konversi</label>
                                    <input id="sop_component_installation" type="file" class="form-control" name="sop_component_installation">
                                    @if(@$test_letter->sop_component_installation) <input type="hidden" class="form-control" name="old_sop_component_installation" value="{{ @$test_letter->sop_component_installation }}"> @endif
                                    <small class="form-hint">
                                        @if(@$test_letter->sop_component_installation) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->sop_component_installation)]) }}">lihat disini</a>
                                        <br> @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Gambar Teknik</label>
                                    <input id="technical_drawing" type="file" class="form-control" name="technical_drawing">
                                    @if(@$test_letter->technical_drawing) <input type="hidden" class="form-control" name="old_technical_drawing" value="{{ @$test_letter->technical_drawing }}"> @endif
                                    <small class="form-hint">
                                        @if(@$test_letter->technical_drawing) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->technical_drawing)]) }}">lihat disini</a>
                                        <br> @endif
                                        Foto, sepeda motor yang di konversi.
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Sertifikat Bengkel Konversi</label>
                                    <input id="conversion_workshop_certificate" type="file" class="form-control" name="conversion_workshop_certificate">
                                    @if(@$test_letter->conversion_workshop_certificate) <input type="hidden" class="form-control" name="old_conversion_workshop_certificate" value="{{ @$test_letter->conversion_workshop_certificate }}"> @endif
                                    <small class="form-hint">
                                        @if(@$test_letter->conversion_workshop_certificate) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->conversion_workshop_certificate)]) }}">lihat disini</a>
                                        <br> @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Diagram Kelistrikan</label>
                                    <input id="electrical_diagram" type="file" class="form-control" name="electrical_diagram">
                                    @if(@$test_letter->electrical_diagram) <input type="hidden" class="form-control" name="old_electrical_diagram" value="{{ @$test_letter->electrical_diagram }}"> @endif
                                    <small class="form-hint">
                                        @if(@$test_letter->electrical_diagram) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->electrical_diagram)]) }}">lihat disini</a>
                                        <br> @endif
                                        Diagram kelistrikan dan diagram instalasi sistem penggerak motor listrik.
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Fotokopi STNK</label>
                                    <input id="photocopy_stnk" type="file" class="form-control" name="photocopy_stnk">
                                    @if(@$test_letter->photocopy_stnk) <input type="hidden" class="form-control" name="old_photocopy_stnk" value="{{ @$test_letter->photocopy_stnk }}"> @endif
                                    <small class="form-hint">
                                        @if(@$test_letter->photocopy_stnk) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->photocopy_stnk)]) }}">lihat disini</a>
                                        <br> @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Cek Fisik Kendaraan Bermotor</label>
                                    <input id="physical_inspection" type="file" class="form-control" name="physical_inspection">
                                    @if(@$test_letter->physical_inspection) <input type="hidden" class="form-control" name="old_physical_inspection" value="{{ @$test_letter->physical_inspection }}"> @endif
                                    <small class="form-hint">
                                        @if(@$test_letter->physical_inspection) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->physical_inspection)]) }}">lihat disini</a>
                                        <br> @endif
                                        Lampiran hasil pemeriksaan cek fisik Kendaraan Bermotor oleh Kepolisian Negara Republik Indonesia.
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Laporan Pengujian</label>
                                    <input id="test_report" type="file" class="form-control" name="test_report">
                                    @if(@$test_letter->test_report) <input type="hidden" class="form-control" name="old_test_report" value="{{ @$test_letter->test_report }}"> @endif
                                    <small class="form-hint">
                                        @if(@$test_letter->test_report) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->test_report)]) }}">lihat disini</a>
                                        <br> @endif
                                        Lampiran laporan pengujian atau sertifikat baterai standar nasional Indonesia atau standar internasional.
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row align-items-center justify-content-between mt-3">
                <div class="col-6 text-start">
                    @if($form_step > 1)
                        <a class="btn btn-primary" href="{{ route('test.letter.form', ['id' => \App\Helpers\Helper::encrypt(@$test_letter->id)]) . '?form-step=' . ($form_step == 1 ? 1 : $form_step - 1) }}">Sebelumnya</a>
                    @endif
                </div>
                <div class="col-6 text-end">
                    <button id="btn-submit" type="submit" class="btn btn-primary text-end">Selanjutnya</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('url')
    <input type="hidden" id="upsert-form-url" value="{{ route('test.letter.upsert.form') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/test_letter.js'])
@endsection
