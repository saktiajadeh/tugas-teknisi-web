@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Daftar Tugas Saya</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h5 class="mb-0">Daftar Tugas Saya</h5>
                    </div> --}}
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-end justify-content-center justify-content-md-start">
                            <div class="form-group mb-2 me-2">
                                <label for="" class="form-label mb-0">Filter Pelanggan</label>
                                <select id="filter_pelanggan" name="filter_pelanggan" class="form-control select" style="width: 155px;">
                                    <option value=" ">No Filter</option>
                                    @foreach($pelanggan as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }} - {{ $data->alamat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2 me-2">
                                <label for="" class="form-label mb-0">Filter Kategori</label>
                                <select id="filter_kategorijasa" name="filter_kategorijasa" class="form-control select" style="width: 155px;">
                                    <option value=" ">No Filter</option>
                                    @foreach($kategorijasa as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2 me-2">
                                <label for="" class="form-label mb-0">Filter Status</label>
                                <select id="filter_status" name="filter_status" class="form-control select" style="width: 155px;">
                                    <option value=" ">No Filter</option>
                                    <option value="nostatus">Belum Dikerjakan</option>
                                    <option value="progress">Sedang Dikerjakan</option>
                                    <option value="finish">Selesai</option>
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
                            <table id="daftarTugasTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat Pelanggan</th>
                                        {{-- <th>No Telp Pelanggan</th> --}}
                                        <th>Kategori Jasa</th>
                                        {{-- <th>Detail Tugas</th> --}}
                                        <th>Dimulai pada</th>
                                        <th>Diselesaikan Pada</th>
                                        {{-- <th>Foto Mulai</th>
                                        <th>Foto Selesai</th> --}}
                                        <th style="width: 100px;">Status</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        @include('daftartugas.form')
                        @include('daftartugas.formSelesai')
                        @include('daftartugas.detail')
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
        function fetchData(filter_pelanggan = "", filter_kategorijasa = "", filter_status = "", tanggal_mulai = "", tanggal_selesai = ""){
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
            var table = $('#daftarTugasTable').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('api.daftartugas') }}",
                    data: {
                        filter_pelanggan: filter_pelanggan,
                        filter_kategorijasa: filter_kategorijasa,
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
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        }

        function mulaiKerjakanForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('daftartugas') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Mulai Kerjakan Tugas');

                    $('#id').val(data.id);
                    $('#status').val("progress");
                    $('#nama_pelanggan').text(data.pelanggan.nama);
                    $('#alamat_pelanggan').text(data.pelanggan.alamat);
                    $('#no_telp_pelanggan').text(data.pelanggan.no_telp);
                    $('#kategori_jasa').text(data.kategorijasa.nama);
                    $('#detail').text(data.detail);
                    $('#mulai_info').text(data.mulai_info);
                    // var current = new Date();
                    // var jam_mulai = `${current.getHours()}:${current.getMinutes()}:${current.getSeconds()}`
                    // var bulan = (current.getMonth() + 1) >= 10 ? (current.getMonth() + 1) : "0" + (current.getMonth() + 1);
                    // var tanggal_mulai = `${current.getFullYear()}-${bulan}-${current.getDate()}`
                    // $('#jam_mulai').val(jam_mulai);
                    // $('#tanggal_mulai').val(tanggal_mulai);

                    // $("#jam_mulai").prop('disabled', true);
                    // $("#tanggal_mulai").prop('disabled', true);
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        function selesaiForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form-selesai form')[0].reset();
            $.ajax({
                url: "{{ url('daftartugas') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form-selesai').modal('show');
                    $('.modal-title').text('Tugas Selesai?');

                    $('#id_selesai').val(data.id);
                    $('#status_selesai').val("finish");
                    // $('#detail_selesai').val(data.detail);
                    $('#nama_pelanggan_selesai').text(data.pelanggan.nama);
                    $('#alamat_pelanggan_selesai').text(data.pelanggan.alamat);
                    $('#no_telp_pelanggan_selesai').text(data.pelanggan.no_telp);
                    $('#kategori_jasa').text(data.kategorijasa.nama);
                    $('#detail_selesai').text(data.detail);

                    var current = new Date();
                    var jam_selesai = `${current.getHours()}:${current.getMinutes()}:${current.getSeconds()}`
                    $('#jam_selesai').val(jam_selesai);

                    const todayDate = new Date(); 
                    const formatDate = todayDate.getDate() < 10 ? `0${todayDate.getDate()}`:todayDate.getDate();
                    const formatMonth = (current.getMonth() + 1) >= 10 ? (current.getMonth() + 1) : "0" + (current.getMonth() + 1);
                    const formattedDate = [todayDate.getFullYear(), formatMonth, formatDate].join('-');
                    $('#modal-form-selesai #tanggal_selesai').val(formattedDate);

                    $("#jam_selesai").prop('disabled', true);
                    $("#modal-form-selesai #tanggal_selesai").prop('disabled', true);
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        function detail(id){
            $.ajax({
                url: "{{ url('daftartugas') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    setTimeout(() => {
                        $('#modal-detail').modal('show');
                        $('#modal-detail .modal-title').text('Detail Tugas');
                    }, 50);

                    $('#modal-detail .nama_teknisi').text(data.karyawan.name);

                    $('#modal-detail .nama_pelanggan').text(data.pelanggan.nama);
                    $('#modal-detail .alamat_pelanggan').text(data.pelanggan.alamat);
                    $('#modal-detail .no_telp_pelanggan').text(data.pelanggan.no_telp);
                    $('#modal-detail .email_pelanggan').text(data.pelanggan.email);

                    $('#modal-detail .kategorijasa').text(data.kategorijasa.nama);
                    $('#modal-detail .keterangan').text(data.detail == null ? '-' : data.detail);

                    $('#modal-detail .tanggal_mulai').text(data.mulai_info);
                    $('#modal-detail .tanggal_selesai').text('-');

                    var classNameStatus = "";
                    var textStatus = "";
                    if(data.status == "nostatus"){
                        $('#modal-detail #badge_status').removeClass('bg-primary');
                        $('#modal-detail #badge_status').removeClass('bg-success');
                        classNameStatus = "bg-secondary";
                        textStatus = "Belum dikerjakan";
                    }
                    if(data.status == "progress"){
                        $('#modal-detail #badge_status').removeClass('bg-secondary');
                        $('#modal-detail #badge_status').removeClass('bg-success');
                        classNameStatus = "bg-primary";
                        textStatus = "Sedang Dikerjakan";
                    }
                    if(data.status == "finish"){
                        $('#modal-detail #badge_status').removeClass('bg-secondary');
                        $('#modal-detail #badge_status').removeClass('bg-primary');
                        classNameStatus = "bg-success";
                        textStatus = "Selesai";
                        $('#modal-detail .tanggal_selesai').text(data.selesai_info);
                    }
                    $('#modal-detail #badge_status').addClass(classNameStatus);
                    $('#modal-detail #badge_status').text(textStatus);

                    if(data.foto_mulai === null){
                        $('#modal-detail .foto_mulai').addClass('d-none');
                        $('#modal-detail .foto_mulai_label').removeClass('d-none');
                    } else {
                        $('#modal-detail .foto_mulai').removeClass('d-none');
                        $('#modal-detail .foto_mulai_label').addClass('d-none');
                        $('#modal-detail .foto_mulai').attr('src', `{{asset('${data.foto_mulai}')}}`);
                    }

                    if(data.foto_selesai === null){
                        $('#modal-detail .foto_selesai').addClass('d-none');
                        $('#modal-detail .foto_selesai_label').removeClass('d-none');
                    } else {
                        $('#modal-detail .foto_selesai').removeClass('d-none');
                        $('#modal-detail .foto_selesai_label').addClass('d-none');
                        $('#modal-detail .foto_selesai').attr('src', `{{asset('${data.foto_selesai}')}}`);
                    }
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        fetchData();

        function applyfilter(){
            var filter_pelanggan = $('#filter_pelanggan').val();
            var filter_kategorijasa = $('#filter_kategorijasa').val();
            var filter_status = $('#filter_status').val();
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_selesai = $('#tanggal_selesai').val();

            fetchData(filter_pelanggan, filter_kategorijasa, filter_status, tanggal_mulai, tanggal_selesai);
        }

        $('select').on('change', function (e) {
            applyfilter();
        });

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('daftartugas') }}";
                    else url = "{{ url('daftartugas') . '/' }}" + id;

                    // $("#jam_mulai").prop('disabled', false);
                    // $("#tanggal_mulai").prop('disabled', false);
                    $.ajax({
                        url : url,
                        type : "POST",
                        //hanya untuk input data tanpa dokumen
//                      data : $('#modal-form form').serialize(),
                        data: new FormData($("#modal-form form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-form').modal('hide');
                            // table.ajax.reload();
                            fetchData();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });

            $('#modal-form-selesai form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id_selesai').val();
                    if (save_method == 'add') url = "{{ url('daftartugas') }}";
                    else url = "{{ url('daftartugas') . '/' }}" + id;

                    $("#jam_selesai").prop('disabled', false);
                    $("#modal-form-selesai #tanggal_selesai").prop('disabled', false);
                    $.ajax({
                        url : url,
                        type : "POST",
                        //hanya untuk input data tanpa dokumen
//                      data : $('#modal-form-selesai form').serialize(),
                        data: new FormData($("#modal-form-selesai form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-form-selesai').modal('hide');
                            // table.ajax.reload();
                            fetchData();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endsection