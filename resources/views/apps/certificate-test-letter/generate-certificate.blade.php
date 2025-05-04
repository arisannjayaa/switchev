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
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
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
                    <a href="{{ route('certificate.test.letter.certificate', ['id' => \App\Helpers\Helper::encrypt($test_letter->id)]) }}" class="btn btn-outline-primary">Edit Data</a>
                </div>
            </div>
        </div>
        <input id="id" type="hidden" value="{{ $test_letter->id }}">
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
                    <span class="alert-heading">Sertifikat Uji Tipe bisa diunduh disini</span>
                </div>
                <button id="btn-download-certificate-sut" class="btn btn-outline-primary">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon mx-0 icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                </button>
            </div>
        </div>
        @if(@$test_letter->workshop_type == 'B')
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
                        <span class="alert-heading">Sertifikat Registrasi bisa diunduh disini</span>
                    </div>
                    <button id="btn-download-certificate-srut" class="btn btn-outline-primary">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon mx-0 icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                    </button>
                </div>
            </div>
        @endif
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
                    <span class="alert-heading">Surat Keterangan bisa diunduh disini</span>
                </div>
                <button id="btn-download-sk" class="btn btn-outline-primary">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon mx-0 icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                </button>
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
                    <span class="alert-heading">Kirim Draft Ke Superadmin</span>
                </div>
                <button id="btn-send-draft" class="btn btn-outline-primary">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send mx-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                </button>
            </div>
        </div>

        <hr>

        @if(@$test_letter->certificate->status == 'Draft' || @$test_letter->certificate == null)
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
                        <span class="alert-heading">Kirim draft dulu untuk di verifikasi, lalu upload sertifikat dan surat keterangan</span>
                    </div>
                </div>
            </div>
        @endif

        @if(@$test_letter->certificate->status == 'Terverifikasi')
            @php
                $extension_sk = pathinfo(@$test_letter->certificate->sk_attachment, PATHINFO_EXTENSION);
                $extension_registration_attachment = pathinfo(@$test_letter->certificate->registration_attachment, PATHINFO_EXTENSION);
                $extension_type_test_attachment = pathinfo(@$test_letter->certificate->type_test_attachment, PATHINFO_EXTENSION);
            @endphp
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Upload File</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input id="certificate_id" type="hidden" class="form-control" name="certificate_id" value="{{ @$test_letter->certificate->id }}">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label required">Surat Keterangan</label>
                                <input id="sk_attachment" type="file" class="form-control" name="sk_attachment">
                                @if(@$test_letter->certificate->sk_attachment && $extension_sk == 'pdf') <input type="hidden" class="form-control" name="old_sk_attachment" value="{{ @$test_letter->certificate->sk_attachment }}"> @endif
                                <small class="form-hint">
                                    @if(@$test_letter->certificate->sk_attachment && $extension_sk == 'pdf') sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->certificate->sk_attachment)]) }}">lihat disini</a> @endif
                                    Upload file dalam bentuk pdf hasil dari surat keterangan
                                </small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label required">Sertifikat SRUT</label>
                                <input id="registration_attachment" type="file" class="form-control" name="registration_attachment">
                                @if(@$test_letter->certificate->registration_attachment && $extension_registration_attachment == 'pdf') <input type="hidden" class="form-control" name="old_registration_attachment" value="{{ @$test_letter->certificate->registration_attachment }}"> @endif
                                <small class="form-hint">
                                    @if(@$test_letter->certificate->registration_attachment && $extension_registration_attachment == 'pdf') sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->certificate->registration_attachment)]) }}">lihat disini</a> @endif
                                    Upload file dalam bentuk pdf hasil dari sertifikat
                                </small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label required">Sertifikat SUT</label>
                                <input id="type_test_attachment" type="file" class="form-control" name="type_test_attachment">
                                @if(@$test_letter->certificate->type_test_attachment && $extension_type_test_attachment == 'pdf') <input type="hidden" class="form-control" name="old_type_test_attachment" value="{{ @$test_letter->certificate->type_test_attachment }}"> @endif
                                <small class="form-hint">
                                    @if(@$test_letter->certificate->type_test_attachment && $extension_type_test_attachment == 'pdf') sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->certificate->type_test_attachment)]) }}">lihat disini</a> @endif
                                    Upload file dalam bentuk pdf hasil dari sertifikat
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button id="btn-upload-archive" class="btn btn-primary text-right" type="button">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="mx-0 icon icon-tabler icons-tabler-outline icon-tabler-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('url')
    <input type="hidden" id="download-certificate-srut-url" value="{{ route('certificate.test.letter.generate.certificate.srut') }}">
    <input type="hidden" id="download-certificate-sut-url" value="{{ route('certificate.test.letter.generate.certificate.sut') }}">
    <input type="hidden" id="download-sk-url" value="{{ route('certificate.test.letter.generate.sk') }}">
    <input type="hidden" id="send-draft-url" value="{{ route('certificate.test.letter.send.draft') }}">
    <input type="hidden" id="upload-archive-url" value="{{ route('certificate.test.letter.upload.archive') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/certificate.js'])
@endsection
