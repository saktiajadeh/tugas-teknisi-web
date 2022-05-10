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
                    <div class="box-body">
                        <div class="form-group mb-2">
                            <label >Pilih Hak Akses</label>
                            <select class="form-select" aria-label="Pilih Hak Akses" id="role" name="role" required>
                                <option value="teknisi">Teknisi</option>
                                <option value="admin">Admin</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Nama</label>
                            <input type="text" class="form-control" id="name" name="name" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >No Telpon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="form-group mb-2">
                            <label >Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
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
