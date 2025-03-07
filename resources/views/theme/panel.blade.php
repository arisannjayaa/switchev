<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- CSS files -->
    @include('partials.style')
    @yield('style')
</head>
<body >
<script src="{{ asset('assets') }}/dist/js/demo-theme.min.js?1692870487"></script>
<div class="page d-none">
    <!-- Sidebar -->
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
        @include('partials.aside')
    </aside>
    <!-- Navbar -->
    <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none" >
        @include('partials.header')
    </header>
    <div class="page-wrapper">

        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
                @yield('content')
            </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
            <div class="container-xl">
                <div class="row text-center align-items-center flex-row-reverse">
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                        <ul class="list-inline list-inline-dots mb-0">
                            <li class="list-inline-item">
                                Copyright &copy; 2023
                                <a href="" class="link-secondary"></a>.
                                All rights reserved.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<input type="hidden" id="asset-url" value="{{ asset('') }}">
@yield('url')
@include('partials.script')
@yield('script')
@vite(['resources/js/app.js'])
</body>
</html>
