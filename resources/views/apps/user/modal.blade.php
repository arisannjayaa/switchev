<div class="modal modal-blur fade" id="modal-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-user">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="mb-3">
                        <label class="form-label required">Nama</label>
                        <div>
                            <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Joko Widodo" name="name" id="name">
                            <small class="form-hint">Nama lengkap anda</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Email</label>
                        <div>
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email" name="email" id="email">
                            <small class="form-hint">Kami tidak akan pernah membagikan email Anda kepada orang lain.</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Password</label>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                            <small class="form-hint">
                                Kata sandi Anda harus sepanjang 8-20 karakter, mengandung huruf dan angka, dan tidak boleh mengandung
                                spasi, karakter khusus, atau emoji.
                            </small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Telepon</label>
                        <div>
                            <input type="text" class="form-control" placeholder="telepon" name="telephone" id="telephone">
                            <small class="form-hint">
                                Gunakan nomor telepon aktif Anda
                            </small>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Keluar</button>
                <button type="submit" id="btn-submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
