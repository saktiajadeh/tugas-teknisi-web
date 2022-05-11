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
                        <div class="form-group mb-2">
                            <label >Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Detail Tugas</label>
                            <textarea type="text" class="form-control" id="detail" name="detail" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Jam Mulai</label>
                            <input type="text" class="form-control" id="jam_mulai" name="jam_mulai" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Tanggal Mulai</label>
                            <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
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
