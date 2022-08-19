@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Data Statistik Tugas Teknisi</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h5 class="mb-0">Data Tugas Teknisi</h5>
                    </div> --}}
                    <div class="card-body">
                        <div class="d-flex justify-content-center justify-content-md-start mb-3">
                            <a onclick="exportPDFLaporan()" class="btn btn-primary btn-sm">
                                <i class="ion-ios-book me-1"></i>
                                Cetak Laporan Statistik Tugas Teknisi
                            </a>
                        </div>
                        <div id="filter_wrapper" class="d-flex flex-wrap align-items-end justify-content-center justify-content-md-start">
                            <div class="form-group mb-2 me-2">
                                <label for="" class="form-label mb-0">Filter Teknisi</label>
                                <select id="filter_teknisi" name="filter_teknisi" class="form-control select" style="width: 155px;">
                                    <option value=" ">No Filter</option>
                                    @foreach($teknisi as $id=>$value)
                                        <option value="{{ $id }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex flex-wrap justify-content-center">                            
                                <div class="form-group me-2 mb-2">
                                    <label for="" class="form-label mb-0">Dari</label>
                                    <input id="tanggal_mulai" name="tanggal_mulai" type="date" class="form-control" style="width: 155px;"/>
                                </div>
                                <div class="form-group me-2 mb-2">
                                    <label for="" class="form-label mb-0">Sampai</label>
                                    <input id="tanggal_selesai" name="tanggal_selesai" type="date" class="form-control" style="width: 155px;"/>
                                </div>
                            </div>
                            <button onclick="applyfilter()" class="btn btn-primary mb-2">Apply Filter</button>
                        </div>
                        <div class="table-responsive p-1">
                            <table id="tugasTeknisiTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nama Teknisi</th>
                                        <th>No Telp</th>
                                        <th>Belum Dikerjakan</th>
                                        <th>Sedang Dikerjakan</th>
                                        <th>Selesai Dikerjakan</th>
                                        <th>Total Tugas</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        @include('tugasteknisi.statistikdetail')
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
        function fetchData(filter_teknisi ="", tanggal_mulai = "", tanggal_selesai = ""){
            if(tanggal_mulai != "" && tanggal_selesai != ""){
                var date1 = new Date(tanggal_mulai);
                var date2 = new Date(tanggal_selesai);
                if(date1 > date2){
                    swal({
                        title: 'Oops...',
                        text: 'Input Tanggal Tidak Valid',
                        type: 'error',
                        timer: '3000'
                    });
                    return null;
                }
            }
            var table = $('#tugasTeknisiTable').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('api.statistiktugasteknisi') }}",
                    data: {
                        filter_teknisi: filter_teknisi,
                        tanggal_mulai: tanggal_mulai,
                        tanggal_selesai: tanggal_selesai,
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
                    {data: 'name', name: 'name'},
                    {data: 'no_telp', name: 'no_telp'},
                    {data: 'tugas_nostatus', name: 'tugas_nostatus'},
                    {data: 'tugas_progress', name: 'tugas_progress'},
                    {data: 'tugas_selesai', name: 'tugas_selesai'},
                    {data: 'total_tugas', name: 'total_tugas'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        }

        function fetchDataDetail(filter_teknisi ="", filter_status = "", tanggal_mulai = "", tanggal_selesai = ""){
            if(tanggal_mulai != "" && tanggal_selesai != ""){
                var date1 = new Date(tanggal_mulai);
                var date2 = new Date(tanggal_selesai);
                if(date1 > date2){
                    swal({
                        title: 'Oops...',
                        text: 'Input Tanggal Tidak Valid',
                        type: 'error',
                        timer: '3000'
                    });
                    return null;
                }
            }
            var table = $('#statistikDetailTable').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('api.tugasteknisi') }}",
                    data: {
                        filter_teknisi: filter_teknisi,
                        filter_status: filter_status,
                        tanggal_mulai: tanggal_mulai,
                        tanggal_selesai: tanggal_selesai,
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
                    // {data: 'no_telp_pelanggan', name: 'no_telp_pelanggan'},
                    {data: 'nama_kategori_jasa', name: 'nama_kategori_jasa'},
                    // {data: 'detail', name: 'detail'},
                    {data: 'mulai_info', name: 'mulai_info'},
                    {data: 'selesai_info', name: 'selesai_info'},
                    // {data: 'show_foto_mulai', name: 'show_foto_mulai', orderable: false, searchable: false},
                    // {data: 'show_foto_selesai', name: 'show_foto_selesai', orderable: false, searchable: false},
                    {data: 'status_info', name: 'status_info', orderable: false, searchable: false},
                    {data: 'teknisi1', name: 'teknisi1'},
                    {data: 'teknisi2', name: 'teknisi2'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        }

        function detail(filter_teknisi = ""){
            var filter_teknisi = filter_teknisi;
            $('#id_teknisi_detail_statistik').val(filter_teknisi);
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_selesai = $('#tanggal_selesai').val();

            fetchDataDetail(filter_teknisi, tanggal_mulai, tanggal_selesai);
            
            $('#modal-detail-statistik').modal('show');
            $('#modal-detail-statistik .modal-title').text('Detail Statistik Tugas');
        }

        function exportPDFLaporan(){
            var filter_teknisi = $('#filter_teknisi').val();
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_selesai = $('#tanggal_selesai').val();

            var url = `{{ url('exportLaporanStatistikTugasTeknisi?filter_teknisi=${filter_teknisi}&tanggal_mulai=${tanggal_mulai}&tanggal_selesai=${tanggal_selesai}') }}`;
            window.location.href = url;
        }

        function applyfilter(){
            var filter_teknisi = $('#filter_teknisi').val();
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_selesai = $('#tanggal_selesai').val();

            fetchData(filter_teknisi, tanggal_mulai, tanggal_selesai);
        }

        function applyfilterDetailStatistik(){
            var filter_teknisi = $('#id_teknisi_detail_statistik').val();
            var filter_status = $('#filter_status_detail_statistik').val();
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_selesai = $('#tanggal_selesai').val();
            
            fetchDataDetail(filter_teknisi, filter_status, tanggal_mulai, tanggal_selesai);
        }

        $('#filter_wrapper select').on('change', function (e) {
            applyfilter();
        });

        $('#modal-detail-statistik select#filter_status_detail_statistik').on('change', function (e) {
            applyfilterDetailStatistik();
        });

        fetchData();
    </script>
@endsection