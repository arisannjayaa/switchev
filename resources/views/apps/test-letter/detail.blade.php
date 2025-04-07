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
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <div class="w-100">
                <div class="alert alert-important alert-info" role="alert">
                    <div class="d-flex">
                        <div class="alert-icon">
                            <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                <path d="M12 8v4"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="alert-heading text-left">{{ $test_letter->status }}</div>
                            @if($test_letter->is_verified)
                                <span class="text-secondary text-left">Silakan lanjutkan pengujian fisik ke BPLJSKB dengan membawa Surat Pengantar Uji dan dokumen pendukung. Proses dilakukan sendiri oleh pemohon tanpa pendampingan admin.
                                     <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($test_letter->physical_test_cover_letter)]) }}">Unduh Surat Pengantar Uji di sini</a></span>
                            @else
                                <span>Mohon menunggu, dokumen Anda sedang diperiksa oleh admin. Surat Pengantar Uji akan tersedia setelah proses verifikasi selesai.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-primary-lt w-100 p-8 rounded-3 mb-3 img-border text-center">
                @if($test_letter->is_verified)
                    <img class="img-fluid" width="300" src="{{ asset('assets/dist/img/undraw_happy-announcement_23nf.svg') }}">
                @else
                    <img class="img-fluid" width="300" src="{{ asset('assets/dist/img/undraw_loading_65y2.svg') }}">
                @endif
            </div>
        </div>
    </div>
@endsection

@section('url')

@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/test_letter.js'])
@endsection
