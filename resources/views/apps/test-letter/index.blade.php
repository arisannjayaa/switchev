@extends('theme.panel')

@section('title', 'Penerbitan Surat Uji Kendaraan dan Sertifikat Registrasi Uji Kendaraan')

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
        @can('isAdmin')
            @include('apps.test-letter.admin-index')
        @endcan
        @can('isGuest')
            @include('apps.test-letter.guest-index')
        @endcan
    </div>
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('test.letter.table') }}">
    <input type="hidden" id="upload-physical-test-url" value="{{ route('test.letter.upload_physical_test_letter') }}">
    <input type="hidden" id="show-physical-test-url" value="{{ route('test.letter.show_physical_test_letter', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/test_letter.js'])
@endsection
