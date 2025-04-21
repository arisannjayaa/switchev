@extends('theme.panel')

@section('title', 'User')

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
                                <a href="#">User</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >User</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                                            <a id="btn-add" href="javascript:void(0)" class="btn btn-primary">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                                                Tambah User
                                            </a>
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
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
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
    <input type="hidden" id="table-url" value="{{ route('user.table') }}">
    <input type="hidden" id="create-url" value="{{ route('user.create') }}">
    <input type="hidden" id="update-url" value="{{ route('user.update') }}">
    <input type="hidden" id="delete-url" value="{{ route('user.delete') }}">
    <input type="hidden" id="edit-url" value="{{ route('user.show', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/user/user.js'])
@endsection
