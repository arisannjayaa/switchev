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

        .step-item.active:before {
            background-color: #fff !important;
            border: 2px solid #0054a6 !important;
            color: #0054a6 !important;
        }

        .alert-info {
            background-color: #fff !important;
            border: 1px solid #0054a6 !important;
            color: #0054a6 !important;
        }

        .alert-success {
            background-color: #fff !important;
            border: 1px solid #2fb344 !important;
            color: #2fb344 !important;
        }

        .ql-container {
            height: 200px !important;
            border-radius: 0 0 8px 8px !important;
        }
        .ql-toolbar.ql-snow {
            border-radius: 8px 8px 0 0 !important;
        }
    </style>
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2>Proses Sertifikasi Verifikasi</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-12">
                @if($conversion->step == 0)
                    <div class="d-flex justify-content-center align-items-center text-center flex-column">
                        <img width="300" src="{{ asset('assets/dist/img/undraw_cancel_7zdh.svg') }}" alt="">
                        <h1 class="mt-4">{{ \App\Helpers\Helper::check_status_conversion($conversion->status) }}</h1>
                        <p class="text-secondary">Tunggu pendaftar untuk melakukan perbaikan data</p>
                    </div>
                @endif
                @if($conversion->step == 1)
                    <div class="step-1">
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
                </div>
                @endif
                @if($conversion->step == 2)
                    <div class="step-2">
                        <div class="alert alert-important alert-info" role="alert">
                            <div class="d-flex">
                                <div class="alert-icon">
                                    <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M12 8v4"></path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="alert-heading">Instruksi Verifikasi Berkas via Zoom</h4>
                                    <div class="alert-description">
                                        <p>Admin, berikut adalah langkah-langkah yang perlu Anda ikuti untuk melakukan verifikasi berkas peserta melalui Zoom. Pastikan berkas yang dikirimkan telah lengkap dan sesuai dengan ketentuan yang berlaku sebelum verifikasi dilakukan.</p>
                                        <ul class="alert-list">
                                            <li><strong>Periksa apakah dokumen yang dikirimkan jelas dan terbaca dengan baik.</strong></li>
                                            <li><strong>Pastikan format file berkas sesuai dengan ketentuan yang telah ditetapkan (PDF, JPG, atau format lain yang sesuai).</strong></li>
                                            <li><strong>Verifikasi bahwa seluruh informasi penting yang diminta tercantum dengan lengkap dalam berkas.</strong></li>
                                        </ul>
                                        <p>Verifikasi ini bertujuan untuk memastikan bahwa berkas yang dikirimkan sudah sesuai dengan ketentuan yang berlaku. Anda akan dihubungi untuk menjadwalkan sesi verifikasi Zoom dengan peserta jika semua berkas sudah lengkap dan sesuai.</p>
                                        <p>Pastikan semua informasi yang dikirimkan sesuai dan tidak ada dokumen yang terlewat agar proses verifikasi berjalan lancar.</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Verifikasi Zoom</h3>
                            </div>
                            <div class="card-body">
                                @if($conversion->zoom_mail_attempt > 0)
                                <div class="alert alert-important alert-info" role="alert">
                                    <div class="d-flex">
                                        <div class="alert-icon">
                                            <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                                <path d="M12 8v4"></path>
                                                <path d="M12 16h.01"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="alert-heading h4">Info</span>
                                            <div class="alert-description">
                                                <span>Anda sudah pernah mengirimkan email sebelumnya sebanyak {{ $conversion->zoom_mail_attempt . " kali" }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- Create the editor container -->
                                <div id="editor">
                                    <p><strong>Topik:</strong> Rapat Zoom untuk Diskusi Proyek</p>
                                    <p><strong>Waktu:</strong> 10 Maret 2025, 09:00 WIB</p>
                                    <p><strong>Detail Rapat:</strong> Diskusi terkait perkembangan proyek terbaru.</p>

                                    <p><strong>Link Zoom:</strong> <a href="https://zoom.us/j/1234567890">https://zoom.us/j/1234567890</a></p>

                                    <p>Jika Anda memiliki pertanyaan, silakan hubungi kami.</p>

                                    <p>Terima kasih,</p>
                                    <p><strong>Tim Proyek</strong></p>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button id="btn-send-mail-zoom" type="submit" class="btn btn-primary">Kirim Email</button>
                            </div>
                        </div>
                    </div>
                @endif
                @if($conversion->step == 3)
                    <div class="alert alert-important alert-info" role="alert">
                        <div class="d-flex">
                            <div class="alert-icon">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                    <path d="M12 8v4"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-heading">Instruksi Verifikasi Lapangan</h4>
                                <div class="alert-description">
                                    <p>Admin, berikut adalah langkah-langkah yang perlu Anda ikuti untuk melakukan verifikasi lapangan guna memastikan keakuratan data yang telah dikirimkan oleh peserta. Proses ini sangat penting untuk memastikan bahwa informasi yang diberikan sesuai dengan kondisi yang ada di lapangan.</p>
                                    <ul class="alert-list">
                                        <li><strong>Verifikasi lapangan dilakukan di lokasi yang telah ditentukan sesuai dengan jadwal yang disepakati.</strong></li>
                                        <li><strong>Pastikan untuk memeriksa kesesuaian antara data yang dikirimkan dengan kondisi di lapangan.</strong></li>
                                        <li><strong>Jika terdapat ketidaksesuaian atau pertanyaan terkait data, harap segera menghubungi peserta untuk klarifikasi lebih lanjut.</strong></li>
                                        <li><strong>Dokumentasikan hasil verifikasi lapangan secara lengkap dan pastikan semua informasi yang relevan tercatat dengan baik.</strong></li>
                                    </ul>
                                    <p>Jika Anda memerlukan bantuan lebih lanjut atau memiliki pertanyaan mengenai prosedur verifikasi lapangan, harap hubungi tim administrasi untuk mendapatkan dukungan tambahan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Verifikasi Lapangan</h3>
                            </div>
                            <div class="card-body">
                                @if($conversion->field_mail_attempt > 0)
                                    <div class="alert alert-important alert-info" role="alert">
                                        <div class="d-flex">
                                            <div class="alert-icon">
                                                <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                                    <path d="M12 8v4"></path>
                                                    <path d="M12 16h.01"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="alert-heading">Info</h4>
                                                <div class="alert-description">
                                                    <span>Anda sudah pernah mengirimkan email sebelumnya sebanyak {{ $conversion->zoom_mail_attempt . " kali" }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- Create the editor container -->
                                <div id="editor">
                                    <h3><strong>Verifikasi Tempat dan Waktu Pelaksanaan</strong></h3>
                                    <p>Untuk memastikan kelancaran pelaksanaan, harap perhatikan detail berikut terkait tempat dan waktu pelaksanaan kegiatan:</p>

                                    <h5><strong>1. Tempat Pelaksanaan</strong></h5>
                                    <p>Pelaksanaan kegiatan ini akan berlangsung di lokasi yang telah ditentukan. Pastikan Anda datang tepat waktu dan mempersiapkan segala sesuatunya sesuai dengan lokasi yang telah diinformasikan. Lokasi kegiatan adalah:</p>
                                    <ul>
                                        <li><strong>Alamat:</strong> <em>Jalan Raya No. 10, Gedung ABC, Lantai 5</em></li>
                                        <li><strong>Tempat:</strong> <em>Ruang Serbaguna, Gedung ABC</em></li>
                                    </ul>
                                    <p>Harap pastikan Anda mengetahui dengan jelas lokasi kegiatan untuk menghindari kebingungan pada hari H. Anda dapat mencari informasi lebih lanjut tentang lokasi melalui <a href="https://www.google.com/maps" target="_blank">Google Maps</a>.</p>

                                    <h5><strong>2. Waktu Pelaksanaan</strong></h5>
                                    <p>Pelaksanaan kegiatan akan dimulai pada:</p>
                                    <ul>
                                        <li><strong>Tanggal:</strong> <em>Senin, 15 Maret 2025</em></li>
                                        <li><strong>Waktu:</strong> <em>09.00 - 12.00 WIB</em></li>
                                    </ul>
                                    <p>Pastikan Anda hadir tepat waktu untuk mengikuti seluruh rangkaian acara yang telah disiapkan. Kami sangat menghargai ketepatan waktu demi kelancaran acara.</p>

                                    <h5><strong>3. Konfirmasi Kehadiran</strong></h5>
                                    <p>Untuk memastikan kehadiran Anda, harap konfirmasi terlebih dahulu melalui <strong>link pendaftaran</strong> yang telah kami kirimkan. Kehadiran Anda akan sangat berpengaruh pada kelancaran acara ini.</p>

                                    <blockquote>
                                        <p><em>“Keberhasilan acara bergantung pada partisipasi dan keterlibatan aktif semua peserta. Mari kita sukseskan acara ini bersama-sama!”</em></p>
                                    </blockquote>

                                    <p>Jika Anda memiliki pertanyaan lebih lanjut atau membutuhkan bantuan terkait tempat dan waktu, jangan ragu untuk menghubungi kami di <strong>email@example.com</strong> atau <strong>+62 812 3456 7890</strong>.</p>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button id="btn-send-mail-zoom" type="submit" class="btn btn-primary">Kirim Email</button>
                            </div>
                        </div>
                @endif
                @if($conversion->step == 4)
                    <div class="alert alert-important alert-info" role="alert">
                        <div class="d-flex">
                            <div class="alert-icon">
                                <!-- Download SVG icon from http://tabler.io/icons/icon/alert-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2">
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                    <path d="M12 8v4"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="alert-heading">Selesaikan Proses Verifikasi</h4>
                                <div class="alert-description">
                                    <p>Admin, untuk menyelesaikan tahapan verifikasi, tekan tombol "Selesai". Pastikan semua verifikasi dan data telah diperiksa dengan baik.</p>
                                    <p>Jika sudah, tekan tombol "Selesai" untuk melanjutkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if($conversion->step == 5)
                    <div class="d-flex justify-content-center align-items-center text-center flex-column">
                        <img width="300" src="{{ asset('assets/dist/img/undraw_completing_gsf8.svg') }}" alt="">
                        <h1 class="mt-4">{{ \App\Helpers\Helper::check_status_conversion($conversion->status) }}</h1>
                        <p class="text-secondary">Semua verifikasi telah selesai</p>
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="steps steps-counter steps-vertical">
                            <li class="step-item {{ $conversion->step == 0 ? 'active' : '' }}">
                                <div>Upload Berkas</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 1 ? 'active' : '' }}">
                                <div>Verifikasi Data Upload</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 2 ? 'active' : '' }}">
                                <div>Verifikasi Zoom</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 3 ? 'active' : '' }}">
                                <div>Verifikasi Lapangan</div>
                            </li>
                            <li class="step-item {{ $conversion->step == 4 ? 'active' : '' }}">
                                <div>Selesai</div>
                            </li>
                        </ul>
                    </div>
                    @if($conversion->step != 0 && $conversion->step != 5)
                    <div class="card-footer">
                        <div class="d-flex flex-column gap-2">
                            @if($conversion->step != 4) <button id="btn-reject" type="submit" class="btn btn-danger">Batalkan</button> @endif
                            <button id="btn-approve" type="submit" class="btn btn-primary">{{ $conversion->step == 4 ? 'Selesai' : 'Verifikasi' }}</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('apps.conversion.reject-modal')
@endsection

@section('url')
    <input type="hidden" id="step" value="{{ $conversion->step }}">
    <input type="hidden" id="id" value="{{ $conversion->id }}">
    <input type="hidden" id="table-url" value="{{ route('conversion.table') }}">
    <input type="hidden" id="mail-zoom-url" value="{{ route('conversion.send-mail-zoom') }}">
    <input type="hidden" id="approve-url" value="{{ route('conversion.approve') }}">
    <input type="hidden" id="reject-url" value="{{ route('conversion.reject') }}">
    <input type="hidden" id="edit-url" value="{{ route('conversion.show', ['id' => ':id']) }}">
@endsection

@section('script')
    @vite(['resources/js/apps/conversion/conversion.js'])
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    <!-- Initialize Quill editor -->
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });

    </script>
@endsection
