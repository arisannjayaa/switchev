@if($test_letters->count() == 0)
    <div class="d-flex justify-content-center align-items-center text-center flex-column">
        <div class="bg-primary-lt w-100 p-7 rounded-3 mb-3">
            <img class="img-fluid" width="400" src="{{ asset('assets/dist/img/undraw_hello_ccwj.svg') }}">
        </div>
        <div class="text-center">
            <h1 class="fw-bold">Selamat Datang di Penerbitan Surat SUT dan SRUT</h1>
            <p class="text-muted">Silahkan mulai mengisi form di bawah ini</p>
            <a href="{{ route('test.letter.form') }}" class="btn btn-primary">Mulai</a>
        </div>
    </div>
@else
    <div>
        <div class="d-flex justify-content-end mb-3">
            <div>
                <a href="{{ route('test.letter.form') }}" class="btn btn-outline-primary">Ajukan Penerbitan Lainnya</a>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <form action="./" method="get" autocomplete="off" novalidate="" class="sticky-top">
                    <div class="form-label">Tipe Identitas Bengkel</div>
                    <div class="mb-4">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="form-type[]" value="1" checked="">
                            <span class="form-check-label">A</span>
                        </label>
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="form-type[]" value="2" checked="">
                            <span class="form-check-label">B</span>
                        </label>
                    </div>
                    <div class="mt-5">
                        <button class="btn btn-primary w-100">Konfirmasi Perubahan</button>
                        <a href="#" class="btn btn-link w-100"> Reset </a>
                    </div>
                </form>
            </div>
            <div class="col-md-9">
                @foreach($test_letters as $test_letter)
                    <div class="row row-cards mb-3">
                        <div class="space-y">
                            <div class="card">
                                <div class="row g-0">
                                    <div class="col">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col">
                                                    <h3 class="mb-0"><a href="#">{{ $test_letter->code }}</a></h3>
                                                </div>
                                                <div class="col">
                                                    <div class="float-end">
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm rounded-4 align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end" style="">
                                                                <a class="dropdown-item" href="{{ route('test.letter.show', \App\Helpers\Helper::encrypt($test_letter->id)) }}') }}"> Lihat </a>
                                                                @if($test_letter->is_verified) <a data-id="{{ $test_letter->id }}" class="dropdown-item modal-pyhsical-test" href="#"> Upload Hasil Uji Fisik </a> @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="mt-3 list-inline list-inline-dots mb-0 text-secondary d-sm-block d-none">
                                                        <div class="list-inline-item">
                                                            <!-- Download SVG icon from http://tabler.io/icons/icon/building-community -->
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-square-rounded"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                                                            {{ $test_letter->status }}
                                                        </div>
                                                    </div>
                                                    <div class="mt-3 list mb-0 text-secondary d-block d-sm-none">
                                                        <div class="list-item">
                                                            <!-- Download SVG icon from http://tabler.io/icons/icon/building-community -->
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-alert-square-rounded"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
                                                            Menunggu Konfirmasi Admin
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-auto">
                                                    <div class="mt-3 badges">
                                                        <a href="#" class="badge badge-outline text-secondary fw-normal badge-pill">Tipe {{ $test_letter->type }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $test_letters->links() }}
    </div>
    @include('apps.test-letter.test-physical-modal')
@endif
