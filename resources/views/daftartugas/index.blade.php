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
                        
                        <div class="table-responsive p-1">
                            <table id="daftarTugasTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat Pelanggan</th>
                                        <th>No Telp Pelanggan</th>
                                        <th>Kategori Jasa</th>
                                        <th>Detail Tugas</th>
                                        <th>Teknisi</th>
                                        <th>Foto</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        @include('daftartugas.form')
                        @include('daftartugas.formSelesai')
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
        var table = $('#daftarTugasTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.daftartugas') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'nama_pelanggan', name: 'nama_pelanggan'},
                {data: 'alamat_pelanggan', name: 'alamat_pelanggan'},
                {data: 'no_telp_pelanggan', name: 'no_telp_pelanggan'},
                {data: 'nama_kategori_jasa', name: 'nama_kategori_jasa'},
                {data: 'detail', name: 'detail'},
                {data: 'nama_karyawan', name: 'nama_karyawan'},
                {data: 'show_photo', name: 'show_photo', orderable: false, searchable: false},
                {data: 'status_info', name: 'status_info', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

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
                    $('#detail').val(data.detail);
                    var current = new Date();
                    var jam_mulai = `${current.getHours()}:${current.getMinutes()}:${current.getSeconds()}`
                    var bulan = (current.getMonth() + 1) >= 10 ? (current.getMonth() + 1) : "0" + (current.getMonth() + 1);
                    var tanggal_mulai = `${current.getFullYear()}-${bulan}-${current.getDate()}`
                    $('#jam_mulai').val(jam_mulai);
                    $('#tanggal_mulai').val(tanggal_mulai);
                    $('#status').val("progress");

                    $("#jam_mulai").prop('disabled', true);
                    $("#tanggal_mulai").prop('disabled', true);
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
                    $('#detail_selesai').val(data.detail);
                    var current = new Date();
                    var jam_selesai = `${current.getHours()}:${current.getMinutes()}:${current.getSeconds()}`
                    var bulan = (current.getMonth() + 1) >= 10 ? (current.getMonth() + 1) : "0" + (current.getMonth() + 1);
                    var tanggal_selesai = `${current.getFullYear()}-${bulan}-${current.getDate()}`
                    $('#jam_selesai').val(jam_selesai);
                    $('#tanggal_selesai').val(tanggal_selesai);
                    $('#status_selesai').val("finish");

                    $("#jam_selesai").prop('disabled', true);
                    $("#tanggal_selesai").prop('disabled', true);
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('daftartugas') }}";
                    else url = "{{ url('daftartugas') . '/' }}" + id;

                    $("#jam_mulai").prop('disabled', false);
                    $("#tanggal_mulai").prop('disabled', false);
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
                            table.ajax.reload();
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
                    $("#tanggal_selesai").prop('disabled', false);
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
                            table.ajax.reload();
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