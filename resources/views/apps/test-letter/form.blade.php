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
        <form id="form-test-letter">
            <div class="card card-md">
                <div class="card-body text-center py-4 p-sm-5">
                    <h1 class="mt-5">Form Penerbitan SUT dan SRUT</h1>
                </div>
                <div class="hr-text hr-text-center hr-text-spaceless"></div>
                <div class="card-body">
                    <input type="hidden" id="id" name="id" value="{{ @$test_letter->id }}">
                    <div class="row row-cards">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label required">Tipe Identitas Bengkel</label>
                                <select id="type" class="form-select" name="type">
                                    <option value="">Pilih Tipe Identitas Bengkel</option>
                                    <option value="A" {{ @$test_letter->type == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ @$test_letter->type == 'B' ? 'selected' : '' }}>B</option>
                                </select>
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
            <div class="row align-items-center mt-3">
                <div class="col">
                    <div class="btn-list justify-content-end">
                        <button id="btn-submit" type="submit" class="btn btn-primary">
                            Kirim Pengajuan
                        </button>
                    </div>
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
