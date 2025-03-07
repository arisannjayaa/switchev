@extends('theme.panel')

@section('title', 'Form Tambah Kandidat')

@section('style')
    <style>
        .quill-has-error {
            padding: 10px;
            border: 2px red dashed;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="page-header d-print-none mb-2">
            <div>
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Form Tambah Kandidat
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-12 order-1 order-lg-0 mb-3 mb-lg-0">
                <form id="form-candidate">
                    <input type="hidden" value="{{ @$candidate->id }}" name="id">
                    <div class="card card-step" id="step-1">
                        <div class="card-header">
                            <h3 class="card-title">Biodata</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-label">Foto</div>
                                <div class="custom-file">
                                    <input type="{{ @$candidate->id ? 'text' : 'file' }}" class="dropify" data-errors-position="outside" data-default-file="{{ @$candidate->photo ? asset('storage/'.@$candidate->photo) : '' }}"  value="{{ @$candidate->photo }}" name="photo" id="photo"/>
                                    @if(@$candidate->id) <input type="hidden" name="old_photo" id="old-photo" value="{{ @$candidate->photo }}"> @endif
                                </div>
                                <small id="hint-photo" class="form-hint">Harap gunakan format foto jpg|jpeg|png - ukuran file max 2mb</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Nama Lengkap</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Stepen Jondo" name="name" value="{{ @$candidate->name }}" id="name">
                                    <small id="hint-name" class="form-hint">Gunakan nama lengkap sesuai pada KTP</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button id="btn-next" type="button" class="btn btn-primary">Selanjutnya</button>
                        </div>
                    </div>
                    <div class="card card-step d-none" id="step-2">
                        <div class="card-header">
                            <h3 class="card-title">Visi dan Misi</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Visi</label>
                                <div>
                                    <div id="quill-vision" style="margin-bottom: .5rem !important;">
                                        <div id="editor-vision">
                                            {!! @$candidate->vision !!}
                                        </div>
                                    </div>
                                    <small class="form-hint">Jelaskan visi Anda secara singkat dan jelas. Visi harus mencerminkan tujuan dan aspirasi Anda sebagai calon.</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Misi</label>
                                <div>
                                    <div id="quill-mission" style="margin-bottom: .5rem !important;">
                                        <div id="editor-mission">
                                            {!! @$candidate->mission !!}
                                        </div>
                                    </div>
                                    <small class="form-hint">Detailkan misi Anda dengan langkah-langkah spesifik yang akan diambil untuk mencapai visi Anda. Sertakan rencana tindakan dan strategi.</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button id="btn-prev" type="button" class="btn btn-outline-primary">Sebelumnya</button>
                            <button id="btn-submit" type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    <div class="card card-step d-none" id="step-3">
                        <div class="card-body">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mb-2 text-green"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path><path d="M9 12l2 2l4 -4"></path></svg>
                                <div class="h4" id="candidate-success"></div>
                                <div>
                                    <a href="{{ route('candidate.form') }}" class="btn">Tambah Kandidat Lagi</a>
                                    <a href="{{ route('candidate.index') }}" class="btn btn-primary">Selesai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-12 order-0 order-lg-1 mb-3 mb-lg-0">
                <div class="card">
                    <div class="card-body">
                        <ul class="steps steps-counter steps-vertical">
                            <li class="step-item active">Biodata</li>
                            <li class="step-item">Visi dan Misi</li>
                            <li class="step-item">Selesai</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('apps.user.modal')
@endsection

@section('url')
    <input type="hidden" id="create-url" value="{{ route('candidate.create') }}">
    <input type="hidden" id="update-url" value="{{ route('candidate.update') }}">
@endsection

@section('script')
    <script src="{{ asset('assets') }}/dist/libs/dropzone/dist/dropzone-min.js?1692870487" defer></script>
    <script>
        const editorVision = new Quill('#editor-vision', {
            theme: 'snow'
        });

        const editorMission = new Quill('#editor-mission', {
            theme: 'snow'
        });

        editorMission.on('text-change', function() {
            $('#quill-mission').siblings('.invalid-feedback').remove();
            $('#quill-mission').removeClass('quill-has-error');
        });

        editorVision.on('text-change', function() {
            $('#quill-vision').siblings('.invalid-feedback').remove();
            $('#quill-vision').removeClass('quill-has-error');
        });
    </script>
    @vite(['resources/js/apps/candidate/candidate.js'])
@endsection
