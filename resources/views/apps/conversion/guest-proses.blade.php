@extends('theme.panel')

@section('title', 'Proses Sertifikasi Konversi')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
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

        .alert-danger {
            background-color: #fff !important;
            border: 1px solid #dc3545 !important;
            color: #dc3545 !important;
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
                                <a href="{{ route('conversion.index') }}">Daftar Permohonan</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">Proses Sertifikasi Verifikasi Berkas</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Proses Sertifikasi Verifikasi Berkas</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-12">
                @if($conversion->status == 'rejected')
                    <div class="alert alert-important alert-danger" role="alert">
                        <div class="d-flex">
                            <div>
                                <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                            </div>
                            <div>
                                <h4 class="alert-title">{{ \App\Helpers\Helper::check_status_conversion(@$conversion->status) }}</h4>
                                <span class="text-secondary"> {!! @$conversion->message !!}<span class="">Silahkan perbaiki data pada link berikut ini.</span> <a href="{{ route('conversion.form', ['step' => 1]) }}">Perbaiki data</a></span>
                            </div>
                        </div>
                    </div>
                @endif
                @if($conversion->step != 0)
                    <div class="d-flex justify-content-center align-items-center text-center flex-column">
                        <div class="bg-primary-lt w-100 p-7 rounded-3">
                            @if($conversion->step >= 1 && $conversion->step <= 4)
                                <img width="300" src="{{ asset('assets/dist/img/undraw_in-progress_cdfz.svg') }}" alt="">
                            @endif
                            @if($conversion->step == 5)
                                <img width="200" src="{{ asset('assets/dist/img/undraw_completing_gsf8.svg') }}" alt="">
                            @endif
                        </div>
                        <h1 class="mt-4">{{ \App\Helpers\Helper::check_status_conversion($conversion->status) }}</h1>
                        <p class="text-secondary">{!! $conversion->message !!}</p>
                        @if(@$conversion->certificate->status == 'Selesai')
                            <div class="row w-100 gap-2">
                                <div class="col-12">
                                    <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($conversion->certificate->sft_attachment)]) }}" class="btn btn-outline-primary w-100 text-left">Sertifikat</a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($conversion->certificate->sk_attachment)]) }}" class="btn btn-outline-primary w-100">Surat Keterangan</a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="steps steps-counter steps-vertical">
                            <li class="step-item {{ $conversion->step == 0 ? 'active' : '' }}">
                                <div>Upload Berkas</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 1 ? 'active' : '' }}">
                                <div>Verifikasi Data Upload</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 2 ? 'active' : '' }}">
                                <div>Verifikasi Zoom</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 3 ? 'active' : '' }}">
                                <div>Verifikasi Lapangan</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 4 ? 'active' : '' }}">
                                <div>Selesai</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('url')
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
