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
                <h1>E-Voting</h1>
            </a>
        </div>
        <div class="alert-container"></div>
        <div class="card card-md">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Login</h2>
                <form id="form-login">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control" placeholder="your@email.com" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Password
                            <span class="form-label-description">
                  </span>
                        </label>
                        <input id="password" type="password" class="form-control"  placeholder="Your password"  autocomplete="off" name="password">
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input id="remember" name="remember" type="checkbox" class="form-check-input"/>
                            <span class="form-check-label">Ingat saya di perangkat ini</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button id="btn-login" type="submit" class="btn btn-primary w-100">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
{{--        <div class="text-center text-secondary mt-3">--}}
{{--            Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>--}}
{{--        </div>--}}
    </div>
</div>
<input type="hidden" value="{{ route('login') }}" id="login-url">
<!-- Libs JS -->
<!-- Tabler Core -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="{{ asset('assets') }}/dist/js/tabler.min.js?1692870487" defer></script>
<script src="{{ asset('assets') }}/dist/js/demo.min.js?1692870487" defer></script>
@vite(['resources/js/app.js'])
@vite(['resources/js/apps/auth/login.js'])
</body>
</html>
