@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Data Pembagian Tugas Teknisi</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h5 class="mb-0">Data Tugas Teknisi</h5>
                    </div> --}}
                    <div class="card-body">
                        {{-- <div class="d-flex justify-content-center justify-content-md-start mb-3">
                            <a onclick="addForm()" class="btn btn-primary btn-sm">
                                <i class="ion-plus-round"></i>
                                Tambah Data Tugas Teknisi
                            </a>
                        </div> --}}
                        <div class="table-responsive p-1">
                            <table id="tugasTeknisiTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat Pelanggan</th>
                                        <th>No Telp Pelanggan</th>
                                        <th>Kategori Jasa</th>
                                        <th>Detail Tugas</th>
                                        <th>Dimulai pada</th>
                                        <th>Diselesaikan pada</th>
                                        <th>Foto Sebelum</th>
                                        <th>Foto Selesai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        @include('tugasteknisi.form')
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
        var table = $('#tugasTeknisiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('api.tugasteknisi') }}",
            columns: [
                {data: 'id', name: 'id'},
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
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Tambah Data Tugas Teknisi');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('tugasteknisi') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Serahkan Tugas Teknisi');

                    $('#id').val(data.id);
                    $('#karyawan_id').val(data.karyawan_id);
                },
                error : function() {
                    alert("Nothing Data");
                }
            });
        }

        function deleteData(id){
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: 'Yakin mau dihapus?',
                text: "Data yang sudah terhapus tidak dapat dikembalikan",
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus'
            }).then(function () {
                $.ajax({
                    url : "{{ url('tugasteknisi') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        table.ajax.reload();
                        swal({
                            title: 'Success!',
                            text: data.message,
                            type: 'success',
                            timer: '1500'
                        })
                    },
                    error : function () {
                        swal({
                            title: 'Oops...',
                            text: data.message,
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            });
        }

        $(function(){
            $('#modal-form form').validator().on('submit', function (e) {
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('tugasteknisi') }}";
                    else url = "{{ url('tugasteknisi') . '/' }}" + id;

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
        });
    </script>
@endsection