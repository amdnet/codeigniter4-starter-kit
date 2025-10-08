<form id="recaptcha-form" class="row" data-cek="true">
    <div class="col-md-4 mb-4">
        <label for="gRecaptcha">Google Recaptcha</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"><i class="bi bi-shield-lock"></i></label>
            </div>
            <select id="gRecaptcha" name="gRecaptcha" class="form-control">
                <option value="true" <?= setting('App.gRecaptcha') === "true" ? 'selected' : '' ?>>Buka</option>
                <option value="false" <?= setting('App.gRecaptcha') === "false" ? 'selected' : '' ?>>Tutup</option>
            </select>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <label for="gSiteKey">Recaptcha Site Key</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"><i class="bi bi-shield-lock"></i></label>
            </div>
            <input type="text" id="gSiteKey" name="gSiteKey" class="form-control upper" value="<?= setting('App.gSiteKey') ?>" required>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <label for="gSecretKey">Recaptcha Secret Key</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <label class="input-group-text"><i class="bi bi-shield-lock"></i></label>
            </div>
            <input type="text" id="gSecretKey" name="gSecretKey" class="form-control upper" value="<?= setting('App.gSecretKey') ?>" required>
        </div>
    </div>

    <div class="col-12">
        <button type="button" id="recaptcha-loading" class="btn btn-dark float-right" disabled>
            <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <button id="recaptcha-submit" class="btn btn-secondary float-right" type="submit">Simpan</button>
    </div>
</form>