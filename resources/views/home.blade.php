@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Beranda</h1>
        </div>
    </div>

    <div class="row">
        @if(Auth::user()->role === "admin")
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/beranda') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">Beranda</h5>
                    <i class="ion-home"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/karyawan') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Karyawan 
                        <span>({{ $totalData->karyawan }})</span>
                    </h5>
                    <i class="ion-person-stalker"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/pelanggan') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Pelanggan
                        <span>({{ $totalData->pelanggan }})</span>
                    </h5>
                    <i class="ion-person-stalker"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/kategorijasa') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Kategori Jasa
                        <span>({{ $totalData->kategorijasa }})</span>
                    </h5>
                    <i class="ion-gear-b"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/tugasteknisi') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Tugas Teknisi
                        <span>({{ $totalData->tugasteknisi }})</span>
                    </h5>
                    <i class="ion-clipboard"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/laporantugasteknisi') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">Laporan Tugas Teknisi</h5>
                    <i class="ion-ios-book"></i>
                </a>
            </div>
        @elseif(Auth::user()->role === "teknisi")
            <div class="col-md-4">
                <a href="{{ url('/beranda') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">Beranda</h5>
                    <i class="ion-home"></i>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ url('/daftartugas') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Daftar Tugas
                        <span>({{ $totalData->daftartugas }})</span>
                    </h5>
                    <i class="ion-clipboard"></i>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ url('/daftartugasselesai') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Tugas Selesai
                        <span>({{ $totalData->tugasselesai }})</span>
                    </h5>
                    <i class="ion-android-checkmark-circle"></i>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
