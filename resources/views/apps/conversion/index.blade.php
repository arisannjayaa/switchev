@extends('theme.panel')

@section('title', 'Data Konversi Bengkel')

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
                                <a href="#">Daftar Bengkel Konversi</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Daftar Bengkel Konversi</span
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
                                <th>Penanggung Jawab</th>
                                <th>Bengkel</th>
                                <th>WhatsApp</th>
                                <th>Jenis</th>
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
    @include('apps.user.modal')
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('conversion.table') }}">
    <input type="hidden" id="show-url" value="{{ route('conversion.show', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
