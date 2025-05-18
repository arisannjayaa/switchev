@extends('theme.panel')

@section('title', 'Sertifikasi')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }

        .file-pdf:hover {
            border-radius: 7px;
            cursor: pointer;
            background-color: rgba(24, 36, 51, 0.09) !important;
        }

        .step-item.active:before {
            background-color: #fff !important;
            border: 2px solid #0054a6 !important;
            color: #0054a6 !important;
        }

        .alert-info {
            background-color: #fff !important;
            border: 1px solid #0054a6 !important;
            color: #0054a6 !important;
        }

        .alert-success {
            background-color: #fff !important;
            border: 1px solid #2fb344 !important;
            color: #2fb344 !important;
        }

        .ql-container {
            height: 200px !important;
            border-radius: 0 0 8px 8px !important;
        }

        .ql-toolbar.ql-snow {
            border-radius: 8px 8px 0 0 !important;
        }

        .file-pdf-2 {
            text-decoration: none;
            color: #000;
            padding: 10px 10px 12px 12px;
            border: 1px solid #0054a6 !important;
            border-radius: 8px;
            cursor: pointer;
        }

        .file-pdf-2:hover {
            background-color: rgba(24, 36, 51, 0.09) !important;
        }
    </style>
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet"/>
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
                                <a href="#">Sertifikasi</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Sertifikasi</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        <div class="alert alert-important alert-info" role="alert">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex">
                    <div class="alert-icon">
                        <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                            <path d="M12 8v4"></path>
                            <path d="M12 16h.01"></path>
                        </svg>
                    </div>
                    <span class="">Untuk melihat detail data, silakan klik <a target="_blank" href="{{ route('test.letter.show', ['id' => \App\Helpers\Helper::encrypt($test_letter->id)]) }}" class="alert-link">tautan ini</a>.</span>
                </div>
            </div>
        </div>
        <form id="form-certificate">
            <input id="id" name="id" type="hidden" value="{{ @$test_letter->certificate->id }}">
            <input id="test_letter_id" name="test_letter_id" type="hidden" value="{{ @$test_letter->id }}">
            <input id="workshop_type" name="workshop_type" type="hidden" value="{{ @$test_letter->workshop_type }}">
            <div class="card">
                <div class="card-body">
                    <div class="row row-cards" style="max-height: 100dvh; overflow: hidden; overflow-y: scroll;">
                        <div class="form-label">A. Identitas Bengkel :</div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Nama Bengkel</label>
                                <input type="text" class="form-control" placeholder="Nama Bengkel" id="workshop"
                                       name="workshop" value="{{ @$test_letter->workshop }}">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Penanggung Jawab</label>
                                <input type="text" class="form-control" placeholder="Penanggung Jawab"
                                       id="responsible_person" name="responsible_person"
                                       value="{{ @$test_letter->responsible_person }}">
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Alamat</label>
                                <textarea name="address" class="form-control" id="address"
                                          rows="10">{{ @$test_letter->address }}</textarea>
                            </div>
                        </div>
                        <div class="form-label">B. Identitas Kendaraan :</div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Merek</label>
                                <input type="text" class="form-control" placeholder="Merek" id="brand" name="brand"
                                       value="{{ @$test_letter->certificate->brand }}">
                                <small class="form-hint">
                                    Merek kendaraan, contoh: Kawasaki
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Tipe</label>
                                <input type="text" class="form-control" placeholder="Tipe" id="type" name="type"
                                       value="{{ @$test_letter->certificate->type }}">
                                <small class="form-hint">
                                    Tipe kendaraan, contoh : LX 150F Varian 1
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Jenis</label>
                                <select class="form-control" id="vehicle_type" name="vehicle_type">
                                    <option >Pilih Jenis</option>
                                    <option
                                        value="Sepeda Motor" {{ @$test_letter->certificate->vehicle_type == 'Sepeda Motor' ? 'selected' : '' }}>
                                        Sepeda Motor
                                    </option>
                                    <option
                                        value="Selain Sepeda Motor" {{ @$test_letter->certificate->vehicle_type == 'Selain Sepeda Motor' ? 'selected' : '' }}>
                                        Selain Sepeda Motor
                                    </option>
                                </select>
                                <small class="form-hint">
                                    Jenis kendaraan, contoh : Sepeda Motor
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Peruntukan</label>
                                <input type="text" class="form-control" placeholder="Peruntukan" id="purpose_vehicle"
                                       name="purpose_vehicle" value="{{ @$test_letter->certificate->purpose_vehicle }}">
                                <small class="form-hint">
                                    Peruntukan, contoh : Angkutan orang
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Nomor Rangka</label>
                                <input type="text" class="form-control" placeholder="Nomor Rangka" id="chassis"
                                       name="chassis" value="{{ @$test_letter->certificate->chassis }}">
                                <small class="form-hint">
                                    No Rangka pada kendaraan, contoh : MH4LXXXXXXXXXXXXX
                                </small>
                            </div>
                        </div>
                        @if(@$test_letter->workshop_type == "A" && $test_letter->step == "create_certificate_srut")
                            <input type="hidden" name="test_letter_step" id="test_letter_step" value="{{ $test_letter->step }}">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Nomor Mesin</label>
                                    <input type="text" class="form-control" placeholder="Nomor Mesin" id="machine"
                                           name="machine" value="{{ @$test_letter->certificate->machine }}">
                                    <small class="form-hint">
                                        No Mesin pada kendaraan, contoh : MH4LXXXXXXXXXXXXX
                                    </small>
                                </div>
                            </div>
                        @endif
                        @if(@$test_letter->workshop_type == "B")
                            <input type="hidden" name="test_letter_step" id="test_letter_step" value="{{ $test_letter->step }}">
                            <div class="col-md-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Nomor Mesin</label>
                                    <input type="text" class="form-control" placeholder="Nomor Mesin" id="machine"
                                           name="machine" value="{{ @$test_letter->certificate->machine }}">
                                    <small class="form-hint">
                                        No Mesin pada kendaraan, contoh : MH4LXXXXXXXXXXXXX
                                    </small>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Nomor Motor Listrik</label>
                                <input type="text" class="form-control" placeholder="Nomor Motor Listrik"
                                       id="electric_motor_number" name="electric_motor_number"
                                       value="{{ @$test_letter->certificate->electric_motor_number }}">
                                <small class="form-hint">
                                    Nomor motor listrik
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Tahun Pembuatan Perangkitan Konversi</label>
                                <input type="text" class="form-control"
                                       placeholder="Tahun Pembuatan Perangkitan Konversi" id="year_build"
                                       name="year_build" value="{{ @$test_letter->certificate->year_build }}">
                                <small class="form-hint">
                                    Tahun pembuatan, contoh : 2020
                                </small>
                            </div>
                        </div>
                        <div class="form-label">C. Spesifikasi Teknik Kendaraan :</div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Jarak Sumbu I-II</label>
                                <input type="text" class="form-control convert-mm" placeholder="Jarak Sumbu I-II"
                                       id="axis_1_2" name="axis_1_2" value="{{ @$test_letter->certificate->axis_1_2 }}">
                                <small class="form-hint">
                                    Jarak sumbu I-II, contoh : 1290 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Jarak Sumbu II-III</label>
                                <input type="text" class="form-control convert-mm" placeholder="Jarak Sumbu II-III"
                                       id="axis_2_3" name="axis_2_3" value="{{ @$test_letter->certificate->axis_2_3 }}">
                                <small class="form-hint">
                                    Jarak sumbu II-III, contoh : 190 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Jarak Sumbu III-IV</label>
                                <input type="text" class="form-control convert-mm" placeholder="Jarak Sumbu III-IV"
                                       id="axis_3_4" name="axis_3_4" value="{{ @$test_letter->certificate->axis_3_4 }}">
                                <small class="form-hint">
                                    Jarak sumbu III-IV, contoh : 1490 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Lebar Total</label>
                                <input type="text" class="form-control convert-mm" placeholder="Lebar Total"
                                       id="width_total" name="width_total"
                                       value="{{ @$test_letter->certificate->width_total }}">
                                <small class="form-hint">
                                    Lebar total dimensi kendaraan, contoh : 980 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Panjang Total</label>
                                <input type="text" class="form-control convert-mm" placeholder="Panjang Total"
                                       id="length_total" name="length_total"
                                       value="{{ @$test_letter->certificate->length_total }}">
                                <small class="form-hint">
                                    Panjang total dimensi kendaraan, contoh : 1300 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Tinggi Total</label>
                                <input type="text" class="form-control convert-mm" placeholder="Tinggi Total"
                                       id="height_total" name="height_total"
                                       value="{{ @$test_letter->certificate->height_total }}">
                                <small class="form-hint">
                                    Tinggi total dimensi kendaraan, contoh : 1200 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Julur Depan</label>
                                <input type="text" class="form-control convert-mm" placeholder="Julur Depan"
                                       id="julur_front" name="julur_front"
                                       value="{{ @$test_letter->certificate->julur_front }}">
                                <small class="form-hint">
                                    Julur depan, contoh : 210 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Julur Belakang</label>
                                <input type="text" class="form-control convert-mm" placeholder="Julur Belakang"
                                       id="julur_rear" name="julur_rear"
                                       value="{{ @$test_letter->certificate->julur_rear }}">
                                <small class="form-hint">
                                    Julur belakang, contoh : 910 mm.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Daya Motor Penggerak Maksimum</label>
                                <input type="text" class="form-control convert-kw"
                                       placeholder="Daya Motor Penggerak Maksimum" id="power_max" name="power_max"
                                       value="{{ @$test_letter->certificate->power_max }}">
                                <small class="form-hint">
                                    Daya motor maksimum (kW) motor penggerak, contoh : 30kW.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Kapasitas Baterai</label>
                                <input type="text" class="form-control convert-kwh" placeholder="Kapasitas Baterai"
                                       id="battery_max" name="battery_max"
                                       value="{{ @$test_letter->certificate->battery_max }}">
                                <small class="form-hint">
                                    Kapasitas baterai, contoh : 2.98 kWh.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Ukuran Ban Sumbu I</label>
                                <input type="text" class="form-control" placeholder="Ukuran Ban Sumbu I"
                                       id="tire_axis_1" name="tire_axis_1"
                                       value="{{ @$test_letter->certificate->tire_axis_1 }}">
                                <small class="form-hint">
                                    Sumbu I, contoh : 185 mm , 2,75 – 45P.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Ukuran Ban Sumbu II</label>
                                <input type="text" class="form-control" placeholder="Ukuran Ban Sumbu II"
                                       id="tire_axis_2" name="tire_axis_2"
                                       value="{{ @$test_letter->certificate->tire_axis_2 }}">
                                <small class="form-hint">
                                    Sumbu II, contoh : 185 mm , 2,75 – 45P.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Ukuran Ban Sumbu III</label>
                                <input type="text" class="form-control" placeholder="Ukuran Ban Sumbu III"
                                       id="tire_axis_3" name="tire_axis_3"
                                       value="{{ @$test_letter->certificate->tire_axis_3 }}">
                                <small class="form-hint">
                                    Sumbu III, contoh : 185 mm , 2,75 – 45P.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label">Ukuran Ban Sumbu IV</label>
                                <input type="text" class="form-control" placeholder="Ukuran Ban Sumbu IV"
                                       id="tire_axis_4" name="tire_axis_4"
                                       value="{{ @$test_letter->certificate->tire_axis_4 }}">
                                <small class="form-hint">
                                    Sumbu III, contoh : 185 mm , 2,75 – 45P.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">JBB/JBKB (GVW/GCW)</label>
                                <input type="text" class="form-control convert-kg" placeholder="JBB/JBKB (GVW/GCW)"
                                       id="jbb" name="jbb" value="{{ @$test_letter->certificate->jbb }}">
                                <small class="form-hint">
                                    JBB/GVM sumbu I, contoh : 84 Kg.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Berat Kosong</label>
                                <input type="text" class="form-control convert-kg" placeholder="Berat Kosong"
                                       id="empty_weight" name="empty_weight"
                                       value="{{ @$test_letter->certificate->empty_weight }}">
                                <small class="form-hint">
                                    Berat kosong, contoh : 44 Kg.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">JBI / JBKI (GPVW/GPCW)</label>
                                <input type="text" class="form-control convert-kg" placeholder="JBI / JBKI (GPVW/GPCW)"
                                       id="jbi" name="jbi" value="{{ @$test_letter->certificate->jbi }}">
                                <small class="form-hint">
                                    JBI, contoh : 44 Kg.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Daya Angkut</label>
                                <input type="text" class="form-control" placeholder="Daya Angkut" id="carry_capacity"
                                       name="carry_capacity" value="{{ @$test_letter->certificate->carry_capacity }}">
                                <small class="form-hint">
                                    Daya angkut, contoh : - kg atau (or) 2 (DUA) ORANG TERMASUK PENGEMUDI.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Daya Angkut Barang</label>
                                <input type="text" class="form-control convert-kg" placeholder="Daya Angkut Barang"
                                       id="goods_capacity" name="goods_capacity"
                                       value="{{ @$test_letter->certificate->goods_capacity }}">
                                <small class="form-hint">
                                    Daya angkut, contoh : 44 Kg.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Kelas Jalan Terendah</label>
                                <input type="text" class="form-control" placeholder="Kelas Jalan Terendah"
                                       id="road_class" name="road_class"
                                       value="{{ @$test_letter->certificate->road_class }}">
                                <small class="form-hint">
                                    Kelas jalan, contoh : Kelas III.
                                </small>
                            </div>
                        </div>
{{--                        <div class="col-md-6 col-12">--}}
{{--                            <div class="mb-3">--}}
{{--                                <label class="form-label required">Tempat Uji</label>--}}
{{--                                <input type="text" class="form-control" placeholder="Tempat Uji" id="place_test_bpljskb"--}}
{{--                                       name="place_test_bpljskb"--}}
{{--                                       value="{{ @$test_letter->certificate->place_test_bpljskb }}">--}}
{{--                                <small class="form-hint">--}}
{{--                                    Tempat uji, contoh : Bekasi.--}}
{{--                                </small>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Tanggal Uji</label>
                                <input type="date" class="form-control" placeholder="Tanggal Uji" id="date_bpljskb"
                                       name="date_bpljskb" value="{{ @$test_letter->certificate->date_bpljskb }}">
                                <small class="form-hint">
                                    Tanggal uji, contoh : 30/11/2022.
                                </small>
                            </div>
                        </div>
                        <div class="form-label">D. Hasil Uji :</div>
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                <tr>
                                    <th>NO</th>
                                    <th width="400px">JENIS PENGUJIAN</th>
                                    <th width="160px">DATA TEKNIS</th>
                                    <th width="160px">HASIL UJI</th>
                                    <th>AMBANG BATAS</th>
                                    <th width="200px">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $pengujian = json_decode(@$test_letter->certificate->testing);
                                @endphp
                                <tr>
                                    <td width="8%"><input readonly type="number" name="pengujian[0][no]"
                                                          class="form-control" value="1"></td>
                                    <td><input type="text" readonly name="pengujian[0][jenis]" class="form-control"
                                               value="REM"></td>
                                    <td><input type="hidden" name="pengujian[0][a][data_teknis]" class="form-control" value="{{ @$pengujian[0]->a->data_teknis }}"></td>
                                    <td>
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Efisiensi rem depan" type="text" name="pengujian[0][a][hasil_uji][depan]"
                                               class="form-control mb-1" placeholder="Rem Depan (%)" value="{{ @$pengujian[0]->a->hasil_uji->depan }}">
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Efisiensi rem belakang" type="text" name="pengujian[0][a][hasil_uji][belakang]"
                                               class="form-control" placeholder="Rem Belakang (%)" value="{{ @$pengujian[0]->a->hasil_uji->belakang }}">
                                    </td>
                                    <td>
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Efisiensi rem utama minimum" type="text" name="pengujian[0][a][ambang_batas]" class="form-control"
                                               placeholder="Minimum (%)" value="{{ @$pengujian[0]->a->ambang_batas }}">
                                    </td>
                                    <td>
                                        <select name="pengujian[0][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[0]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input readonly type="number" name="pengujian[1][no]"
                                                          class="form-control" value="2"></td>
                                    <td><input type="text" readonly name="pengujian[1][jenis]" class="form-control"
                                               value="LAMPU UTAMA"></td>
                                    <td><input type="hidden" name="pengujian[1][a][data_teknis]" class="form-control" value="{{ @$pengujian[1]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Kekuatan pancar lampu jauh" type="text" name="pengujian[1][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="Kekuatan pancar lampu jauh" value="{{ @$pengujian[1]->a->hasil_uji }}">
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Pyimpangan arah lampu jauh" type="text" name="pengujian[1][b][hasil_uji]" class="form-control"
                                               placeholder="Penyimpangan arah lampu jauh" value="{{ @$pengujian[1]->b->hasil_uji }}">
                                    </td>
                                    <td>
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Kekuatan min pancar lampu utama" type="text" name="pengujian[1][a][ambang_batas]" class="form-control"
                                               placeholder="Kekuatan pancar lampu jauh" value="{{ @$pengujian[1]->a->ambang_batas }}">
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Penyimpangan ke kanan" type="text" name="pengujian[1][b][penyimpangan_kanan]" class="form-control"
                                               placeholder="Penyimpangan kanan" value="{{ @$pengujian[1]->b->penyimpangan_kanan }}">
                                        <input data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Penyimpangan ke kiri" type="text" name="pengujian[1][b][penyimpangan_kiri]" class="form-control"
                                               placeholder="Penyimpangan kiri" value="{{ @$pengujian[1]->b->penyimpangan_kiri }}">
                                    </td>
{{--                                    <td>--}}
{{--                                        <input type="text" name="pengujian[1][a][keterangan]"  class="form-control"--}}
{{--                                               placeholder="Keterangan" value="{{ @$pengujian[1]->a->keterangan }}">--}}
{{--                                        <input type="text" name="pengujian[1][b][keterangan]"  class="form-control"--}}
{{--                                               placeholder="Keterangan" value="{{ @$pengujian[1]->b->keterangan }}">--}}
{{--                                    </td>--}}
                                    <td>
                                        <select name="pengujian[1][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[1]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[1]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                        <select name="pengujian[1][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[1]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[1]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input readonly type="number" name="pengujian[2][no]"
                                                          class="form-control" value="3"></td>
                                    <td><input type="text" readonly name="pengujian[2][jenis]" class="form-control"
                                               value="KLAKSON"></td>
                                    <td><input type="hidden" name="pengujian[2][a][data_teknis]" class="form-control"  value="{{ @$pengujian[1]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input type="text" name="pengujian[2][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="db" value="{{ @$pengujian[2]->a->hasil_uji }}">
                                    </td>
{{--                                    <td>--}}
{{--                                        <input type="text" name="pengujian[2][a][ambang_batas]" class="form-control"--}}
{{--                                               placeholder="db" value="{{ @$pengujian[2]->a->ambang_batas }}">--}}
{{--                                    </td>--}}
                                    <td></td>
                                    <td>
                                        <select name="pengujian[2][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[2]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[2]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                        <select name="pengujian[2][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[2]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[2]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input readonly type="number" name="pengujian[3][no]"
                                                          class="form-control" value="4"></td>
                                    <td><input type="text" readonly name="pengujian[3][jenis]" class="form-control"
                                               value="BERAT KOSONG"></td>
                                    <td><input type="text" name="pengujian[3][a][data_teknis]" class="form-control"  value="{{ @$pengujian[3]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input type="text" name="pengujian[3][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="" value="{{ @$pengujian[3]->a->hasil_uji }}">
                                    </td>
{{--                                    <td>--}}
{{--                                        <input type="text" name="pengujian[3][a][ambang_batas]" class="form-control"--}}
{{--                                               placeholder="" value="{{ @$pengujian[3]->a->ambang_batas }}">--}}
{{--                                    </td>--}}
                                    <td></td>
                                    <td>
                                        <select name="pengujian[3][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[3]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[3]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input readonly type="number" name="pengujian[4][no]"
                                                          class="form-control" value="5"></td>
                                    <td><input type="text" readonly name="pengujian[4][jenis]" class="form-control"
                                               value="SPEEDOMETER"></td>
                                    <td><input type="text" name="pengujian[4][a][data_teknis]" class="form-control" value="{{ @$pengujian[4]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input type="text" name="pengujian[4][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="" value="{{ @$pengujian[4]->a->hasil_uji }}">
                                    </td>
{{--                                    <td>--}}
{{--                                        <input type="text" name="pengujian[4][a][ambang_batas]" class="form-control"--}}
{{--                                               placeholder="" value="{{ @$pengujian[4]->a->ambang_batas }}">--}}
{{--                                    </td>--}}
                                    <td></td>
                                    <td>
                                        <select name="pengujian[4][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[4]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[4]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <!-- Baris utama -->
                                <tr>
                                    <td rowspan="7"><input readonly type="number" name="pengujian[5][no]"
                                                           class="form-control" value="6"></td>
                                    <td><input type="text" readonly name="pengujian[5][a][jenis]" class="form-control"
                                               value="a. Indikator saat kendaraan siap dikendarai"></td>
                                    <td>
                                        <select name="pengujian[5][a][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->a->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->a->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[5][a][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->a->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->a->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[5][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][b][jenis]" class="form-control"
                                               value="b. Indikator visual/akustik saat kendaraan masih dalam kondisi dinyalakan">
                                    </td>
                                    <td>
                                        <select name="pengujian[5][b][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->b->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->b->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[5][b][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->b->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->b->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[5][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][c][jenis]" class="form-control"
                                               value="c. Pengisian baterai tidak menyebabkan gangguan"></td>
                                    <td>
                                        <select name="pengujian[5][c][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->c->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->c->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[5][c][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->c->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->c->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[5][c][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->c->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->c->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][d][jenis]" class="form-control"
                                               value="d. Sistem peringatan dua tahap"></td>
                                    <td>
                                        <select name="pengujian[5][d][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->d->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->d->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[5][d][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->d->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->d->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[5][d][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->d->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->d->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][e][jenis]" class="form-control"
                                               value="e. Tahap untuk mematikan KLLB"></td>
                                    <td>
                                        <select name="pengujian[5][e][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->e->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->e->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[5][e][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->e->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->e->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[5][e][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->e->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->e->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][f][jenis]" class="form-control"
                                               value="f. Indikator baterai lemah"></td>
                                    <td>
                                        <select name="pengujian[5][f][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Ada" {{ @$pengujian[5]->f->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->f->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[5][f][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->f->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->f->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[5][f][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->f->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->f->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][g][jenis]" class="form-control"
                                               value="g. Fungsi mundur saat maju"></td>
                                    <td>
                                        <select name="pengujian[5][g][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->g->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->g->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[5][g][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->g->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->g->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[5][g][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->g->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->g->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>


                                <tr>
                                    <td rowspan="12"><input readonly type="number" name="pengujian[6][no]"
                                                            class="form-control" value="7"></td>
                                    <td><input type="text" readonly name="pengujian[6][a][jenis]" class="form-control"
                                               value="a. Sistem Lampu"></td>
                                    <td>
                                        <select name="pengujian[6][a][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->a->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->a->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][a][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->a->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->a->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][b][jenis]" class="form-control"
                                               value="b. Sistem Alat Kemudi"></td>
                                    <td>
                                        <select name="pengujian[6][b][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->b->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->b->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][b][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->b->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->b->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][c][jenis]" class="form-control"
                                               value="c. Sistem Suspensi"></td>
                                    <td>
                                        <select name="pengujian[6][c][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->c->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->c->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][c][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->c->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->c->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][c][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->c->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->c->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][d][jenis]" class="form-control"
                                               value="d. Sistem Kelistrikan"></td>
                                    <td>
                                        <select name="pengujian[6][d][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->d->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->d->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][d][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->d->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->d->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][d][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->d->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->d->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][e][jenis]" class="form-control"
                                               value="e. Sistem Rem"></td>
                                    <td>
                                        <select name="pengujian[6][e][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->e->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->e->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][e][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->e->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->e->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][e][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->e->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->e->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][f][jenis]" class="form-control"
                                               value="f. Kelengkapan Kendaraan  Panel Instrument"></td>
                                    <td>
                                        <select name="pengujian[6][f][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->f->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->f->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][f][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->f->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->f->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][f][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->f->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->f->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][g][jenis]" class="form-control"
                                               value="g. Tempat Duduk"></td>
                                    <td>
                                        <select name="pengujian[6][g][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->g->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->g->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][g][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->g->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->g->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][g][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->g->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->g->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][h][jenis]" class="form-control"
                                               value="h. Kaca Spion"></td>
                                    <td>
                                        <select name="pengujian[6][h][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->h->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->h->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][h][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->h->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->h->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][h][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->h->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->h->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][i][jenis]" class="form-control"
                                               value="i. Sistem roda-roda"></td>
                                    <td>
                                        <select name="pengujian[6][i][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->i->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->i->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][i][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->i->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->i->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][i][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->i->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->i->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][j][jenis]" class="form-control"
                                               value="j. Perlingungan kontak tak langsung"></td>
                                    <td>
                                        <select name="pengujian[6][j][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->j->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->j->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][j][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->j->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->j->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][j][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->j->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->j->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][k][jenis]" class="form-control"
                                               value="k. Resistance"></td>
                                    <td>
                                        <select name="pengujian[6][k][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->k->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->k->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][k][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->k->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->k->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][k][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->k->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->k->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][l][jenis]" class="form-control"
                                               value="l. Insulation"></td>
                                    <td>
                                        <select name="pengujian[6][l][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->l->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->l->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="pengujian[6][l][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->l->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->l->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select name="pengujian[6][l][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->l->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->l->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between mt-3">
                <div class="col-12 text-end">
                    <button id="btn-submit" type="submit" class="btn btn-primary text-end">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('url')
    <input type="hidden" id="certificate-form-url" value="{{ route('certificate.test.letter.certificate.submit') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/certificate.js'])
@endsection
