<div class="modal modal-blur fade" id="modal-send-spu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-send-spu">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="mb-3">
                        <label class="form-label required">Surat Pengantar Uji</label>
                        <input id="spu_attachment" type="file" class="form-control" name="spu_attachment">
                        <small class="form-hint">
                            Surat Pengantar Uji
                        </small>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Keluar</button>
                    <button type="button" id="btn-send-spu-submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
