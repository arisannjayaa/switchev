@extends('theme.panel')

@section('title', 'Kandidat')

@section('style')
@endsection

@section('content')
    <div class="container">
        <div class="page-header d-print-none mb-3">
            <div>
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Kandidat
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <a href="{{ route('candidate.form') }}" class="btn btn-primary">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                            Tambah Kandidat
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if(count($candidates) == 0)
                <div class="col-12 text-center">
                    <img class="img-fluid mt-5 mb-3" style="border: 1px dashed #dee2e6; padding: 20px;" width="300" src="{{ asset('assets/dist/img/undraw_no_data_re_kwbl.svg') }}" alt="">
                    <p>Belum ada kandidat</p>
                </div>
            @else
                @foreach($candidates as $candidate)
                    <div class="col-lg-3 mb-3">
                        <div class="card">
                            <div class="card-body p-4 text-center">
                                <img src="{{ asset('storage/'.$candidate->photo) }}" alt="" width="200" height="200" style="background-size: cover;" class="rounded-3 mb-3">
                                <h3 class="m-0 mb-1"><a href="javascript:void(0)">{{ $candidate->name }}</a></h3>
                            </div>
                            <div class="d-flex">
                                <a href="{{ route('candidate.edit', ['id' => $candidate->id]) }}" class="card-btn"><!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                    Edit</a>
                                <a href="javascript:void(0)" class="card-btn delete" data-id="{{ $candidate->id }}"><!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="mt-3">
                    {{ $candidates->links() }}
                </div>
            @endif
        </div>
    </div>
    @include('apps.user.modal')
@endsection

@section('url')
    <input type="hidden" id="delete-url" value="{{ route('candidate.delete') }}">
@endsection

@section('script')
    @vite(['resources/js/apps/candidate/candidate.js'])
@endsection
