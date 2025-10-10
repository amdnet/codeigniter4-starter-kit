<form id="smtp-form" class="row" data-cek="true">
    <?= csrf_field() ?>
    <div class="col-md-6 mb-4">
        <label for="smtpEmail" class="mb-2">Email Pengirim</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-envelope-at"></i></span></div>
            <input type="text" id="smtpEmail" name="smtpEmail" class="form-control" value="<?= old('smtpEmail', setting('App.smtpEmail')) ?>" required>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="smtpNama" class="mb-2">Nama Pengirim</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-person-circle"></i></span></div>
            <input type="text" id="smtpNama" name="smtpNama" class="form-control upper" value="<?= old('smtpNama', setting('App.smtpNama')) ?>" required>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="smtpPenerima" class="mb-2">Email Notifikasi</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-envelope-exclamation"></i></span></div>
            <input type="text" id="smtpPenerima" name="smtpPenerima" class="form-control" value="<?= old('smtpPenerima', setting('App.smtpPenerima')) ?>" required>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="smtpHost" class="mb-2">Server Host</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-hdd-rack"></i></span></div>
            <input type="text" id="smtpHost" name="smtpHost" class="form-control" value="<?= old('smtpHost', setting('App.smtpHost')) ?>" required>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label class="mb-2">Server Protokol</label>
        <div class="input-group">
            <div class="input-group-prepend"><label class="input-group-text"><i class="bi bi-hdd-rack"></i></label></div>
            <select id="smtpProtocol" name="smtpProtocol" class="form-control">
                <option value="mail" <?= setting('App.smtpProtocol') == 'mail' ? 'selected' : '' ?>>mail</option>
                <option value="sendmail" <?= setting('App.smtpProtocol') == 'sendmail' ? 'selected' : '' ?>>sendmail</option>
                <option value="smtp" <?= setting('App.smtpProtocol') == 'smtp' ? 'selected' : '' ?>>smtp</option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label class="mb-2">Port Koneksi</label>
        <div class="input-group">
            <div class="input-group-prepend"><label class="input-group-text"><i class="bi bi-hdd-rack"></i></label></div>
            <select id="smtpCrypto" name="smtpCrypto" class="form-control">
                <option value="" <?= setting('App.smtpCrypto') == '' ? 'selected' : '' ?>>Null</option>
                <option value="tls" <?= setting('App.smtpCrypto') == 'tls' ? 'selected' : '' ?>>TLS</option>
                <option value="ssl" <?= setting('App.smtpCrypto') == 'ssl' ? 'selected' : '' ?>>SSL</option>
            </select>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <label for="smtpPort" class="mb-2">Port Server</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-hdd-rack"></i></span></div>
            <input type="text" id="smtpPort" name="smtpPort" class="form-control" value="<?= old('smtpPort', setting('App.smtpPort')) ?>" required>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="smtpUser" class="mb-2">Server Mail User</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-hdd-rack"></i></span></div>
            <input type="text" id="smtpUser" name="smtpUser" class="form-control" value="<?= old('smtpUser', setting('App.smtpUser')) ?>" required>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label for="smtpPass" class="mb-2">Server Mail Password</label>
        <div class="input-group">
            <div class="input-group-prepend"><span onclick="cekpwd()" class="input-group-text ikon" style="cursor:pointer"><i class="bi bi-eye"></i></span></div>
            <input type="password" id="smtpPass" name="smtpPass" class="form-control">
            <div class="input-group-append">
                <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Kosongkan password jika tidak ada perubahan."><i class="bi bi-question-circle"></i></span>
            </div>
        </div>
    </div>

    <div class="col-12">
        <button type="button" id="smtp-loading" class="btn btn-dark float-right" disabled>
            <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
            Loading...
        </button>
        <button type="submit" id="smtp-submit" class="btn btn-secondary float-right">Simpan</button>
    </div>
</form>

<form action="<?= site_url('admin/setting/umum/tes-smtp') ?>" method="post" class="row my-3">
    <?= csrf_field() ?>
    <div class="col-md-6">
        <label for="smtpPass" class="mb-2">Uji coba pengiriman email</label>
        <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text"><i class="bi bi-envelope-arrow-up"></i></span></div>
            <input type="email" name="testEmail" class="form-control" placeholder="nama@domain.com" required>
            <div class="input-group-append"><button class="btn btn-outline-secondary" type="submit">Submit</button></div>
        </div>
    </div>
</form>