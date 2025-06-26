<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <!-- CSS files -->
    <link href="{{ asset('assets') }}/dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/demo.min.css?1692870487" rel="stylesheet"/>
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/yaza-putu/helpers@V2.0.4/libs/libs-core.min.css">--}}
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .loading-screen {
            position: fixed; /* Menjadikan elemen berada di atas elemen lain */
            top: 0;
            left: 0;
            width: 100%; /* Lebar penuh */
            height: 100%; /* Tinggi penuh */
            background-color: rgba(255, 255, 255, 0.9); /* Warna latar belakang dengan transparansi */
            z-index: 9999; /* Memastikan elemen berada di lapisan paling atas */
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class=" d-flex flex-column">
<script src="{{ asset('assets') }}/dist/js/demo-theme.min.js?1692870487"></script>
<div class="row g-0 flex-fill">
    <div class="col-12 col-lg-4 col-xl-6 d-none d-lg-block">
        <!-- Photo -->
        <div class="bg-cover h-100 min-vh-100"
             style="background-image: url('{{ asset('assets/frontend/images/konversipoltrada.JPG') }}')"></div>
    </div>
    <div class="col-12 col-lg-8 col-xl-6 border-top-wide border-primary d-flex flex-column justify-content-center">
        <div class="container container-narrow my-5 px-lg-5">
            <div class="text-center mb-4">
                <a href="{{ route('home.index') }}" class="navbar-brand navbar-brand-autodark"><h3>SwitchEV | Registrasi</h3></a>
            </div>
            <form id="form-register">
                <div class="row">
                    <label class="form-label">Data Diri dan Berkas</label>
                    <div class="col-lg-12 col-12">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Nama Lengkap" autocomplete="off" name="name">
                            <small class="form-hint">
                                Nama lengkap anda
                            </small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Lampiran No. Induk Berusaha</label>
                            <input type="file" class="form-control" placeholder="Lampiran No. Induk Berusaha"
                                   name="no_induk_berusaha">
                            <small class="form-hint">
                                Lampiran No. Induk Berusaha, file pdf
                            </small>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Lampiran Foto Fisik Bengkel</label>
                            <input type="file" class="form-control" placeholder="Foto Fisik Bengkel" name="foto_fisik">
                            <small class="form-hint">
                                Foto fisik bengkel, file jpg
                            </small>
                        </div>
                    </div>
                </div>
                <label class="form-label">Kredensial</label>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" placeholder="alamatemail@mail.com" name="email">
                    <small class="form-hint">
                        Alamat email anda
                    </small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <small class="form-hint">
                        Password akun anda
                    </small>
                </div>
                <div class="form-footer">
                    <button id="btn-register" type="submit" class="btn btn-primary w-100">Daftar</button>
                </div>
            </form>
            <div class="text-center text-secondary mt-3">
                Sudah memiliki akun? <a href="{{ route('login') }}" tabindex="-1">Login</a>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="{{ route('register.submit') }}" id="register-url">
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="{{ asset('assets') }}/dist/js/tabler.min.js?1692870487" defer></script>
<script src="{{ asset('assets') }}/dist/js/demo.min.js?1692870487" defer></script>
@vite(['resources/js/app.js'])
@vite(['resources/js/apps/auth/register.js'])
</body>
</html>
