<!-- Modal Tambah Satuan Baru -->
<div class="modal fade" id="modal_add_unit" tabindex="-1" role="dialog" aria-labelledby="modalAddUnitLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalAddUnitLabel">
                    <i class="fa fa-plus-circle"></i> Tambah Satuan Baru
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Satuan *</label>
                    <input type="text" id="modal_unit_name" class="form-control" placeholder="Contoh: Kilogram" required>
                </div>
                <div class="form-group">
                    <label>Singkatan *</label>
                    <input type="text" id="modal_unit_short" class="form-control" placeholder="Contoh: Kg" required>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="modal_unit_decimal" value="1"> Boleh desimal
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btn_save_unit">
                    <i class="fa fa-save"></i> Simpan Satuan
                </button>
            </div>
        </div>
    </div>
</div>
