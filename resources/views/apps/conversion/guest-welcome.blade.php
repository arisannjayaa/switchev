@extends('theme.panel')

@section('title', 'Pendaftaran Sertifikasi Konversi')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center text-center flex-column">
            <div class="bg-primary-lt w-100 p-8 rounded-3 mb-3">
                <img class="img-fluid" width="300" src="{{ asset('assets/dist/img/undraw_happy-announcement_23nf.svg') }}">
            </div>
            <div class="text-center">
                <h1 class="fw-bold">Selamat Datang di Pengajuan Sertifikasi Konversi</h1>
                <p class="text-muted">Silahkan mulai mengisi form di bawah ini</p>
                <a href="{{ route('conversion.form', ['step' => "step-1"]) }}" class="btn btn-primary">Mulai</a>
            </div>
        </div>
    </div>
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('user.table') }}">
    <input type="hidden" id="create-url" value="{{ route('user.create') }}">
    <input type="hidden" id="update-url" value="{{ route('user.update') }}">
    <input type="hidden" id="delete-url" value="{{ route('user.delete') }}">
    <input type="hidden" id="edit-url" value="{{ route('user.show', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
