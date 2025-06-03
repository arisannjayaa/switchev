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
                    <span class="">Untuk melihat detail data, silakan klik <a target="_blank" href="{{ route('test.letter.show', ['id' => \App\Helpers\Helper::encrypt($test_letter->test_letter_id)]) }}" class="alert-link">tautan ini</a>.</span>
                </div>
            </div>
        </div>
        <form id="form-testing">
            <input required id="id" name="id" type="hidden" value="{{ @$test_letter->id }}">
            <input required id="test_letter_id" name="test_letter_id" type="hidden" value="{{ @$test_letter->test_letter_id }}">
            <div class="card">
                <div class="card-body">
                    <div class="row row-cards" style="max-height: 100dvh; overflow: hidden; overflow-y: scroll;">
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
                                    $pengujian = json_decode(@$test_letter->testing);
                                @endphp
                                <tr>
                                    <td width="8%"><input required readonly type="number" name="pengujian[0][no]"
                                                          class="form-control" value="1"></td>
                                    <td><input required type="text" readonly name="pengujian[0][jenis]" class="form-control"
                                               value="REM"></td>
                                    <td><input required type="hidden" name="pengujian[0][a][data_teknis]" class="form-control" value="{{ @$pengujian[0]->a->data_teknis }}"></td>
                                    <td>
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Efisiensi rem depan" type="text" name="pengujian[0][a][hasil_uji][depan]"
                                               class="form-control mb-1" placeholder="Rem Depan (%)" value="{{ @$pengujian[0]->a->hasil_uji->depan }}">
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Efisiensi rem belakang" type="text" name="pengujian[0][a][hasil_uji][belakang]"
                                               class="form-control" placeholder="Rem Belakang (%)" value="{{ @$pengujian[0]->a->hasil_uji->belakang }}">
                                    </td>
                                    <td>
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Efisiensi rem utama minimum" type="text" name="pengujian[0][a][ambang_batas]" class="form-control"
                                               placeholder="Minimum (%)" value="{{ @$pengujian[0]->a->ambang_batas }}">
                                    </td>
                                    <td>
                                        <select required name="pengujian[0][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[0]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input required readonly type="number" name="pengujian[1][no]"
                                                          class="form-control" value="2"></td>
                                    <td><input required type="text" readonly name="pengujian[1][jenis]" class="form-control"
                                               value="LAMPU UTAMA"></td>
                                    <td><input required type="hidden" name="pengujian[1][a][data_teknis]" class="form-control" value="{{ @$pengujian[1]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Kekuatan pancar lampu jauh" type="text" name="pengujian[1][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="Kekuatan pancar lampu jauh" value="{{ @$pengujian[1]->a->hasil_uji }}">
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Pyimpangan arah lampu jauh" type="text" name="pengujian[1][b][hasil_uji]" class="form-control"
                                               placeholder="Penyimpangan arah lampu jauh" value="{{ @$pengujian[1]->b->hasil_uji }}">
                                    </td>
                                    <td>
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Kekuatan min pancar lampu utama" type="text" name="pengujian[1][a][ambang_batas]" class="form-control"
                                               placeholder="Kekuatan pancar lampu jauh" value="{{ @$pengujian[1]->a->ambang_batas }}">
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Penyimpangan ke kanan" type="text" name="pengujian[1][b][penyimpangan_kanan]" class="form-control"
                                               placeholder="Penyimpangan kanan" value="{{ @$pengujian[1]->b->penyimpangan_kanan }}">
                                        <input required data-bs-toggle="tooltip"
                                               data-bs-placement="top" title="Penyimpangan ke kiri" type="text" name="pengujian[1][b][penyimpangan_kiri]" class="form-control"
                                               placeholder="Penyimpangan kiri" value="{{ @$pengujian[1]->b->penyimpangan_kiri }}">
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <input required type="text" name="pengujian[1][a][keterangan]"  class="form-control"--}}
                                    {{--                                               placeholder="Keterangan" value="{{ @$pengujian[1]->a->keterangan }}">--}}
                                    {{--                                        <input required type="text" name="pengujian[1][b][keterangan]"  class="form-control"--}}
                                    {{--                                               placeholder="Keterangan" value="{{ @$pengujian[1]->b->keterangan }}">--}}
                                    {{--                                    </td>--}}
                                    <td>
                                        <select required name="pengujian[1][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[1]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[1]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                        <select required name="pengujian[1][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[1]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[1]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input required readonly type="number" name="pengujian[2][no]"
                                                          class="form-control" value="3"></td>
                                    <td><input required type="text" readonly name="pengujian[2][jenis]" class="form-control"
                                               value="KLAKSON"></td>
                                    <td><input required type="hidden" name="pengujian[2][a][data_teknis]" class="form-control"  value="{{ @$pengujian[1]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input required type="text" name="pengujian[2][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="db" value="{{ @$pengujian[2]->a->hasil_uji }}">
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <input required type="text" name="pengujian[2][a][ambang_batas]" class="form-control"--}}
                                    {{--                                               placeholder="db" value="{{ @$pengujian[2]->a->ambang_batas }}">--}}
                                    {{--                                    </td>--}}
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[2][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[2]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[2]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                        <select required name="pengujian[2][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[2]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[2]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input required readonly type="number" name="pengujian[3][no]"
                                                          class="form-control" value="4"></td>
                                    <td><input required type="text" readonly name="pengujian[3][jenis]" class="form-control"
                                               value="BERAT KOSONG"></td>
                                    <td><input required type="text" name="pengujian[3][a][data_teknis]" class="form-control"  value="{{ @$pengujian[3]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input required type="text" name="pengujian[3][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="" value="{{ @$pengujian[3]->a->hasil_uji }}">
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <input required type="text" name="pengujian[3][a][ambang_batas]" class="form-control"--}}
                                    {{--                                               placeholder="" value="{{ @$pengujian[3]->a->ambang_batas }}">--}}
                                    {{--                                    </td>--}}
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[3][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[3]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[3]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="8%"><input required readonly type="number" name="pengujian[4][no]"
                                                          class="form-control" value="5"></td>
                                    <td><input required type="text" readonly name="pengujian[4][jenis]" class="form-control"
                                               value="SPEEDOMETER"></td>
                                    <td><input required type="text" name="pengujian[4][a][data_teknis]" class="form-control" value="{{ @$pengujian[4]->a->data_teknis }}">
                                    </td>
                                    <td>
                                        <input required type="text" name="pengujian[4][a][hasil_uji]" class="form-control mb-1"
                                               placeholder="" value="{{ @$pengujian[4]->a->hasil_uji }}">
                                    </td>
                                    {{--                                    <td>--}}
                                    {{--                                        <input required type="text" name="pengujian[4][a][ambang_batas]" class="form-control"--}}
                                    {{--                                               placeholder="" value="{{ @$pengujian[4]->a->ambang_batas }}">--}}
                                    {{--                                    </td>--}}
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[4][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[4]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[4]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <!-- Baris utama -->
                                <tr>
                                    <td rowspan="7"><input required readonly type="number" name="pengujian[5][no]"
                                                           class="form-control" value="6"></td>
                                    <td><input required type="text" readonly name="pengujian[5][a][jenis]" class="form-control"
                                               value="a. Indikator saat kendaraan siap dikendarai"></td>
                                    <td>
                                        <select required name="pengujian[5][a][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->a->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->a->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][a][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->a->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->a->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[5][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[5][b][jenis]" class="form-control"
                                               value="b. Indikator visual/akustik saat kendaraan masih dalam kondisi dinyalakan">
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][b][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->b->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->b->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][b][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->b->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->b->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[5][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[5][c][jenis]" class="form-control"
                                               value="c. Pengisian baterai tidak menyebabkan gangguan"></td>
                                    <td>
                                        <select required name="pengujian[5][c][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->c->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->c->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][c][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->c->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->c->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[5][c][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->c->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->c->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[5][d][jenis]" class="form-control"
                                               value="d. Sistem peringatan dua tahap"></td>
                                    <td>
                                        <select required name="pengujian[5][d][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->d->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->d->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][d][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->d->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->d->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[5][d][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->d->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->d->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[5][e][jenis]" class="form-control"
                                               value="e. Tahap untuk mematikan KLLB"></td>
                                    <td>
                                        <select required name="pengujian[5][e][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->e->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->e->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][e][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->e->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->e->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[5][e][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->e->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->e->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[5][f][jenis]" class="form-control"
                                               value="f. Indikator baterai lemah"></td>
                                    <td>
                                        <select required name="pengujian[5][f][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Ada" {{ @$pengujian[5]->f->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->f->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][f][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->f->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->f->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[5][f][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->f->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->f->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[5][g][jenis]" class="form-control"
                                               value="g. Fungsi mundur saat maju"></td>
                                    <td>
                                        <select required name="pengujian[5][g][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[5]->g->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[5]->g->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[5][g][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[5]->g->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[5]->g->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[5][g][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[5]->g->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[5]->g->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>


                                <tr>
                                    <td rowspan="12"><input required readonly type="number" name="pengujian[6][no]"
                                                            class="form-control" value="7"></td>
                                    <td><input required type="text" readonly name="pengujian[6][a][jenis]" class="form-control"
                                               value="a. Sistem Lampu"></td>
                                    <td>
                                        <select required name="pengujian[6][a][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->a->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->a->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][a][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->a->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->a->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][a][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->a->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->a->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][b][jenis]" class="form-control"
                                               value="b. Sistem Alat Kemudi"></td>
                                    <td>
                                        <select required name="pengujian[6][b][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->b->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->b->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][b][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->b->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->b->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][b][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->b->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->b->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][c][jenis]" class="form-control"
                                               value="c. Sistem Suspensi"></td>
                                    <td>
                                        <select required name="pengujian[6][c][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->c->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->c->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][c][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->c->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->c->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][c][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->c->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->c->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][d][jenis]" class="form-control"
                                               value="d. Sistem Kelistrikan"></td>
                                    <td>
                                        <select required name="pengujian[6][d][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->d->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->d->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][d][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->d->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->d->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][d][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->d->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->d->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][e][jenis]" class="form-control"
                                               value="e. Sistem Rem"></td>
                                    <td>
                                        <select required name="pengujian[6][e][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->e->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->e->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][e][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->e->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->e->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][e][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->e->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->e->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][f][jenis]" class="form-control"
                                               value="f. Kelengkapan Kendaraan  Panel Instrument"></td>
                                    <td>
                                        <select required name="pengujian[6][f][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->f->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->f->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][f][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->f->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->f->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][f][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->f->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->f->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][g][jenis]" class="form-control"
                                               value="g. Tempat Duduk"></td>
                                    <td>
                                        <select required name="pengujian[6][g][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->g->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->g->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][g][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->g->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->g->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][g][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->g->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->g->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][h][jenis]" class="form-control"
                                               value="h. Kaca Spion"></td>
                                    <td>
                                        <select required name="pengujian[6][h][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->h->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->h->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][h][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->h->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->h->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][h][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->h->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->h->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][i][jenis]" class="form-control"
                                               value="i. Sistem roda-roda"></td>
                                    <td>
                                        <select required name="pengujian[6][i][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->i->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->i->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][i][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->i->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->i->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][i][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->i->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->i->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][j][jenis]" class="form-control"
                                               value="j. Perlingungan kontak tak langsung"></td>
                                    <td>
                                        <select required name="pengujian[6][j][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->j->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->j->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][j][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->j->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->j->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][j][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->j->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->j->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][k][jenis]" class="form-control"
                                               value="k. Resistance"></td>
                                    <td>
                                        <select required name="pengujian[6][k][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->k->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->k->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][k][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->k->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->k->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][k][keterangan]" id="" class="form-control">
                                            <option value="">Pilih keterangan</option>
                                            <option value="Memenuhi Syarat" {{ @$pengujian[6]->k->keterangan == "Memenuhi Syarat" ? 'selected' : '' }}>Memenuhi Syarat</option>
                                            <option value="Tidak Memenuhi" {{ @$pengujian[6]->k->keterangan == "Tidak Memenuhi" ? 'selected' : '' }}>Tidak Memenuhi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input required type="text" readonly name="pengujian[6][l][jenis]" class="form-control"
                                               value="l. Insulation"></td>
                                    <td>
                                        <select required name="pengujian[6][l][data_teknis]" id="" class="form-control">
                                            <option value="">Pilih data teknis</option>
                                            <option value="Ada" {{ @$pengujian[6]->l->data_teknis == "Ada" ? 'selected' : '' }}>Ada</option>
                                            <option value="Tidak" {{ @$pengujian[6]->l->data_teknis == "Tidak" ? 'selected' : '' }}>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select required name="pengujian[6][l][hasil_uji]" id="" class="form-control">
                                            <option value="">Pilih hasil uji</option>
                                            <option value="Baik dan Berfungsi" {{ @$pengujian[6]->l->hasil_uji == "Baik dan Berfungsi" ? 'selected' : '' }}>Baik dan Berfungsi</option>
                                            <option value="Tidak Tersedia" {{ @$pengujian[6]->l->hasil_uji == "Tidak Tersedia" ? 'selected' : '' }}>Tidak Tersedia</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td>
                                        <select required name="pengujian[6][l][keterangan]" id="" class="form-control">
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
    <input required type="hidden" id="form-testing-url" value="{{ route('testing.update') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/testing.js'])
@endsection
