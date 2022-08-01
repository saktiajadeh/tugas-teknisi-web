<div class="modal animate scaleIn" id="modal-form-selesai" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="form-item" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" >
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header flex-row-reverse">
                    <button type="button" class="close btn btn-sm" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ion-close-round"></i>
                    </button>
                    <h3 class="modal-title"></h3>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id_selesai" name="id">
                    <input type="text" id="status_selesai" name="status" style="display: none;">
                    <div class="box-body">
                        <div class="form-group">
                            <label><strong>Pelanggan :</strong></label>
                            <br>
                            <label id="nama_pelanggan_selesai">Nama Pelaggan</label>
                            <br>
                            <label id="alamat_pelanggan_selesai">Alamat Pelaggan</label>
                            <br>
                            <label id="no_telp_pelanggan_selesai">No Telp Pelaggan</label>
                            <hr>
                            <label ><strong>Kategori Jasa</strong></label>:&nbsp;<label id="kategori_jasa_selesai">Kategori Jasa</label>
                            <br>
                            <label ><strong>Jadwal Mulai</strong></label>:&nbsp;<label id="mulai_info_selesai">Jadwal Mulai</label>
                            <br>
                            <label ><strong>Detail Tugas</strong></label>:&nbsp;<label id="detail_selesai">Detail Tugas</label>
                        </div>
                        <hr>
                        <div class="form-group mb-2">
                            <label >Foto Selesai</label>
                            <input type="file" class="form-control" id="foto_selesai" name="foto_selesai" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Jam Selesai</label>
                            <input type="text" class="form-control" id="jam_selesai" name="jam_selesai" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Tanggal Selesai</label>
                            <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>
