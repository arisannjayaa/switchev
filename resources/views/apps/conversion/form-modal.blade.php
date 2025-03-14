<div class="modal modal-blur fade" id="modal-technician" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tenaga Ahli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-technician">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Nama</label>
                        <div>
                            <input type="text" class="form-control" placeholder="Elon Musk" name="technician_name" id="technician_name">
                            <small class="form-hint">Nama lengkap anda</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Uraian Tugas</label>
                        <div>
                            <input type="text" class="form-control" placeholder="Uraian Tugas" name="task" id="task">
                            <small class="form-hint">Uraian tugas tenaga ahli</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Keluar</button>
                    <button type="button" id="btn-save-technician" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
