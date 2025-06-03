@extends('theme.panel')

@section('title', 'Form')

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
                                <a href="{{ route('template.index') }}">Template</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">Form</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Form</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        <form id="form-template">
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
                        <span class="alert-heading">Peringatan</span>
                    </div>
                </div>
                <p>Jangan pernah menghapus variabel sensitif dalam dokumen. Variabel sensitif itu berupa <strong>"${nama_variabel}"</strong>. Variabel ini akan diisi oleh sistem. Jika di hapus akan terjadi kesalahan sistem.</p>
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
                        <span class="alert-heading">Template Awal</span>
                    </div>
                </div>
                <p>Ini adalah template awal. Jika terjadi kesalahan, silahkan menggunakan template ini. <a class="fw-bold" href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$template->attachment_default)]) }}" target="_blank">Unduh</a></p>
            </div>
            <div class="card">
                <div class="card-body">
                    <input type="hidden" name="id" value="{{ \App\Helpers\Helper::encrypt(@$template->id) }}">
                    <div class="mb-3">
                        <label class="form-label required">Lampiran</label>
                        <input id="attachment" type="file" class="form-control" name="attachment">
                        @if(@$template->attachment) <input type="hidden" class="form-control" name="old_attachment" value="{{ @$template->attachment }}"> @endif
                        <small class="form-hint">
                            @if(@$template->attachment) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$template->attachment)]) }}">lihat disini</a>
                            <br> @endif
                        </small>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-between mt-3">
                <div class="col-12 text-end">
                    <button id="btn-submit" type="submit" class="btn btn-primary text-end">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('url')
    <input type="hidden" id="update-url" value="{{ route('template.update') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/template-certificate/template.js'])
@endsection
