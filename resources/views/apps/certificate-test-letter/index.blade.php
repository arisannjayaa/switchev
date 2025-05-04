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
                            <li class="breadcrumb-item active">
                                <a href="#">Daftar Permohonan</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Daftar Permohonan</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
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
                                <th>Nama Pemohon</th>
                                <th>Kendaraan</th>
                                <th>Bengkel</th>
                                <th>Tipe</th>
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
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('certificate.test.letter.table') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/certificate.js'])
@endsection
