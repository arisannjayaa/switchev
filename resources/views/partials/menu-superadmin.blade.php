<li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('user.index') }}">
      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
      </span>
        <span class="nav-link-title">
            User
        </span>
    </a>
</li>
<li class="nav-item {{ request()->is('certificate*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('certificate.index') }}">
      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
             stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path
                d="M9 11l3 3l8 -8"/><path
                d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"/></svg>
      </span>
        <span class="nav-link-title">
            Permohonan Sertifikasi Konversi
        </span>
    </a>
</li>
