<div class="modal modal-blur fade" id="modal-equipment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Peralatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-equipment">
                <input type="hidden" id="equipment_id" name="equipment_id" value="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Jenis</label>
                        <div>
                            <input type="text" class="form-control" placeholder="Jenis" name="type" id="type">
                            <small class="form-hint">Jenis Peralatan</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Nama</label>
                        <div>
                            <input type="text" class="form-control" placeholder="Nama" name="name" id="name">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Merek</label>
                        <div>
                            <input type="text" class="form-control" placeholder="Merek" name="brand" id="brand">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Spesifikasi</label>
                        <div>
                            <input type="text" class="form-control" placeholder="Spesfikasi" name="specification" id="specification">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Keluar</button>
                    <button type="submit" id="btn-save-equipment" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
