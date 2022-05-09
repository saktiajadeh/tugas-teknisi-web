@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Beranda</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-lg-4">
            <a href="{{ url('/home') }}" class="card main-menu mb-3">
                <h5 class="mb-0">Beranda</h5>
                <i class="ion-home"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="#" class="card main-menu mb-3">
                <h5 class="mb-0">Karyawan</h5>
                <i class="ion-person-stalker"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="{{ url('/pelanggan') }}" class="card main-menu mb-3">
                <h5 class="mb-0">Pelanggan</h5>
                <i class="ion-person-stalker"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="#" class="card main-menu mb-3">
                <h5 class="mb-0">Kategori Jasa</h5>
                <i class="ion-gear-b"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="#" class="card main-menu mb-3">
                <h5 class="mb-0">Tugas Teknisi</h5>
                <i class="ion-clipboard"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="#" class="card main-menu mb-3">
                <h5 class="mb-0">Laporan Tugas</h5>
                <i class="ion-ios-book"></i>
            </a>
        </div>
    </div>
</div>
@endsection
