@extends('theme.panel')

@section('title', 'Detail')

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
        >Detail {{ auth()->user()->isGuest() ? 'Proses' : '' }}</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        @php
            $attachments[] = $test_letter->sop_component_installation;
            $attachments[] = $test_letter->technical_drawing;
            $attachments[] = $test_letter->conversion_workshop_certificate;
            $attachments[] = $test_letter->electrical_diagram;
            $attachments[] = $test_letter->photocopy_stnk;
            $attachments[] = $test_letter->physical_inspection;
            $attachments[] = $test_letter->test_report;
        @endphp
        @can('isAdmin')
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Data Penanggung Jawab</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Nama</div>
                            <div class="datagrid-content">{{ @$test_letter->responsible_person }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Bengkel</div>
                            <div class="datagrid-content">{{ @$test_letter->workshop }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Jenis Bengkel</div>
                            <div class="datagrid-content">{{ @$test_letter->workshop_type }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">No. Telepon</div>
                            <div class="datagrid-content">{{ @$test_letter->telephone }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Alamat</div>
                            <div class="datagrid-content">{{ @$test_letter->telephone }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <div class="card-title">Data Berkas Penerbitan</div>
                </div>
                <div class="card-body">
                    <input type="hidden" id="id" value="{{ $test_letter->id }}" name="id">
                    <div class="row">
                        @foreach($attachments as $attachment)
                            @if($attachment != null)
                                    <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($attachment)]) }}" class="d-flex align-items-center file-pdf-2 mb-3">
                                        <img width="24" src="{{ asset('assets/dist/img/pdf_illustration.png') }}">
                                        {{ Str::limit(substr($attachment, strlen('documents/')), 60) }}
                                    </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Data Berkas Pengujian Fisik BPLJSKB</div>
                </div>
                <div class="card-body">
                    <input type="hidden" id="id" value="{{ $test_letter->id }}" name="id">
                    <div class="row">
                        @if($test_letter->physical_test_bpljskb != null)
                            <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($test_letter->physical_test_bpljskb)]) }}" class="d-flex align-items-center file-pdf-2 mb-3">
                                <img width="24" src="{{ asset('assets/dist/img/pdf_illustration.png') }}">
                                {{ Str::limit(substr($test_letter->physical_test_bpljskb, strlen('sertifikat-uji/')), 60) }}
                            </a>
                        @else
                            <div class="bg-primary-lt w-100 p-8 rounded-3 mb-3 img-border text-center">
                                <img class="img-fluid" width="300" src="{{ asset('assets/dist/img/undraw_no_data_re_kwbl.svg') }}">
                                <span class="text-center fs-3 d-block mt-5">Data Tidak Tersedia</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcan
    </div>
        @can('isGuest')
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
                                <div class="alert-heading text-left">{{ @$test_letter->status }}</div>
                                {{--                                @if(@$test_letter->is_verified && @$test_letter->step == 'send_spu')--}}
                                {{--                                    <span class="text-secondary text-left">Silakan lanjutkan pengujian fisik ke BPLJSKB dengan membawa Surat Pengantar Uji dan dokumen pendukung. Proses dilakukan sendiri oleh pemohon tanpa pendampingan admin.--}}
                                {{--                                         <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$test_letter->spu_attachment)]) }}">Unduh Surat Pengantar Uji di sini</a></span>--}}
                                {{--                                @endif--}}
                                {{--                                @if(@$test_letter->is_verified && @$test_letter->step == 'bpljskb_uploaded')--}}
                                {{--                                    <span>Mohon menunggu, dokumen Anda sedang diperiksa oleh admin. Surat Keterangan dan Sertifikat akan segera diperoses.</span>--}}
                                {{--                                @endif--}}
                                {{--                                @if(!@$test_letter->is_verified && !@$test_letter->step == 'send_spu')--}}
                                {{--                                    <span>Mohon menunggu, dokumen Anda sedang diperiksa oleh admin. Surat Pengantar Uji akan tersedia setelah proses verifikasi selesai.</span>--}}
                                {{--                                @endif--}}
                                {!! @$test_letter->message !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-primary-lt w-100 p-8 rounded-3 mb-3 img-border text-center">
                    @if(@$test_letter->is_verified)
                        <img class="img-fluid" width="300" src="{{ asset('assets/dist/img/undraw_happy-announcement_23nf.svg') }}">
                    @else
                        <img class="img-fluid" width="300" src="{{ asset('assets/dist/img/undraw_loading_65y2.svg') }}">
                    @endif
                </div>
                @if(@$test_letter->is_verified && (@$test_letter->step == 'completed' || @$test_letter->step == 'next_request_srut'))
                    @php
                        $attachment_certificates [] = [
                            'file' => $test_letter->certificate->type_test_attachment,
                            'name' => 'Sertifikat SUT'];
                        $attachment_certificates [] = [
                            'file' => $test_letter->certificate->registration_attachment,
                            'name' => 'Sertifikat SRUT'];
                        $attachment_certificates [] = [
                            'file' => $test_letter->certificate->sk_attachment,
                            'name' => 'Surat Keterangan SUT dan Lampiran SUT'];
                    @endphp
                    <div class="row w-100 gap-2">
                        @foreach($attachment_certificates as $row)
                            @if($row['file'] != null)
                                <div class="col-12">
                                    <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($row['file'])]) }}" class="btn btn-outline-primary w-100 text-left">{{ $row['name'] }}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endcan
    </div>
@endsection

@section('url')

@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/test_letter.js'])
@endsection
