@extends('theme.panel')

@section('title', 'Akun Belum Terverifikasi')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <div class="mb-4">
                <img class="img-fluid" width="400" src="{{ asset('assets/dist/img/undraw_pending-approval_6cdu.svg') }}">
            </div>
            <div class="text-center">
                <h1 class="fw-bold">Akun Anda Belum Terverifikasi</h1>
                <p class="text-muted">Silahkan tunggu sampai akun anda terverifikasi</p>
            </div>
        </div>
    </div>
    @include('apps.user.modal')
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
