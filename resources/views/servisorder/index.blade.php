@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Data Servis Order</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    {{-- <div class="card-header">
                        <h5 class="mb-0">Data Servis Order</h5>
                    </div> --}}
                    <div class="card-body">
                        <div class="d-flex justify-content-center justify-content-md-start mb-3">
                            <a onclick="addForm()" class="btn btn-primary btn-sm">
                                <i class="ion-plus-round me-1"></i>
                                Tambah Data Servis Order
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
                            <div class="form-group mb-2 me-2">
                                <label for="" class="form-label mb-0">Filter Pelanggan</label>
                                <select id="filter_pelanggan" name="filter_pelanggan" class="form-control select" style="width: 155px;">
                                    <option value=" ">No Filter</option>
                                    @foreach($pelanggan as $id=>$value)
                                        <option value="{{ $id }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2 me-2">
                                <label for="" class="form-label mb-0">Filter Kategori</label>
                                <select id="filter_kategorijasa" name="filter_kategorijasa" class="form-control select" style="width: 155px;">
                                    <option value=" ">No Filter</option>
                                    @foreach($kategorijasa as $id=>$value)
                                        <option value="{{ $id }}">{{ $value }}</option>
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
                            <table id="servisOrderTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat Pelanggan</th>
                                        <th>Kategori Jasa</th>
                                        <th>Detail Servis</th>
                                        <th>Jadwal</th>
                                        <th>Foto Dokumen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        @include('servisorder.form')
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
        function fetchData(filter_teknisi ="", filter_pelanggan = "", filter_kategorijasa = "", filter_status = "", tanggal_mulai = "", tanggal_selesai = ""){
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
            var table = $('#servisOrderTable').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('api.servisorder') }}",
                    data: {
                        filter_teknisi: filter_teknisi,
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
                    {data: 'nama_kategori_jasa', name: 'nama_kategori_jasa'},
                    {data: 'detail', name: 'detail'},
                    {data: 'mulai_info', name: 'mulai_info'},
                    {data: 'show_foto_dokumen', name: 'show_foto_dokumen', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        }

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Tambah Data Servis Order');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form form')[0].reset();
            $.ajax({
                url: "{{ url('servisorder') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form').modal('show');
                    $('.modal-title').text('Ubah Data Servis Order');

                    $('#id').val(data.id);
                    $('#pelanggan_id').val(data.pelanggan_id);
                    $('#kategori_jasa_id').val(data.kategori_jasa_id);
                    $('#detail').val(data.detail);
                    var jamMulaiArr = data.jam_mulai.toString().split(":");
                    var now = new Date(`${data.tanggal_mulai} ${data.jam_mulai}`);
                    var setJadwalMulai = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().substring(0, 19);
                    $("#jadwal_mulai").val(setJadwalMulai);
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
                    url : "{{ url('servisorder') }}" + '/' + id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                    success : function(data) {
                        // table.ajax.reload();
                        fetchData();
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
                    if (save_method == 'add') url = "{{ url('servisorder') }}";
                    else url = "{{ url('servisorder') . '/' }}" + id;

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

        function applyfilter(){
            var filter_teknisi = $('#filter_teknisi').val();
            var filter_pelanggan = $('#filter_pelanggan').val();
            var filter_kategorijasa = $('#filter_kategorijasa').val();
            var filter_status = $('#filter_status').val();
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_selesai = $('#tanggal_selesai').val();

            fetchData(filter_teknisi, filter_pelanggan, filter_kategorijasa, filter_status, tanggal_mulai, tanggal_selesai);
        }

        $('#filter_wrapper select').on('change', function (e) {
            applyfilter();
        });

        fetchData();
    </script>
@endsection