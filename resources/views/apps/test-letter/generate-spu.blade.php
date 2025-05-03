@extends('theme.panel')

@section('title', 'Generate Surat Pengantar Uji')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
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

        .img-border {
            border: 1px solid #0054a6 !important;
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
                                <a href="#">Generate Surat Pengantar Uji</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Generate Surat Pengantar Uji</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <button id="btn-send-spu" class="btn btn-outline-primary">Kirim Surat Pengantar Uji</button>
                </div>
            </div>
        </div>
        <form id="form-generate-spu">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="id" name="id" value="{{ @$test_letter->id }}">
                    <div class="row row-cards">
                        <div class="form-label">A. Identitas Bengkel</div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Nama Bengkel Perusahaan</label>
                                <input type="text" class="form-control" placeholder="Nama Bengkel Perusahaan" id="workshop" name="workshop" value="{{ @$test_letter->workshop }}">
                                <small class="form-hint">
                                    Nama bengkel perusahaan.
                                </small>
                            </div>
                        </div>
                        <div class="form-label">B. Kendaraan Konversi</div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Nama Motor Konversi</label>
                                <input type="text" class="form-control" placeholder="Nama Motor Konversi" id="vehicle_name" name="vehicle_name" value="{{ old('vehicle_name') }}">
                                <small class="form-hint">
                                    Nama Motor Konversi.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Merk/Tipe</label>
                                <input type="text" class="form-control" placeholder="Merk/Tipe" id="brand_type" name="brand_type" value="{{ old('brand_type') }}">
                                <small class="form-hint">
                                    Merk/Tipe.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Jenis</label>
                                <select class="form-select" name="type" id="type">
                                    <option value="">Pilih Jenis</option>
                                    <option value="Sepeda Motor">Sepeda Motor</option>
                                    <option value="Selain Sepeda Motor">Selain Sepeda Motor</option>
                                </select>
                                <small class="form-hint">
                                    Jenis.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">VIN/NIK</label>
                                <input type="text" class="form-control" placeholder="VIN/NIK" id="vin_nik" name="vin_nik" value="{{ old('vin_nik') }}">
                                <small class="form-hint">
                                    VIN/NIK.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Kode Motor</label>
                                <input type="text" class="form-control" placeholder="Kode Motor" id="vehicle_code" name="vehicle_code" value="{{ old('vehicle_code') }}">
                                <small class="form-hint">
                                    Kode Motor.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Bahan Bakar</label>
                                <input type="text" class="form-control" placeholder="Bahan Bakar" id="fuel" name="fuel" value="{{ old('fuel') }}">
                                <small class="form-hint">
                                    Bahan Bakar.
                                </small>
                            </div>
                        </div>
                        <div class="form-label">C. Jumlah Biaya Uji</div>
                        <div class="table-responsive">
                            <table id="table-amount" class="table mb-0">
                                <thead>
                                <tr>
                                    <th>JENIS ITEM YANG DIUJI</th>
                                    <th>TARIF/ITEM (Rp)</th>
                                    <th>VOL</th>
                                    <th>TARIF/Rp</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between mt-3">
                <div class="col-12 text-end">
                    <button id="btn-submit" type="submit" class="btn btn-primary text-end">Generate Surat Pengantar Uji</button>
                </div>
            </div>
        </form>
    </div>
    @include('apps.test-letter.send-spu-modal')
@endsection

@section('url')
    <input type="hidden" id="generate-spu-url" value="{{ route('test.letter.generate.spu.submit') }}">
    <input type="hidden" id="send-spu-url" value="{{ route('test.letter.send.spu.submit') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/spu.js'])
@endsection
