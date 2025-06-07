@extends('theme.panel')

@section('title', 'Daftar Resume Hasil Uji')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }

        .btn-sm {
            width: 28px !important;
            height: 28px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="page-header d-print-none mb-2">
            <div>
                <div class="page-header mb-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="mb-1">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a href="{{ route('test.letter.index') }}">Daftar Resume Hasil Uji</a>
                                    </li>
                                </ol>
                            </div>
                            <h2 class="page-title">
        <span class="text-truncate"
        >Daftar Resume Hasil Uji</span
        >
                            </h2>
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table">
                        <table id="table" class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Pemohon</th>
                                <th>Tipe Bengkel</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('apps.resume.test-physical-modal')
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('resume.table') }}">
    <input type="hidden" id="upload-physical-test-url" value="{{ route('resume.upload') }}">
    <input type="hidden" id="show-physical-test-url" value="{{ route('resume.show_physical_test_letter', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/resume.js'])
@endsection
