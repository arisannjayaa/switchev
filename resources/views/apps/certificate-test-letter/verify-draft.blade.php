@extends('theme.panel')

@section('title', 'Permohonan Sertifikasi Konversi')

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
                                <a href="{{ route('certificate.test.letter.index') }}">Daftar Permohonan</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">Verifikasi Draft</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Verifikasi Draft</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        <input type="hidden" id="id" value="{{ \App\Helpers\Helper::encrypt($certificate->id) }}">
        <input type="hidden" id="test_letter_id" value="{{ $certificate->test_letter->id }}">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="step-1">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Dokumen</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @php
                                        $attachments[] = ['file_name' => @$certificate->sk_attachment, 'extension' => pathinfo(@$certificate->sk_attachment, PATHINFO_EXTENSION), 'dir' => 'sk-sut-srut/'];
                                        $attachments[] = ['file_name' => @$certificate->registration_attachment, 'extension' => pathinfo(@$certificate->registration_attachment, PATHINFO_EXTENSION), 'dir' => 'certificate-srut/'];
                                        $attachments[] = ['file_name' => @$certificate->type_test_attachment, 'extension' => pathinfo(@$certificate->type_test_attachment, PATHINFO_EXTENSION), 'dir' => 'certificate-sut/'];
                                @endphp
                                @foreach($attachments as $attachment)
                                    @if($attachment['file_name'] != null)
                                        @if($attachment['extension'] == "docx")
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <div class="file-pdf py-3">
                                                    <a target="_blank" href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($attachment['file_name'])]) }}" class="d-flex flex-column align-items-center justify-content-center">
                                                        <img width="150" src="{{ asset('assets/dist/img/pdf_illustration.png') }}">
                                                        <span class="text-center" style="color: #182433" data-bs-toggle="tooltip" data-bs-placement="top"
                                                              data-bs-title="{{ substr($attachment['file_name'], strlen($attachment['dir'])) }}">{{ Str::limit(substr($attachment['file_name'], strlen($attachment['dir'])), 20) }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-footer">
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('certificate.test.letter.index') }}" class="btn btn-outline-primary">Kembali</a>
                            <button {{ in_array(@$certificate->status, ['SUT Terverifikasi']) ? 'disabled' : '' }} {{ @$certificate->test_letter->step == 'rejected' ? 'disabled' : '' }} id="btn-verification" type="submit" class="btn btn-primary">Verifikasi</button>
                            <button {{ @$certificate->test_letter->is_verified == 1 ? 'disaled' : '' }} {{ @$certificate->test_letter->step == 'rejected' ? 'disabled' : '' }} id="btn-reject" type="submit" class="btn btn-danger">Tolak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('apps.test-letter.reject-modal')
@endsection

@section('url')
    <input type="hidden" id="verify-url" value="{{ route('certificate.test.letter.verification.draft.submit') }}">
    <input type="hidden" id="reject-url" value="{{ route('certificate.test.letter.reject') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/certificate.js'])
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
@endsection
