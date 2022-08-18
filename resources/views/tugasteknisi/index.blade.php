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
                        <div class="d-flex justify-content-center justify-content-md-start mb-3">
                            <a onclick="exportPDFLaporan()" class="btn btn-primary btn-sm">
                                <i class="ion-ios-book me-1"></i>
                                Cetak Laporan Tugas Teknisi
                            </a>
                        </div>
                        <div id="filter_wrapper" class="d-flex flex-wrap align-items-end justify-content-center justify-content-md-start">
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
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat Pelanggan</th>
                                        {{-- <th>No Telp Pelanggan</th> --}}
                                        <th>Kategori Jasa</th>
                                        {{-- <th>Detail Tugas</th> --}}
                                        <th>Dimulai pada</th>
                                        <th>Diselesaikan pada</th>
                                        {{-- <th>Foto Sebelum</th>
                                        <th>Foto Selesai</th> --}}
                                        <th>Status</th>
                                        <th>Teknisi 1</th>
                                        <th>Teknisi 2</th>
                                        <th width="140px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        @include('tugasteknisi.form')
                        @include('tugasteknisi.detail')
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
            var table = $('#tugasTeknisiTable').DataTable({
                "bDestroy": true,
                processing: true,
                serverSide: true,
                ajax:{
                    url: "{{ route('api.tugasteknisi') }}",
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
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        }

        function addForm() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form').modal('show');
            $('#modal-form form')[0].reset();
            $('.modal-title').text('Tambah Data Tugas Teknisi');
        }

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PUT');
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
                    if (save_method == 'add'){
                        url = "{{ url('tugasteknisi') }}";
                    } else {
                        url = "{{ url('tugasteknisi') . '/' }}" + id;
                    }

                    if(save_method === 'edit'){
                        var teknisi1 = $('#modal-form #karyawan_id').val();
                        var teknisi2 = $('#modal-form #karyawan_id_2').val();
                        if(teknisi1 === teknisi2){
                            swal({
                                title: 'Oops...',
                                text: 'Teknisi 1 dengan Teknisi 2 Tidak Boleh Sama',
                                type: 'error',
                                timer: '5000'
                            });
                            return false;
                        } else {
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
                    }
                }
            });
        });

        function detail(id){
            $.ajax({
                url: "{{ url('tugasteknisi') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    setTimeout(() => {
                        $('#modal-detail').modal('show');
                        $('#modal-detail .modal-title').text('Detail Tugas');
                    }, 50);

                    $('#modal-detail .nama_teknisi').text(data.karyawan.name);
                    $('#modal-detail .nama_teknisi2').text(data.karyawan2.name);

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

                    if(data.foto_dokumen === null){
                        $('#modal-detail .foto_dokumen').addClass('d-none');
                        $('#modal-detail .foto_dokumen_label').removeClass('d-none');
                    } else {
                        $('#modal-detail .foto_dokumen').removeClass('d-none');
                        $('#modal-detail .foto_dokumen_label').addClass('d-none');
                        $('#modal-detail .foto_dokumen').attr('src', `{{asset('${data.foto_dokumen}')}}`);
                    }

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

        function exportPDFLaporan(){
            var filter_teknisi = $('#filter_teknisi').val();
            var filter_pelanggan = $('#filter_pelanggan').val();
            var filter_kategorijasa = $('#filter_kategorijasa').val();
            var filter_status = $('#filter_status').val();
            var tanggal_mulai = $('#tanggal_mulai').val();
            var tanggal_selesai = $('#tanggal_selesai').val();

            var url = `{{ url('exportLaporanTugasTeknisi?filter_teknisi=${filter_teknisi}&filter_pelanggan=${filter_pelanggan}&filter_kategorijasa=${filter_kategorijasa}&filter_status=${filter_status}&tanggal_mulai=${tanggal_mulai}&tanggal_selesai=${tanggal_selesai}') }}`;
            window.location.href = url;
        }

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