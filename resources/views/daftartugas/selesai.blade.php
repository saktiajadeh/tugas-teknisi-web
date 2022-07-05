@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Daftar Tugas Selesai</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h5 class="mb-0">Daftar Tugas Selesai</h5>
                    </div> --}}
                    <div class="card-body">
                        <div class="d-flex flex-wrap flex-column flex-md-row align-items-center">
                            <div class="form-group mb-2 me-2">
                                <select id="filter_pelanggan" name="filter_pelanggan" class="form-control select" style="min-width: 190px; max-width: 200px;">
                                    <option value=" ">-- Filter Pelanggan --</option>
                                    @foreach($pelanggan as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }} - {{ $data->alamat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2 me-2">
                                <select id="filter_kategorijasa" name="filter_kategorijasa" class="form-control select" style="min-width: 190px; max-width: 200px;">
                                    <option value=" ">-- Filter Kategori --</option>
                                    @foreach($kategorijasa as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="table-responsive p-1">
                            <table id="daftarTugasSelesai" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat Pelanggan</th>
                                        <th>No Telp Pelanggan</th>
                                        <th>Kategori Jasa</th>
                                        <th>Detail Tugas</th>
                                        <th>Dimulai Pada</th>
                                        <th>Diselesaikan Pada</th>
                                        <th>Foto Mulai</th>
                                        <th>Foto Selesai</th>
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
        function fetchData(filter_pelanggan = "", filter_kategorijasa = ""){
            var table = $('#daftarTugasSelesai').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('api.daftartugasselesai') }}",
                    data: {
                        filter_pelanggan: filter_pelanggan,
                        filter_kategorijasa: filter_kategorijasa,
                    }
                },
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
                    {data: 'mulai_info', name: 'mulai_info'},
                    {data: 'selesai_info', name: 'selesai_info'},
                    {data: 'show_foto_mulai', name: 'show_foto_mulai', orderable: false, searchable: false},
                    {data: 'show_foto_selesai', name: 'show_foto_selesai', orderable: false, searchable: false},
                    {data: 'status_info', name: 'status_info', orderable: false, searchable: false},
                ],
            });
        }

        $('select').on('change', function (e) {
            var filter_pelanggan = $('#filter_pelanggan').val();
            var filter_kategorijasa = $('#filter_kategorijasa').val();

            fetchData(filter_pelanggan, filter_kategorijasa);
        });

        fetchData();
    </script>
@endsection