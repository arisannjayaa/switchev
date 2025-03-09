@extends('theme.panel')

@section('title', 'Detail Data Konversi Bengkel')

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
    </style>
@endsection

@section('content')
    <div class="container">
        <input id="id" type="hidden" value="{{ $conversion->id }}">
        <div class="page-header d-print-none mb-2">
            <div>
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-title">
                            Detail Bengkel Konversi
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Data Penanggung Jawab</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Nama</div>
                        <div class="datagrid-content">{{ $conversion->person_responsible }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">No. Whatsapp</div>
                        <div class="datagrid-content">{{ $conversion->whatapp_responsible }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Data Bengkel</h3>
            </div>
            <div class="card-body">
                <div class="datagrid">
                    <div class="datagrid-item">
                        <div class="datagrid-title">Nama</div>
                        <div class="datagrid-content">{{ $conversion->workshop }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Jenis</div>
                        <div class="datagrid-content">{{ $conversion->type }}</div>
                    </div>
                    <div class="datagrid-item">
                        <div class="datagrid-title">Alamat</div>
                        <div class="datagrid-content">{{ $conversion->address }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Dokumen</h3>
            </div>
            <div class="card-body">
                @if($attachments[0] == null)
                    <div class="d-flex justify-content-center align-items-center">
                        <div>
                            <img class="mb-4 p-2" width="300" src="{{ asset('assets/dist/img/undraw_no_data_re_kwbl.svg') }}" alt="">
                            <h4 class="text-center">Data Kosong</h4>
                        </div>
                    </div>
                @endif
                @if($attachments[0])
                    <div class="row">
                        @foreach($attachments as $attachment)
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="file-pdf py-3">
                                    <a target="_blank" href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($attachment)]) }}" class="d-flex flex-column align-items-center justify-content-center">
                                        <img width="150" src="{{ asset('assets/dist/img/pdf_illustration.png') }}">
                                        <span class="text-center" style="color: #182433" data-bs-toggle="tooltip" data-bs-placement="top"
                                              data-bs-title="{{ substr($attachment, strlen('documents/')) }}">{{ Str::limit(substr($attachment, strlen('documents/')), 20) }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @if($conversion->status == 'checking')
            <div class="card-footer text-end">
                <button id="btn-reject" type="submit" class="btn btn-danger">Batalkan</button>
                <button id="btn-approve" type="submit" class="btn btn-primary">Verifikasi Berkas Sesuai</button>
            </div>
        @endif
    </div>
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('conversion.table') }}">
    <input type="hidden" id="create-url" value="{{ route('conversion.upsert') }}">
    <input type="hidden" id="approve-url" value="{{ route('conversion.approve') }}">
    <input type="hidden" id="reject-url" value="{{ route('conversion.reject') }}">
    <input type="hidden" id="edit-url" value="{{ route('conversion.show', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
