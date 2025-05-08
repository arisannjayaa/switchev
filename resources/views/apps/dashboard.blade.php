@extends('theme.panel')

@section('title', 'Dashboard')

@section('style')

@endsection

@section('content')
<div>
    <div class="page-header mb-3">
        <div class="row align-items-center mw-100">
            <div class="col">
                <div class="mb-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">
                            <a href="#">Dashboard</a>
                        </li>
                    </ol>
                </div>
                <h2 class="page-title">
        <span class="text-truncate"
        >Dashboard</span
        >
                </h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex align-items-end gap-3">
                                @php
                                    $firstName = explode(' ', auth()->user()->name)[0];
                                    if (strlen($firstName) == 1) {
                                        $result = substr($firstName, 0, 1);
                                    } else {
                                        $result = substr($firstName, 0, 2);
                                    }
                                @endphp
                                <span class="avatar avatar-xl mb-3 rounded">{{ $result }}</span>
                                <div>
                                    <span class="fs4-4">Selamat Datang,</span>
                                    <h1 class="fs-1">{{ auth()->user()->name }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex align-items-center gap-2 justify-content-end">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="48"  height="48"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-rosette-discount-check text-primary" style="width: 30px; height: 30px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z" /></svg>
                                <span>{{ ucfirst(auth()->user()->status) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('url')

@endsection

@section('script')

@endsection
