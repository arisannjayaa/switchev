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
        <div class="page-header mb-3">
            <div class="row align-items-center">
                <div class="col">
                    <div class="mb-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('conversion.index') }}">Daftar Bengkel Konversi</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="#">Detail Bengkel Konversi</a>
                            </li>
                        </ol>
                    </div>
                    <h2 class="page-title">
        <span class="text-truncate"
        >Detail Bengkel Konversi</span
        >
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
        <input id="id" type="hidden" value="{{ $conversion->id }}">
        @if(@$conversion->certificate->status == 'Selesai')
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Sertifikat dan Surat Keterangan</h3>
                </div>
                <div class="card-body">
                    <div class="row gap-3">
                        <div class="col-12">
                            <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->certificate->sft_attachment)]) }}" class="bg-white-lt pointer-event w-100 p-3 rounded-3 text-primary d-block" href="" style="border: 1px solid #0054a6">
                                Sertifikat Bengkel Konversi
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->certificate->sk_attachment)]) }}" class="bg-white-lt pointer-event w-100 p-3 rounded-3 text-primary d-block" href="" style="border: 1px solid #0054a6">
                                Surat Keterangan Bengkel Konversi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
                <h3 class="card-title">Data Tenaga Ahli</h3>
            </div>
            <div class="card-body">
                <div class="card mb-3">
                    <div class="table-responsive" style="max-height: 300px; overflow-y: scroll">
                        <table class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggung Jawab</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($conversion->mechanicals as $mechanical)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mechanical->name }}</td>
                                    <td>{{ $mechanical->task }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Data Peralatan</h3>
            </div>
            <div class="card-body">
                <div class="card mb-3">
                    <div class="table-responsive" style="max-height: 300px; overflow-y: scroll">
                        <table class="table table-vcenter card-table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tipe</th>
                                <th>Nama</th>
                                <th>Merek</th>
                                <th>Spesifikasi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($conversion->equipments as $equipment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $equipment->type }}</td>
                                    <td>{{ $equipment->name }}</td>
                                    <td>{{ $equipment->brand }}</td>
                                    <td>{{ $equipment->specification }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
                            @if($attachment)
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="file-pdf py-3">
                                        <a target="_blank" href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt($attachment)]) }}" class="d-flex flex-column align-items-center justify-content-center">
                                            <img width="150" src="{{ asset('assets/dist/img/pdf_illustration.png') }}">
                                            <span class="text-center" style="color: #182433" data-bs-toggle="tooltip" data-bs-placement="top"
                                                  data-bs-title="{{ substr($attachment, strlen('documents/')) }}">{{ Str::limit(substr($attachment, strlen('documents/')), 20) }}</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('conversion.table') }}">
{{--    <input type="hidden" id="create-url" value="{{ route('conversion.upsert') }}">--}}
    <input type="hidden" id="approve-url" value="{{ route('conversion.approve') }}">
    <input type="hidden" id="reject-url" value="{{ route('conversion.reject') }}">
    <input type="hidden" id="edit-url" value="{{ route('conversion.show', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
