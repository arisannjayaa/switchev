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
            <div class="card card-md">
                <div class="card-body text-center py-4 p-sm-5">
                    <h1 class="mt-5">Form Penerbitan SUT dan SRUT</h1>
                </div>
                <div class="hr-text hr-text-center hr-text-spaceless"></div>
                <div class="card-body">
                    <input type="hidden" id="id" name="id" value="{{ @$test_letter->id }}">
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
                                <input type="text" class="form-control" placeholder="Nama penanggung jawab" id="responsible_person" name="responsible_person" value="{{ @$test_letter->responsible_person }}">
                                <small class="form-hint">
                                    Nama penanggung jawab bengkel perusahaan.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Nama Bengkel</label>
                                <input type="text" class="form-control" placeholder="Nama bengkel" id="workshop" name="workshop" value="{{ @$test_letter->workshop }}">
                                <small class="form-hint">
                                    Nama bengkel perusahaan.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">No Telepon</label>
                                <input type="text" class="form-control" placeholder="No Telepon" id="telephone" name="telephone" value="{{ @$test_letter->telephone }}">
                                <small class="form-hint">
                                    No. telepon perusahaan
                                </small>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Alamat</label>
                                <textarea class="form-control" name="address"  id="address" rows="6" placeholder="Alamat..">{{ @$test_letter->address }}</textarea>
                                <small class="form-hint">
                                    Alamat bengkel perusahaan.
                                </small>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="mb-3">
                                <label class="form-label required">Surat Permohonan Uji Tipe Konversi</label>
                                <input id="conversion_type_test_application_letter" type="file" class="form-control" name="conversion_type_test_application_letter">
                                @if(@$test_letter->conversion_type_test_application_letter) <input type="hidden" class="form-control" name="old_conversion_type_test_application_letter" value="{{ @$test_letter->conversion_type_test_application_letter }}"> @endif
                                <small class="form-hint">
                                    @if(@$test_letter->conversion_type_test_application_letter) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->conversion_type_test_application_letter)]) }}">lihat disini</a>
                                    <br> @endif
                                    Format dokumen tersedia dapat di unduh <a target="_blank" href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt('/templates/FORMAT_SURAT_PERMOHONAN_SRUT.docx')]) }}">Disini</a>
                                </small>
                            </div>
                        </div>
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
                </div>
            </div>
            <div class="row align-items-center justify-content-between mt-3">
                <div class="col-12 text-end">
                    <button id="btn-submit" type="submit" class="btn btn-primary text-end">Ajukan Penerbitan</button>
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
