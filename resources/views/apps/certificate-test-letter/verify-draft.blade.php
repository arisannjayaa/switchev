@extends('theme.panel')

@section('title', 'Permohonan Sertifikasi Konversi')

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
                                    $attachments[] = $certificate->sk_attachment;
                                    $attachments[] = $certificate->type_test_attachment;
                                    $attachments[] = $certificate->registration_attachment;
                                    $attachments[] = $certificate->certificate_attachment;
                                @endphp
                                @foreach($attachments as $attachment)
                                    @if($attachment != null)
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="file-pdf py-3">
                                                <a target="_blank" href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($attachment)]) }}" class="d-flex flex-column align-items-center justify-content-center">
                                                    <img width="150" src="{{ asset('assets/dist/img/pdf_illustration.png') }}">
                                                    <span class="text-center" style="color: #182433" data-bs-toggle="tooltip" data-bs-placement="top"
                                                          data-bs-title="{{ substr($attachment, strlen('certificate/')) }}">{{ Str::limit(substr($attachment, strlen('certificate/')), 20) }}</span>
                                                </a>
                                            </div>
                                        </div>
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
                            <button id="btn-verification" type="submit" class="btn btn-primary">Verifikasi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('url')
    <input type="hidden" id="verify-url" value="{{ route('certificate.test.letter.verification.draft.submit') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/certificate.js'])
@endsection
