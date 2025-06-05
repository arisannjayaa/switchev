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
                    <div>
                        <input type="text" name="date_range" id="date-range" class="form-control" placeholder="Pilih rentang tanggal" required>
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div>
                        <button class="btn btn-success" id="btn-export">Export</button>
                    </div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter
                        </button>
                        <div class="dropdown-menu p-4" style="min-width: 300px;">
                            <div class="mb-3">
                                <label class="form-label">Status Permohonan</label>
                                <select class="form-select" id="status-filter">
                                    <option value="">Semua</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Terverifikasi">Terverifikasi</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Draft SRUT">Draft SRUT</option>
                                    <option value="Draft SUT">Draft SUT</option>
                                    <option value="Draft SRUT SUT">Draft SRUT SUT</option>
                                    <option value="SUT Terverifikasi">SUT Terverifikasi</option>
                                    <option value="SRUT Terverifikasi">SRUT Terverifikasi</option>
                                    <option value="SRUT SUT Terverifikasi">SRUT SUT Terverifikasi</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Bengkel</label>
                                <select class="form-select" id="workshop-type-filter">
                                    <option value="">Semua</option>
                                    <option value="A">Tipe A</option>
                                    <option value="B">Tipe B</option>
                                </select>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-primary" id="btn-apply-filter">Terapkan</button>
                            </div>
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
                                <th>No Surat</th>
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
    <input type="hidden" id="export-url" value="{{ route('certificate.test.letter.export') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/test-letter/certificate.js'])
@endsection
