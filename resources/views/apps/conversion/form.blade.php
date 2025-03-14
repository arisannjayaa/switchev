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
        <form id="form-conversion">
            <input type="hidden" name="id" value="{{ @$conversion->id }}">
            <div class="card card-md">
                <div class="card-body text-center py-4 p-sm-5">
                    <h1 class="mt-5">Form Pendaftaran Bengkel Konversi</h1>
                </div>
                <div class="hr-text hr-text-center hr-text-spaceless">{{ $titleStep }}</div>
                <div class="card-body">
                    <div class="row row-cards">
                        @if(@$form == 1 || @$conversion == null)
                            <input type="hidden" id="step" name="step" value="1">
                            <input type="hidden" id="step" name="step_1_completed" value="1">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Bengkel Konversi</label>
                                    <input type="text" class="form-control" placeholder="Nama Bengkel Konversi" name="workshop" value="{{ @$conversion->workshop }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Jenis Bengkel</label>
                                    <select id="type" class="form-select" name="type">
                                        <option value="">Pilih Jenis Bengkel</option>
                                        <option value="Sepeda Motor" {{ @$conversion->type == 'Sepeda Motor' ? 'selected' : '' }}>Sepeda Motor</option>
                                        <option value="Selain Sepeda Motor" {{ @$conversion->type == 'Selain Sepeda Motor' ? 'selected' : '' }}>Selain Sepeda Motor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Alamat Bengkel</label>
                                    <textarea class="form-control" name="address" rows="6" placeholder="Alamat..">{{ @$conversion->address }}</textarea>
                                </div>
                            </div>
                        @endif
                        @if(@$form == 2)
                            <input type="hidden" id="step" name="step" value="2">
                            <input type="hidden" id="step" name="step_2_completed" value="1">
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">

                                    <label class="form-label required">Surat Permohonan</label>
                                    <input id="application_letter" type="file" class="form-control" name="application_letter">
                                    @if(@$conversion->application_letter) <input type="hidden" class="form-control" name="old_application_letter" value="{{ @$conversion->application_letter }}"> @endif
                                    <small class="form-hint">
                                        @if(@$conversion->application_letter) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->application_letter)]) }}">lihat disini</a>
                                        <br> @endif
                                        Format dokumen tersedia dapat di unduh <a target="_blank" href="https://bit.ly/konversiEV">Disini</a>
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Data SDM dan Sertifikat Kompetensi Teknisi</label>
                                    <input id="technician_competency" type="file" class="form-control" name="technician_competency">
                                    @if(@$conversion->technician_competency) <input type="hidden" class="form-control" name="old_technician_competency" value="{{ @$conversion->technician_competency }}"> @endif
                                    <small class="form-hint">
                                        @if(@$conversion->technician_competency) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->technician_competency)]) }}">lihat disini</a> @endif
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran Data Peralatan</label>
                                    <input id="equipment" type="file" class="form-control" name="equipment">
                                    @if(@$conversion->equipment) <input type="hidden" class="form-control" name="old_equipment" value="{{ @$conversion->equipment }}"> @endif
                                    <small class="form-hint">
                                        @if(@$conversion->equipment) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->equipment)]) }}">lihat disini</a>
                                        <br> @endif
                                        Tabel berisi kategori peralatan, nama alat, merek, spesifikasi, jumlah dan dokumentasi/foto alat.  Pastikan alat uji hambatan isolasi (megger/insulation tester, dsb) dan alat uji perlindungan sentuh listrik berupa IPXXB dan IPXXD (finger probe dan wire probe) sudah lengkap.
                                    </small>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Lampiran SOP Pengerjaan Konversi</label>
                                    <input id="sop" type="file" class="form-control" name="sop">
                                    @if(@$conversion->sop) <input type="hidden" class="form-control" name="old_sop" value="{{ @$conversion->sop }}"> @endif
                                    <small class="form-hint">
                                        @if(@$conversion->sop) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->sop)]) }}">lihat disini</a> @endif
                                    </small>
                                </div>
                            </div>
                            @if(@$conversion->type == "Selain Sepeda Motor")
                            <div class="col-lg-6 col-12">
                                <div class="mb-3" style="display: none;" id="select-wiring-diagram">
                                    <label class="form-label required">Lampiran Wiring Diagram Kendaraan Bermotor Konversi Selain Sepeda Motor</label>
                                    <input id="wiring_diagram" type="file" class="form-control" name="wiring_diagram">
                                    @if(@$conversion->wiring_diagram) <input type="hidden" class="form-control" name="old_wiring_diagram" value="{{ @$conversion->wiring_diagram }}"> @endif
                                    <small class="form-hint">
                                        @if(@$conversion->wiring_diagram) sudah pernah diupload, <a href="{{ route('secure.file', ['path' => \App\Helpers\Helper::encrypt(@$conversion->wiring_diagram)]) }}">lihat disini</a> @endif
                                    </small>
                                </div>
                            </div>
                            @endif
                        @endif
                        @if(@$form == 3)
                            <input type="hidden" id="step" name="step" value="3">
                            <input type="hidden" id="step" name="step_3_completed" value="1">
                            <div class="col-lg-12 col-12">
                                <div class="d-flex justify-content-end align-items-center">
                                    <button id="btn-add-technician" class="btn btn-outline-primary" type="button">Tambah</button>
                                </div>
                                <div class="table-responsive">
                                    <table id="table-technician" class="table table-vcenter card-table">
                                        <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Tugas</th>
                                            <th class="w-1"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="table-body-technician">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col-4">
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ @$conversion->form_progress ?? 0 }}%" role="progressbar" aria-valuenow="{{ @$conversion->form_progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ @$conversion->form_progress ?? 0 }}% Complete">
                            <span class="visually-hidden">{{ @$conversion->form_progress ?? 0 }}% Complete</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    @php
                        $previous_step = $form > 1 ? $form - 1 : null;
                        $next_step = $form < 4 ? $form + 1 : null;
                    @endphp
                    <div class="btn-list justify-content-end">
                        @if($previous_step)
                        <a id="btn-previous" class="btn btn-primary" href="{{ route('conversion.form', ['step' => $previous_step]) }}">
                            Sebelumnya
                        </a>
                        @endif
                        @if($next_step)
                        <button type="submit" id="btn-next" class="btn btn-primary">
                            Selanjutnya
                        </button>
                        @else
                        <button id="btn-next" type="submit" class="btn btn-primary">
                            Kirim Pendaftararan
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @include('apps.conversion.form-modal')
        </form>
    </div>
@endsection

@section('url')
    <input type="hidden" id="form-responsible-url" value="{{ route('conversion.upsertFormResponsibleWorkshop') }}">
    <input type="hidden" id="form-document-url" value="{{ route('conversion.upsertFormDocument') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
@endsection
