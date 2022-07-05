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
                            <label >Teknisi</label>
                            {!! Form::select('karyawan_id', $teknisi, null, ['class' => 'form-control select', 'placeholder' => '-- Pilih Teknisi --', 'id' => 'karyawan_id', 'required']) !!}
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
