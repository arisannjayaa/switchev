@extends('theme.panel')

@section('title', 'Buat Surat Keterangan dan Sertifikat Bengkel Konversi')

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
    </style>
@endsection

@section('content')
    <div class="container">
        <input id="id" type="hidden" value="{{ $conversion->id }}">
        <div class="mb-3">
            <label class="form-label required">Akreditasi Bengkel</label>
            <select id="accreditation_type" class="form-select" name="accreditation_type">
                <option value="A">Akreditasi A</option>
                <option value="B">Akreditasi B</option>
            </select>
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
                    <span class="alert-heading">Sertifikat bisa diunduh disini</span>
                </div>
                <button id="btn-download-certificate" class="btn btn-outline-primary">
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

        @if(@$conversion->certificate->status == 'Draft' || @$conversion->certificate == null)
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

        @if(@$conversion->certificate->status == 'Terverifikasi')
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Upload File</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input id="certificate_id" type="hidden" class="form-control" name="certificate_id" value="{{ @$conversion->certificate_id }}">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label required">Surat Keterangan</label>
                                <input id="sk_attachment" type="file" class="form-control" name="sk_attachment">
                                @if(@$conversion->certificate->sk_attachment) <input type="hidden" class="form-control" name="old_sk_attachment" value="{{ @$conversion->certificate->sk_attachment }}"> @endif
                                <small class="form-hint">
                                    @if(@$conversion->certificate->sk_attachment) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->certificate->sk_attachment)]) }}">lihat disini</a> @endif
                                    Upload file dalam bentuk pdf hasil dari surat keterangan
                                </small>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label required">Sertifikat</label>
                                <input id="sft_attachment" type="file" class="form-control" name="sft_attachment">
                                @if(@$conversion->certificate->sft_attachment) <input type="hidden" class="form-control" name="old_sft_attachment" value="{{ @$conversion->certificate->sft_attachment }}"> @endif
                                <small class="form-hint">
                                    @if(@$conversion->certificate->sft_attachment) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->certificate->sft_attachment)]) }}">lihat disini</a> @endif
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
    <input type="hidden" id="user-id" value="{{ $conversion->user_id }}">
    <input type="hidden" id="download-certificate-url" value="{{ route('certificate.generate.certificate') }}">
    <input type="hidden" id="download-sk-url" value="{{ route('certificate.generate.sk') }}">
    <input type="hidden" id="upload-archive-url" value="{{ route('certificate.upload.archive') }}">
    <input type="hidden" id="send-draft-url" value="{{ route('certificate.send.draft') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
    @if($conversion->step == 5) @vite(['resources/js/apps/certificate/certificate.js']) @endif
@endsection
