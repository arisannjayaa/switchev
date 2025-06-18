@extends('theme.home')

@section('title', 'Beranda')

@section('style')

@endsection

@section('content')
    <div>
        <div class="hero-wrap ftco-degree-bg" style="background-image: url('{{ asset('assets/frontend/images/engineer-does-checkup-client-car-compressed.jpg') }}');" data-stellar-background-ratio="0.5">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
                    <div class="col-lg-8 ftco-animate">
                        <div class="text w-100 text-center mb-md-5 pb-md-5">
                            <h1 class="mb-4">Test</h1>
                            <p style="font-size: 18px;">Jadikan bengkel Anda pionir dalam konversi kendaraan listrik! Switch EV hadir untuk mendukung bengkel dalam mengadopsi teknologi ramah lingkungan dengan solusi konversi yang efisien, terpercaya, dan inovatif. Saatnya beralih ke masa depan yang lebih hijau!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="ftco-section ftco-about">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{ asset('assets/frontend') }}/images/about.jpg);">
                    </div>
                    <div class="col-md-6 wrap-about ftco-animate">
                        <div class="heading-section heading-section-white pl-md-5">
                            <span class="subheading">Tentang Kami</span>
                            <h2 class="mb-4">Selamat datang di Switch EV</h2>
                            <p>Switch EV hadir sebagai solusi bagi bengkel yang ingin bertransformasi ke era kendaraan listrik. Kami percaya bahwa konversi EV bukan hanya tren, tetapi langkah nyata menuju masa depan transportasi yang lebih ramah lingkungan dan efisien.</p>
                            <p>Dengan dukungan teknologi terkini dan jaringan profesional di bidang otomotif, Switch EV membantu bengkel dalam mengadopsi sistem konversi kendaraan listrik melalui pelatihan, teknologi, dan akses ke komponen berkualitas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-7 text-center heading-section ftco-animate">
                        <span class="subheading">Layanan</span>
                        <h2 class="mb-3">Layanan Terbaru Kami</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="services services-2 w-100 text-center">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-wedding-car"></span></div>
                            <div class="text w-100">
                                <h3 class="heading mb-2">Sertifikasi Bengkel Konversi </h3>
                                <p>Jadikan bengkel Anda resmi dan terpercaya dalam konversi kendaraan listrik dengan sertifikasi standar nasional!.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="services services-2 w-100 text-center">
                            <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-transportation"></span></div>
                            <div class="text w-100">
                                <h3 class="heading mb-2">Penerbitan SUT & SRUT</h3>
                                <p>Pastikan setiap kendaraan listrik hasil konversi legal di jalan dengan SUT & SRUT dari bengkel bersertifikasi!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('url')

@endsection

@section('script')

@endsection
