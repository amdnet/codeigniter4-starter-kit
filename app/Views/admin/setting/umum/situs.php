<form id="situs-form" class="row" data-cek="true">
    <?= csrf_field() ?>
    <div class="col-md-6 mb-4">
        <label for="siteNama" class="mb-2">Nama Situs</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-bookmark"></i></span></div>
            <input type="text" id="siteNama" name="siteNama" class="form-control upper" value="<?= old('siteNama', setting('App.siteNama')) ?>" required>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="mb-2">Tagline</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-tag"></i></span></div>
            <input type="text" id="siteTagline" name="siteTagline" class="form-control upper" value="<?= old('siteTagline', setting('App.siteTagline')) ?>" required>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label class="mb-2">Telepon</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-telephone"></i></span></div>
            <input type="text" id="siteTelp" name="siteTelp" class="form-control" value="<?= old('siteTelp', setting('App.siteTelp')) ?>" required>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label class="mb-2">WhatsApp</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-whatsapp"></i></span></div>
            <input type="text" id="siteWa" name="siteWa" class="form-control" value="<?= old('siteWa', setting('App.siteWa')) ?>" required>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label class="mb-2">Telegram</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-telegram"></i></span></div>
            <input type="text" id="siteTelegram" name="siteTelegram" class="form-control" value="<?= old('siteTelegram', setting('App.siteTelegram')) ?>" required>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="mb-2">Email</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-envelope"></i></span></div>
            <input type="text" id="siteEmail" name="siteEmail" class="form-control" value="<?= old('siteEmail', setting('App.siteEmail')) ?>" required>
        </div>
    </div>

    <div class="col-md-6">
        <label class="mb-2">Alamat</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-building"></i></span></div>
            <input type="text" id="siteAlamat" name="siteAlamat" class="form-control upper" value="<?= old('siteAlamat', setting('App.siteAlamat')) ?>" required>
        </div>
    </div>

    <div class="col-12">
        <button type="button" id="situs-loading" class="btn btn-dark float-right" disabled>
            <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <button id="situs-submit" class="btn btn-secondary float-right" type="submit">Simpan</button>
    </div>
</form>