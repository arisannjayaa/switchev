@extends('theme.panel')

@section('title', 'Pendaftaran Sertifikasi Konversi')

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
                                <a href="#">Detail {{ auth()->user()->isGuest() ? 'Proses' : '' }}</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Detail</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        @can('isAdmin')
            @php
                $attachments[] = $test_letter->sop_component_installation;
                $attachments[] = $test_letter->technical_drawing;
                $attachments[] = $test_letter->conversion_workshop_certificate;
                $attachments[] = $test_letter->electrical_diagram;
                $attachments[] = $test_letter->photocopy_stnk;
                $attachments[] = $test_letter->physical_inspection;
                $attachments[] = $test_letter->test_report;
            @endphp
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Berkas Penerbitan</div>
                </div>
                <div class="card-body">
                    <input type="hidden" id="id" value="{{ $test_letter->id }}" name="id">
                    <div class="row">
                        @foreach($attachments as $attachment)
                            <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($attachment)]) }}" class="d-flex align-items-center file-pdf-2 mb-3">
                                <img width="24" src="{{ asset('assets/dist/img/pdf_illustration.png') }}">
                                {{ Str::limit(substr($attachment, strlen('documents/')), 60) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endcan

    </div>
@endsection

@section('url')

@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/test_letter.js'])
@endsection
