@extends('theme.panel')

@section('title', 'Proses Sertifikasi Konversi')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }

        .step-item:after, .step-item:before {
            background-color: #0054a6 !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2>Proses Sertifikasi Verifikasi Berkas</h2>
            </div>
        </div>
        @if($conversion->status == 'checking')
            <div class="alert alert-info" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                    </div>
                    <div>
                        <h4 class="alert-title">{{ \App\Helpers\Helper::check_status_conversion(@$conversion->status) }}</h4>
                        <div class="text-secondary">{{ @$conversion->message }}</div>
                    </div>
                </div>
            </div>
        @endif
        @if($conversion->status == 'verified_upload')
            <div class="alert alert-info" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                    </div>
                    <div>
                        <h4 class="alert-title">{{ \App\Helpers\Helper::check_status_conversion(@$conversion->status) }}</h4>
                        <div class="text-secondary">{{ @$conversion->message }}</div>
                    </div>
                </div>
            </div>
        @endif
        @if($conversion->status == 'rejected')
            <div class="alert alert-danger" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                    </div>
                    <div>
                        <h4 class="alert-title">{{ \App\Helpers\Helper::check_status_conversion(@$conversion->status) }}</h4>
                        <div class="text-secondary"> {{ @$conversion->message }} <span>Silahkan perbaiki data pada link berikut ini.</span> <a href="{{ route('conversion.form', ['id' => $conversion->id]) }}">Perbaiki data</a></div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card d-none d-lg-block">
            <div class="card-body">
                <ul class="steps steps-green steps-counter my-4">
                    <li class="step-item {{ $conversion->step == 'step-1' ? 'active' : '' }}">Upload Berkas</li>
                    <li class="step-item {{ $conversion->step == 'step-2' ? 'active' : '' }}">Konfirmasi Admin</li>
                    <li class="step-item {{ $conversion->step == 'step-3' ? 'active' : '' }}">Verifikasi Via Zoom</li>
                    <li class="step-item {{ $conversion->step == 'step-4' ? 'active' : '' }}">Verifikasi Lapangan</li>
                    <li class="step-item {{ $conversion->step == 'step-5' ? 'active' : '' }}">Selesai</li>
                </ul>
            </div>
        </div>
        <div class="card d-lg-none d-block">
            <div class="card-body">
                <ul class="steps steps-vertical">
                    <li class="step-item {{ $conversion->step == 'step-1' ? 'active' : '' }}">
                        <div class="h4 m-0">Upload Berkas</div>
                    </li>
                    <li class="step-item {{ $conversion->step == 'step-2' ? 'active' : '' }}">
                        <div class="h4 m-0">Konfirmasi Admin</div>
                    </li>
                    <li class="step-item {{ $conversion->step == 'step-3' ? 'active' : '' }}">
                        <div class="h4 m-0">Verifikasi Via Zoom</div>
                    </li>
                    <li class="step-item {{ $conversion->step == 'step-4' ? 'active' : '' }}">
                        <div class="h4 m-0">Verifikasi Lapangan</div>
                    </li>
                    <li class="step-item {{ $conversion->step == 'step-5' ? 'active' : '' }}">
                        <div class="h4 m-0">Selesai</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center mt-5">
            <img class="text-center" width="600" src="{{ asset('assets/dist/img/undraw_in-progress_cdfz.svg') }}">
        </div>
    </div>
@endsection

@section('url')
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
