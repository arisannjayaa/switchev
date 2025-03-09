@extends('theme.panel')

@section('title', 'Form Pendaftaran Bengkel Konversi')

@section('style')
    <style>
        #table_wrapper {
            padding: 20px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h3 class="card-title fs-1 fw-bold">Form Pendaftaran Bengkel Konversi</h3>
        <form id="form-conversion" class="card">
            <input type="hidden" name="id" value="{{ @$conversion->id }}">
            <div class="card-body">
                <div class="row row-cards">
                    <span class="fs-3 fw-bold">Data Penanggung Jawab</span>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama penanggung jawab" name="person_responsible" value="{{ @$conversion->person_responsible }}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">No Whatsapp</label>
                            <input type="text" class="form-control" placeholder="No Whatsapp" name="whatapp_responsible" value="{{ @$conversion->whatapp_responsible }}">
                        </div>
                    </div>
                    <span class="fs-3 fw-bold">Data Bengkel</span>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Nama Bengkel Konversi</label>
                            <input type="text" class="form-control" placeholder="Nama Bengkel Konversi" name="workshop" value="{{ @$conversion->workshop }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label required">Jenis Bengkel</label>
                            <select class="form-select" name="type">
                                <option value="">Pilih Jenis Bengkel</option>
                                <option value="Sepeda Motor" {{ @$conversion->type == 'Sepeda Motor' ? 'selected' : '' }}>Sepeda Motor</option>
                                <option value="Selain Sepeda Motor" {{ @$conversion->type == 'Sepeda Motor' ? 'selected' : '' }}>Selain Sepeda Motor</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label required">Alamat Bengkel</label>
                            <textarea class="form-control" name="address" rows="6" placeholder="Alamat..">{{ @$conversion->address }}</textarea>
                        </div>
                    </div>
                    <span class="fs-3 fw-bold">Dokumen</span>
                    <div class="col-lg-6 col-12">
                        <div class="mb-3">
                            <label class="form-label required">Surat Permohonan</label>
                            <input type="file" class="form-control" name="application_letter">
                            <small class="form-hint">
                                Format dokumen tersedia dapat di unduh <a target="_blank" href="https://bit.ly/konversiEV">Disini</a>
                            </small>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="mb-3">
                            <label class="form-label required">Lampiran Data SDM dan Sertifikat Kompetensi Teknisi</label>
                            <input type="file" class="form-control" name="technician_competency">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="mb-3">
                            <label class="form-label required">Lampiran Data Peralatan</label>
                            <input type="file" class="form-control" name="equipment">
                            <small class="form-hint">
                                Tabel berisi kategori peralatan, nama alat, merek, spesifikasi, jumlah dan dokumentasi/foto alat.  Pastikan alat uji hambatan isolasi (megger/insulation tester, dsb) dan alat uji perlindungan sentuh listrik berupa IPXXB dan IPXXD (finger probe dan wire probe) sudah lengkap.
                            </small>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="mb-3">
                            <label class="form-label required">Lampiran SOP Pengerjaan Konversi</label>
                            <input type="file" class="form-control" name="sop">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="mb-3">
                            <label class="form-label required">Lampiran Wiring Diagram Kendaraan Bermotor Konversi Selain Sepeda Motor</label>
                            <input type="file" class="form-control" name="wiring_diagram">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <button id="btn-submit" type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
            </div>
        </form>
    </div>
@endsection

@section('url')
    <input type="hidden" id="create-url" value="{{ route('conversion.upsert') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
