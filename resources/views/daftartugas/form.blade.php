<div class="modal animate scaleIn" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
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
                    <input type="hidden" id="id" name="id">
                    <input type="text" id="status" name="status" style="display: none;">
                    <div class="box-body">
                        <div class="form-group">
                            <label><strong>Pelanggan :</strong></label>
                            <br>
                            <label id="nama_pelanggan">Nama Pelaggan</label>
                            <br>
                            <label id="alamat_pelanggan">Alamat Pelaggan</label>
                            <br>
                            <label id="no_telp_pelanggan">No Telp Pelaggan</label>
                            <hr>
                            <label ><strong>Kategori Jasa</strong></label>:&nbsp;<label id="kategori_jasa">Kategori Jasa</label>
                            <br>
                            <label ><strong>Jadwal Mulai</strong></label>:&nbsp;<label id="mulai_info">Jadwal Mulai</label>
                            <br>
                            <label ><strong>Detail Tugas</strong></label>:&nbsp;<label id="detail">Detail Tugas</label>
                        </div>
                        <hr>
                        <div class="form-group mb-2">
                            <label >Foto Mulai</label>
                            <input type="file" class="form-control" id="foto_mulai" name="foto_mulai" required>
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
