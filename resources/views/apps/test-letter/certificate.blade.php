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
        <form id="form-certificate">
            <input id="id" name="id" type="hidden" value="{{ @$test_letter->certificate->id }}">
            <input id="test_letter_id" name="test_letter_id" type="hidden" value="{{ @$test_letter->id }}">
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
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Tempat Uji</label>
                                <input type="text" class="form-control" placeholder="Tempat Uji" id="place_test_bpljskb"
                                       name="place_test_bpljskb"
                                       value="{{ @$test_letter->certificate->place_test_bpljskb }}">
                                <small class="form-hint">
                                    Tempat uji, contoh : Bekasi.
                                </small>
                            </div>
                        </div>
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
                                    <th>DATA TEKNIS</th>
                                    <th>HASIL UJI</th>
                                    <th>AMBANG BATAS</th>
                                    <th>KETERANGAN</th>
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
                                        <input type="text" name="pengujian[0][a][keterangan]"  class="form-control"
                                               placeholder="Keterangan" value="{{ @$pengujian[0]->a->keterangan }}">
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
                                    <td>
                                        <input type="text" name="pengujian[1][a][keterangan]"  class="form-control"
                                               placeholder="Keterangan" value="{{ @$pengujian[1]->a->keterangan }}">
                                        <input type="text" name="pengujian[1][b][keterangan]"  class="form-control"
                                               placeholder="Keterangan" value="{{ @$pengujian[1]->b->keterangan }}">
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
                                    <td>
                                        <input type="text" name="pengujian[2][a][ambang_batas]" class="form-control"
                                               placeholder="db" value="{{ @$pengujian[2]->a->ambang_batas }}">
                                    </td>
                                    <td>
                                        <input type="text" name="pengujian[2][a][keterangan]"  class="form-control"
                                               placeholder="Keterangan" value="{{ @$pengujian[2]->a->keterangan }}">
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
                                    <td>
                                        <input type="text" name="pengujian[3][a][ambang_batas]" class="form-control"
                                               placeholder="" value="{{ @$pengujian[3]->a->ambang_batas }}">
                                    </td>
                                    <td>
                                        <input type="text" name="pengujian[3][a][keterangan]"  class="form-control"
                                               placeholder="Keterangan" value="{{ @$pengujian[3]->a->keterangan }}">
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
                                    <td>
                                        <input type="text" name="pengujian[4][a][ambang_batas]" class="form-control"
                                               placeholder="" value="{{ @$pengujian[4]->a->ambang_batas }}">
                                    </td>
                                    <td>
                                        <input type="text" name="pengujian[4][a][keterangan]"  class="form-control"
                                               placeholder="Keterangan" value="{{ @$pengujian[4]->a->keterangan }}">
                                    </td>
                                </tr>
                                <!-- Baris utama -->
                                <tr>
                                    <td rowspan="7"><input readonly type="number" name="pengujian[5][no]"
                                                           class="form-control" value="6"></td>
                                    <td><input type="text" readonly name="pengujian[5][a][jenis]" class="form-control"
                                               value="a. Indikator saat kendaraan siap dikendarai"></td>
                                    <td><input type="text" name="pengujian[5][a][data_teknis]" value="{{ @$pengujian[5]->a->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[5][a][hasil_uji]" value="{{ @$pengujian[5]->a->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[5][a][keterangan]" value="{{ @$pengujian[5]->a->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][b][jenis]" class="form-control"
                                               value="b. Indikator visual/akustik saat kendaraan masih dalam kondisi dinyalakan">
                                    </td>
                                    <td><input type="text" name="pengujian[5][b][data_teknis]" value="{{ @$pengujian[5]->b->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[5][b][hasil_uji]" value="{{ @$pengujian[5]->b->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[5][b][keterangan]" value="{{ @$pengujian[5]->b->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][c][jenis]" class="form-control"
                                               value="c. Pengisian baterai tidak menyebabkan gangguan"></td>
                                    <td><input type="text" name="pengujian[5][c][data_teknis]" value="{{ @$pengujian[5]->c->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[5][c][hasil_uji]" value="{{ @$pengujian[5]->c->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[5][c][keterangan]" value="{{ @$pengujian[5]->c->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][d][jenis]" class="form-control"
                                               value="d. Sistem peringatan dua tahap"></td>
                                    <td><input type="text" name="pengujian[5][d][data_teknis]" value="{{ @$pengujian[5]->d->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[5][d][hasil_uji]" value="{{ @$pengujian[5]->d->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[5][d][keterangan]" value="{{ @$pengujian[5]->d->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][e][jenis]" class="form-control"
                                               value="e. Tahap untuk mematikan KLLB"></td>
                                    <td><input type="text" name="pengujian[5][e][data_teknis]" value="{{ @$pengujian[5]->e->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[5][e][hasil_uji]" value="{{ @$pengujian[5]->e->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[5][e][keterangan]" value="{{ @$pengujian[5]->e->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][f][jenis]" class="form-control"
                                               value="f. Indikator baterai lemah"></td>
                                    <td><input type="text" name="pengujian[5][f][data_teknis]" value="{{ @$pengujian[5]->f->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[5][f][hasil_uji]" value="{{ @$pengujian[5]->f->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[5][f][keterangan]" value="{{ @$pengujian[5]->f->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[5][g][jenis]" class="form-control"
                                               value="g. Fungsi mundur saat maju"></td>
                                    <td><input type="text" name="pengujian[5][g][data_teknis]" value="{{ @$pengujian[5]->g->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[5][g][hasil_uji]" value="{{ @$pengujian[5]->g->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[5][g][keterangan]" value="{{ @$pengujian[5]->g->keterangan }}"  class="form-control"></td>
                                </tr>

                                <tr>
                                    <td rowspan="12"><input readonly type="number" name="pengujian[6][no]"
                                                            class="form-control" value="7"></td>
                                    <td><input type="text" readonly name="pengujian[6][a][jenis]" class="form-control"
                                               value="a. Sistem Lampu"></td>
                                    <td><input type="text" name="pengujian[6][a][data_teknis]" value="{{ @$pengujian[6]->a->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][a][hasil_uji]" value="{{ @$pengujian[6]->a->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][a][keterangan]" value="{{ @$pengujian[6]->a->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][b][jenis]" class="form-control"
                                               value="b. Sistem Alat Kemudi"></td>
                                    <td><input type="text" name="pengujian[6][b][data_teknis]" value="{{ @$pengujian[6]->b->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][b][hasil_uji]" value="{{ @$pengujian[6]->b->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][b][keterangan]" value="{{ @$pengujian[6]->b->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][c][jenis]" class="form-control"
                                               value="c. Sistem Suspensi"></td>
                                    <td><input type="text" name="pengujian[6][c][data_teknis]" value="{{ @$pengujian[6]->c->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][c][hasil_uji]" value="{{ @$pengujian[6]->c->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][c][keterangan]" value="{{ @$pengujian[6]->c->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][d][jenis]" class="form-control"
                                               value="d. Sistem Kelistrikan"></td>
                                    <td><input type="text" name="pengujian[6][d][data_teknis]"  value="{{ @$pengujian[6]->d->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][d][hasil_uji]" value="{{ @$pengujian[6]->d->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][d][keterangan]" value="{{ @$pengujian[6]->d->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][e][jenis]" class="form-control"
                                               value="e. Sistem Rem"></td>
                                    <td><input type="text" name="pengujian[6][e][data_teknis]" value="{{ @$pengujian[6]->e->data_teknis }}"  class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][e][hasil_uji]" value="{{ @$pengujian[6]->e->hasil_uji }}"  class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][e][keterangan]" value="{{ @$pengujian[6]->e->keterangan }}"   class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][f][jenis]" class="form-control"
                                               value="f. Kelengkapan Kendaraan  Panel Instrument"></td>
                                    <td><input type="text" name="pengujian[6][f][data_teknis]" value="{{ @$pengujian[6]->f->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][f][hasil_uji]" value="{{ @$pengujian[6]->f->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][f][keterangan]" value="{{ @$pengujian[6]->f->keterangan }}"  class="form-control"
                                        ></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][g][jenis]" class="form-control"
                                               value="g. Tempat Duduk"></td>
                                    <td><input type="text" name="pengujian[6][g][data_teknis]" value="{{ @$pengujian[6]->g->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][g][hasil_uji]" value="{{ @$pengujian[6]->g->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][g][keterangan]" value="{{ @$pengujian[6]->g->keterangan }}"  class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][h][jenis]" class="form-control"
                                               value="h. Kaca Spion"></td>
                                    <td><input type="text" name="pengujian[6][h][data_teknis]" value="{{ @$pengujian[6]->h->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][h][hasil_uji]" value="{{ @$pengujian[6]->h->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][h][keterangan]" value="{{ @$pengujian[6]->h->keterangan }}"  class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][i][jenis]" class="form-control"
                                               value="i. Sistem roda-roda"></td>
                                    <td><input type="text" name="pengujian[6][i][data_teknis]" value="{{ @$pengujian[6]->i->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][i][hasil_uji]" value="{{ @$pengujian[6]->i->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][i][keterangan]" value="{{ @$pengujian[6]->i->keterangan }}"  class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][j][jenis]" class="form-control"
                                               value="j. Perlingungan kontak tak langsung"></td>
                                    <td><input type="text" name="pengujian[6][j][data_teknis]" class="form-control"
                                               value="{{ @$pengujian[6]->j->data_teknis }}"></td>
                                    <td><input type="text" name="pengujian[6][j][hasil_uji]" class="form-control"
                                               value="{{ @$pengujian[6]->j->hasil_uji }}"></td>
                                    <td></td>
                                    <td><input type="text" name="pengujian[6][j][keterangan]" value="{{ @$pengujian[6]->j->keterangan }}" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][k][jenis]" class="form-control"
                                               value="k. Resistance"></td>
                                    <td><input type="text" name="pengujian[6][k][data_teknis]" value="{{ @$pengujian[6]->k->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][k][hasil_uji]" value="{{ @$pengujian[6]->k->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][k][ambang_batas]" value="{{ @$pengujian[6]->k->ambang_batas }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][k][keterangan]" value="{{ @$pengujian[6]->k->keterangan }}" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td><input type="text" readonly name="pengujian[6][l][jenis]" class="form-control"
                                               value="l. Insulation"></td>
                                    <td><input type="text" name="pengujian[6][l][data_teknis]"value="{{ @$pengujian[6]->l->data_teknis }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][l][hasil_uji]" value="{{ @$pengujian[6]->l->hasil_uji }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][l][ambang_batas]" value="{{ @$pengujian[6]->l->ambang_batas }}" class="form-control"
                                        ></td>
                                    <td><input type="text" name="pengujian[6][l][keterangan]" value="{{ @$pengujian[6]->l->keterangan }}" class="form-control"></td>
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
