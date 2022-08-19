<div class="modal animate scaleIn" id="modal-detail-statistik" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog mx-2 mx-md-3 mx-lg-auto" style="max-width: 1000px">
        <div class="modal-content">
            <div class="modal-header flex-row-reverse">
                <button type="button" class="close btn btn-sm" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ion-close-round"></i>
                </button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap align-items-end justify-content-center justify-content-md-start">
                    <input id="id_teknisi_detail_statistik" name="id_teknisi_detail_statistik" type="hidden" value="">
                    <div class="form-group mb-2 me-2">
                        <label for="" class="form-label mb-0">Filter Status</label>
                        <select id="filter_status_detail_statistik" name="filter_status_detail_statistik" class="form-control select" style="min-width: 154px; max-width: 200px;" data-bs-toggle="tooltip" data-bs-placement="top" title="Tooltip on top">
                            <option value=" ">No Filter</option>
                            <option value="nostatus">Belum Dikerjakan</option>
                            <option value="progress">Sedang Dikerjakan</option>
                            <option value="finish">Selesai Dikerjakan</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive p-1">
                    <table id="statistikDetailTable" class="table table-striped">
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
                                {{-- <th width="140px">Aksi</th> --}}
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>