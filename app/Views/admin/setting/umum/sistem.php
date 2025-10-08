<form id="sistem-form" class="row" data-cek="true">
    <div class="col-md-4 mb-4">
        <label for="authRegistration" class="">Form Registrasi</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"><i class="bi bi-translate"></i></label>
            </div>
            <select id="authRegistration" name="authRegistration" class="form-control">
                <option value="true" <?= setting('App.authRegistration') === "true" ? 'selected' : '' ?>>Buka</option>
                <option value="false" <?= setting('App.authRegistration') === "false" ? 'selected' : '' ?>>Tutup</option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label for="authMagicLink" class="">Login Tanpa Sandi</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"><i class="bi bi-shield-plus"></i></label>
            </div>
            <select id="authMagicLink" name="authMagicLink" class="form-control">
                <option value="true" <?= setting('App.authMagicLink') === "true" ? 'selected' : '' ?>>Buka</option>
                <option value="false" <?= setting('App.authMagicLink') === "false" ? 'selected' : '' ?>>Tutup</option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label for="authRemembering" class="">Centang "Ingat Saya"</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"><i class="bi bi-shield-check"></i></label>
            </div>
            <select id="authRemembering" name="authRemembering" class="form-control">
                <option value="true" <?= setting('App.authRemembering') === "true" ? 'selected' : '' ?>>Buka</option>
                <option value="false" <?= setting('App.authRemembering') === "false" ? 'selected' : '' ?>>Tutup</option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label for="authRememberLength" class="">Durasi "Ingat Saya"</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"><i class="bi bi-clock-history"></i></label>
            </div>
            <input type="text" id="authRememberLength" name="authRememberLength" class="form-control upper" value="<?= setting('App.authRememberLength') ?>" required>
        </div>
    </div>

    <div class="col-12">
        <button type="button" id="sistem-loading" class="btn btn-dark float-right" disabled>
            <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <button id="sistem-submit" class="btn btn-secondary float-right" type="submit">Simpan</button>
    </div>
</form>