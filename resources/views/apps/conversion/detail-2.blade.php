@extends('theme.panel')

@section('title', 'Detail Data Konversi Bengkel')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
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
        <div class="card">
            <div class="d-block">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-application-letter" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">Surat Permohonan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-sdm-certificate" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Lampiran Data SDM dan Sertifikat Kompetensi Teknisi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-equipment" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Lampiran Data Peralatan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-sop" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Lampiran SOP</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-wiring-diagram" class="nav-link" data-bs-toggle="tab" aria-selected="false" tabindex="-1" role="tab">Lampiran Wiring Diagram</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-application-letter" role="tabpanel">
                            <div class="w-full">
                                <div class="alert alert-info" role="alert">
                                    <div class="d-flex">
                                        <div>
                                            <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                        </div>
                                        <div>
                                            Jika file tidak terlihat, browser anda tidak mendukung untuk melihat file ini. Silahkan unduh file <a href="{{ asset('storage/'.$conversion->application_letter) }}" target="_blank">disini</a>
                                        </div>
                                    </div>
                                </div>
                                <iframe src="{{ asset('storage/'.$conversion->application_letter) }}" width="100%" height="800"></iframe>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-sdm-certificate" role="tabpanel">
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                    </div>
                                    <div>
                                        Jika file tidak terlihat, browser anda tidak mendukung untuk melihat file ini. Silahkan unduh file <a href="{{ asset('storage/'.$conversion->technician_competency) }}" target="_blank">disini</a>
                                    </div>
                                </div>
                            </div>
                            <iframe src="{{ asset('storage/'.$conversion->technician_competency) }}" width="100%" height="800"></iframe>
                        </div>
                        <div class="tab-pane" id="tabs-equipment" role="tabpanel">
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                    </div>
                                    <div>
                                        Jika file tidak terlihat, browser anda tidak mendukung untuk melihat file ini. Silahkan unduh file <a href="{{ asset('storage/'.$conversion->equipment) }}" target="_blank">disini</a>
                                    </div>
                                </div>
                            </div>
                            <iframe src="{{ asset('storage/'.$conversion->equipment) }}" width="100%" height="800"></iframe>
                        </div>
                        <div class="tab-pane" id="tabs-sop" role="tabpanel">
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                    </div>
                                    <div>
                                        Jika file tidak terlihat, browser anda tidak mendukung untuk melihat file ini. Silahkan unduh file <a href="{{ asset('storage/'.$conversion->sop) }}" target="_blank">disini</a>
                                    </div>
                                </div>
                            </div>
                            <iframe src="{{ asset('storage/'.$conversion->sop) }}" width="100%" height="800"></iframe>
                        </div>
                        <div class="tab-pane" id="tabs-wiring-diagram" role="tabpanel">
                            <div class="alert alert-info" role="alert">
                                <div class="d-flex">
                                    <div>
                                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg>
                                    </div>
                                    <div>
                                        Jika file tidak terlihat, browser anda tidak mendukung untuk melihat file ini. Silahkan unduh file <a href="{{ asset('storage/'.$conversion->wiring_diagram) }}" target="_blank">disini</a>
                                    </div>
                                </div>
                            </div>
                            <iframe src="{{ asset('storage/'.$conversion->wiring_diagram) }}" width="100%" height="800"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('url')
    <input type="hidden" id="table-url" value="{{ route('conversion.table') }}">
    <input type="hidden" id="create-url" value="{{ route('conversion.create') }}">
    <input type="hidden" id="update-url" value="{{ route('conversion.update') }}">
    <input type="hidden" id="delete-url" value="{{ route('conversion.delete') }}">
    <input type="hidden" id="edit-url" value="{{ route('conversion.show', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
