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
<body  class=" d-flex flex-column">
<script src="{{ asset('assets') }}/dist/js/demo-theme.min.js?1692870487"></script>
<div class="page page-center">
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="." class="navbar-brand navbar-brand-autodark">
                <h1>SwitchEV</h1>
            </a>
        </div>
        <div class="alert-container"></div>
        <form id="form-register" class="card card-md" action="./" method="get" autocomplete="off" novalidate>
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Buat Akun Baru</h2>
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" placeholder="Nama" name="name">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" placeholder="Email" name="email">
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" placeholder="Email" name="password">
                </div>
                <div class="form-footer">
                    <button id="btn-register" type="submit" class="btn btn-primary w-100">Daftar</button>
                </div>
            </div>
        </form>
        <div class="text-center text-secondary mt-3">
            Sudah memiliki akun? <a href="{{ route('login') }}" tabindex="-1">Login</a>
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
