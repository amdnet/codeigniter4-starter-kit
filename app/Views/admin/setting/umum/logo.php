<div class="row">
    <div class="col-md-6 mb-4">
        <form id="simpanLogoWarna" action="<?= base_url($url . '/simpan-logo-warna'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="unggah kotak">
                <div class="loadingSpinner">⏳ <span class="ml-2">Memproses gambar...</span></div>
                <label for="logo_warna">Logo Warna</label>
                <div class="info-kecil"><small>Dimensi gambar ideal 345x87 px. <br> Format gambar: .jpg .jpeg .png</small></div>

                <img class="img-thumbnail p-2 my-2" id="preview_logo_warna" src="<?= base_url('upload/logo/') . setting('App.logoWarna') ?>">
                <input type="file" class="form-control-file mt-2" id="logo_warna" name="logo_warna" accept=".jpg,.jpeg,.png">
                <div class="info-kecil mt-2" id="info_logo_warna"><small>maksimal ukuran gambar 1 MB</small></div>

                <div class="text-right mt-2"><button type="submit" class="btn btn-sm btn-secondary">Simpan</button></div>
            </div>
        </form>
    </div>

    <div class="col-md-6 mb-4">
        <form id="simpanLogoPutih" action="<?= base_url($url . 'simpan-logo-putih'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="unggah kotak">
                <div class="loadingSpinner">⏳ <span class="ml-2">Memproses gambar...</span></div>
                <label for="logo_putih">Logo Putih</label>
                <div class="info-kecil"><small>Dimensi gambar ideal 345x87 px. <br> Format gambar: .jpg .jpeg .png</small></div>

                <img class="img-thumbnail bg-secondary p-2 my-2" id="preview_logo_putih" src="<?= base_url('upload/logo/') . setting('App.logoPutih') ?>">
                <input type="file" class="form-control-file mt-2" id="logo_putih" name="logo_putih" accept=".jpg,.jpeg,.png">
                <div class="info-kecil mt-2" id="info_logo_putih"><small>maksimal ukuran gambar 1 MB</small></div>

                <div class="text-right mt-2"><button type="submit" class="btn btn-sm btn-secondary">Simpan</button></div>
            </div>
        </form>
    </div>

    <div class="col-md-6 mb-4">
        <form id="simpanLogoIkon" action="<?= base_url($url . 'simpan-logo-ikon'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="unggah kotak">
                <div class="loadingSpinner">⏳ <span class="ml-2">Memproses gambar...</span></div>
                <label for="logo_ikon">Logo Favicon (ico)</label>
                <div class="info-kecil"><small>Dimensi gambar pasti 32x32 px. <br> Format gambar: .ico</small></div>

                <div class="d-inline-flex">
                    <img class="img-fluid" id="preview_logo_ikon" width="32" height="32" src="<?= base_url('upload/logo/') . setting('App.logoIkon') ?>">
                    <input type="file" class="form-control-file p-1 ml-2" id="logo_ikon" name="logo_ikon" accept=".ico">
                </div>

                <div class="info-kecil mt-2" id="info_logo_ikon"><small>maksimal ukuran gambar 100 kb</small></div>
                <div class="text-right mt-2"><button type="submit" class="btn btn-sm btn-secondary">Simpan</button></div>
            </div>
        </form>
    </div>

    <div class="col-md-6 mb-4">
        <form id="simpanLogoIkon32" action="<?= base_url($url . 'simpan-logo-ikon32'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="unggah kotak">
                <div class="loadingSpinner">⏳ <span class="ml-2">Memproses gambar...</span></div>
                <label for="logo_ikon32">Logo Favicon (png)</label>
                <div class="info-kecil"><small>Ukuran gambar 32x32 px. <br> Format gambar: .png</small></div>

                <div class="d-inline-flex">
                    <img class="img-fluid" id="preview_logo_ikon32" width="32" height="32" src="<?= base_url('upload/logo/') . setting('App.logoIkon32') ?>">
                    <input type="file" class="form-control-file p-1 ml-2" id="logo_ikon32" name="logo_ikon32" accept=".png">
                </div>

                <div class="info-kecil mt-2" id="info_logo_ikon32"><small>maksimal ukuran gambar 100 kb</small></div>
                <div class="text-right mt-2"><button type="submit" class="btn btn-sm btn-secondary">Simpan</button></div>
            </div>
        </form>
    </div>

    <div class="col-md-6 mb-4">
        <form id="simpanLogoIkon180" action="<?= base_url($url . 'simpan-logo-ikon180'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="unggah kotak">
                <div class="loadingSpinner">⏳ <span class="ml-2">Memproses gambar...</span></div>
                <label for="logo_ikon180">Logo Ikon (apple)</label>
                <div class="info-kecil"><small>Dimensi gambar pasti 180x180 px. <br> Format gambar: .png</small></div>

                <div style="display:ruby">
                    <img class="img-fluid" id="preview_logo_ikon180" width="60" height="60" src="<?= base_url('upload/logo/') . setting('App.logoIkon180') ?>">
                    <input type="file" class="form-control-file p-1 ml-2" id="logo_ikon180" name="logo_ikon180" accept=".png">
                </div>

                <div class="info-kecil mt-2" id="info_logo_ikon180"><small>maksimal ukuran gambar 100 kb</small></div>
                <div class="text-right mt-2"><button type="submit" class="btn btn-sm btn-secondary">Simpan</button></div>
            </div>
        </form>
    </div>

    <div class="col-md-6">
        <form id="simpanLogoIkon192" action="<?= base_url($url . 'simpan-logo-ikon192'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="unggah kotak">
                <div class="loadingSpinner">⏳ <span class="ml-2">Memproses gambar...</span></div>
                <label for="logo_ikon192">Logo Ikon (android)</label>
                <div class="info-kecil"><small>Dimensi gambar pasti 192x192 px. <br> Format gambar: .png</small></div>

                <div style="display:ruby">
                    <img class="img-fluid" id="preview_logo_ikon192" width="60" height="60" src="<?= base_url('upload/logo/') . setting('App.logoIkon192') ?>">
                    <input type="file" class="form-control-file p-1 ml-2" id="logo_ikon192" name="logo_ikon192" accept=".png">
                </div>

                <div class="info-kecil mt-2" id="info_logo_ikon192"><small>maksimal ukuran gambar 100 kb</small></div>
                <div class="text-right mt-2"><button type="submit" class="btn btn-sm btn-secondary">Simpan</button></div>
            </div>
        </form>
    </div>
</div>