<li class="nav-item {{ request()->is('hasil-uji*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('testing.index') }}">
      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
             stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
             stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path
                d="M9 11l3 3l8 -8"/><path
                d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9"/></svg>
      </span>
        <span class="nav-link-title">
            Nilai Hasil Uji
        </span>
    </a>
</li>

<li class="nav-item {{ request()->is('resume-hasil-uji*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('resume.index') }}">
      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="icon icon-tabler icons-tabler-outline icon-tabler-script"><path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none"/><path
                d="M17 20h-11a3 3 0 0 1 0 -6h11a3 3 0 0 0 0 6h1a3 3 0 0 0 3 -3v-11a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v8"/></svg>
      </span>
        <span class="nav-link-title">
            Resume Hasil Uji
        </span>
    </a>
</li>

