@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Laporan Tugas Teknisi</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h5 class="mb-0">Laporan Tugas Teknisi</h5>
                    </div> --}}
                    <div class="card-body">
                        <div class="d-flex justify-content-center justify-content-md-start mb-3">
                            <a href="{{ route('exportPDF.laporanTugasTeknisi') }}" class="btn btn-primary btn-sm">
                                <i class="ion-book"></i>
                                Cetak Laporan
                            </a>
                        </div>
                        <div class="table-responsive p-1">
                            <table id="laporanTugasTeknisiTable" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat Pelanggan</th>
                                        <th>No Telp Pelanggan</th>
                                        <th>Kategori Jasa</th>
                                        <th>Detail Tugas</th>
                                        <th>Teknisi</th>
                                        <th>Dimulai Pada</th>
                                        <th>Diselesaikan Pada</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('headLink')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap5.min.css') }}">

    @include('sweet::alert')
@endsection

@section('bodyScripts')
    <!-- DataTables -->
    <script src=" {{ asset('js/jquery.dataTables.min.js') }} "></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }} "></script>

    <!-- Validator -->
    <script src="{{ asset('js/validator.min.js') }}"></script>

    <script type="text/javascript">
        var table = $('#laporanTugasTeknisiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.laporantugasteknisi') }}",
            columns: [
                { 
                    'data': null,
                    'sortable': false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'nama_pelanggan', name: 'nama_pelanggan'},
                {data: 'alamat_pelanggan', name: 'alamat_pelanggan'},
                {data: 'no_telp_pelanggan', name: 'no_telp_pelanggan'},
                {data: 'nama_kategori_jasa', name: 'nama_kategori_jasa'},
                {data: 'detail', name: 'detail'},
                {data: 'nama_karyawan', name: 'nama_karyawan'},
                {data: 'mulai_info', name: 'mulai_info'},
                {data: 'selesai_info', name: 'selesai_info'},
                {data: 'status_info', name: 'status_info', orderable: false, searchable: false},
            ],
        });
    </script>
@endsection