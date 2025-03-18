<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/animate.css">

    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/magnific-popup.css">

    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/aos.css">

    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/jquery.timepicker.css">


    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/flaticon.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/icomoon.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/style.css">
    <style>
        .btn.btn-primary {
            background: #01d28e !important;
            border: 1px solid #01d28e !important;
            color: #fff !important;
    </style>
    @yield('css')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="index.html">Switch<span>EV</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}"><a href="index.html" class="nav-link">Beranda</a></li>
                <li class="nav-item {{ request()->is('/sertifikasi-bengkel-konversi') ? 'active' : '' }}"><a href="{{ route('conversion.index') }}" class="nav-link">Sertifikasi Bengkel Konversi</a></li>
                <li class="nav-item {{ request()->is('/penerbitan-sut-dan-srut') ? 'active' : '' }}"><a href="#" class="nav-link">Penerbitan SUT dan SRUT</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @auth
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="btn btn-primary" style="border-radius: 10px">Dashboard</a></li>
                @endauth
                @guest
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-primary" style="border-radius: 10px">Login</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- END nav -->



@yield('content')


<footer class="ftco-footer ftco-bg-dark ftco-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2"><a href="#" class="logo">Switch<span>EV</span></a></h2>
                    <p>Switch EV siap menjadikan bengkel Anda pionir dalam konversi kendaraan listrik dengan teknologi ramah lingkungan, efisien, dan inovatif—saatnya melaju ke masa depan yang lebih hijau.</p>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4 ml-md-5">
                    <h2 class="ftco-heading-2">Informasi</h2>
                    <ul class="list-unstyled">
                        <li><a href="#" class="py-2 d-block">Sertifikasi Bengkel Konversi</a></li>
                        <li><a href="#" class="py-2 d-block">Penerbitan SUT dan SRUT</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Punya pertanyaan?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><a href="mailto:switchev21@gmail"><span class="icon icon-envelope"></span><span class="text">switchev21@gmail.com</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>

@yield('script')
<script src="{{ asset('assets/frontend') }}/js/jquery.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery-migrate-3.0.1.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/popper.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.easing.1.3.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.waypoints.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.stellar.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/owl.carousel.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/aos.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.animateNumber.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/bootstrap-datepicker.js"></script>
<script src="{{ asset('assets/frontend') }}/js/jquery.timepicker.min.js"></script>
<script src="{{ asset('assets/frontend') }}/js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="{{ asset('assets/frontend') }}/js/google-map.js"></script>
<script src="{{ asset('assets/frontend') }}/js/main.js"></script>

</body>
</html>
