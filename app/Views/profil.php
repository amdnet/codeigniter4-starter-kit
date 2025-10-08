<?= $this->extend('layout/template.php') ?>

<?= $this->section("css") ?>
<?= $this->include('plugin/tabel_css') ?>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-md-center">

            <!-- Foto profile -->
            <div class="col-md-4 col-lg-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <form action="<?= base_url('profil/update-foto'); ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" id="id_user" name="id_user" value="<?= $userId ?>">
                            <input type="hidden" id="id_profil" name="id_profil" value="<?= $user->id_profil ?>">

                            <div class="unggah" data-max-width="215">
                                <div class="loadingSpinner">⏳ <span class="ml-2">Memproses gambar...</span></div>

                                <div class="text-center">
                                    <img id="preview_foto_profil" class="img-fluid p-2 border border-primary rounded" src="<?= base_url('upload/profil/') . $foto ?>" style="max-width: 215px;">
                                </div>

                                <h3 class="profile-username text-center"><?= $user->username ?></h3>
                                <p class="text-center mt-n1"><?= $user->email ?></p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item"><b>Tanggal Daftar</b> <a class="float-right"><?= date("d M Y → H:i:s", strtotime($user->created_at)) ?></a></li>
                                    <li class="list-group-item"><b>Terakhir Login</b> <a class="float-right"><?= date("d M Y → H:i:s", strtotime($user->last_used_at)) ?></a></li>
                                    <li class="list-group-item text-center"><b>Upload foto profil</b> <span class="ml-2" data-toggle="tooltip" data-placement="top" title="Dimensi foto ideal 215 x 215 px. Format foto: .jpg .jpeg .png" style="font-size: 15px;"><i class="bi bi-question-circle"></i></span></li>
                                </ul>

                                <input type="file" class="form-control-file mt-2" id="foto_profil" name="foto_profil" accept=".jpg,.jpeg,.png">
                                <div id="info_foto_profil" class="info-kecil mt-2"><small>maksimal ukuran foto 1 MB.</small></div>

                                <div class="mt-2"><button type="submit" class="btn btn-sm btn-secondary btn-block">Update foto profil</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tab Konten -->
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <?php if (auth()->id() === $userId): ?>
                                <li class="nav-item"><a class="nav-link active" href="#sesi" data-toggle="tab">Sesi</a></li>
                                <li class="nav-item"><a class="nav-link" href="#akun" data-toggle="tab">Akun</a></li>
                            <?php else: ?>
                                <li class="nav-item"><a class="nav-link active" href="#akun" data-toggle="tab">Akun</a></li>
                            <?php endif; ?>
                            <li class="nav-item"><a class="nav-link" href="#info" data-toggle="tab">Info</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">

                            <!-- sesi perangkat -->
                            <?php if (auth()->id() === $userId): ?>
                                <div class="tab-pane active fade show" id="sesi">
                                    <div id="sesi-list-container"></div>
                                    <div id="sesi-pagination-container" class="mt-4 d-flex justify-content-center"></div>
                                    <div class="text-right mt-4">
                                        <form id="sesi-form">
                                            <button type="submit" id="btn-hapus-sesi" class="btn btn-dark">
                                                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" style="display: none;"></span>
                                                <span class="btn-text">Keluar dari perangkat lain</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- akun -->
                            <div class="<?= $tabPane ?>" id="akun">
                                <form id="akun-form" data-cek="true">
                                    <input type="hidden" id="id_user" name="id_user" value="<?= $userId ?>">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user->username) ?>" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                                    </div>
                                                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user->email) ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span onclick="cekpwd()" class="input-group-text ikon" style="cursor:pointer"><i class="bi bi-eye-fill"></i></span>
                                                    </div>
                                                    <input type="password" id="password" name="password" class="form-control passwd" placeholder="Password">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Kosongkan password jika tidak ada perubahan."><i class="bi bi-question-circle"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span onclick="cekpwd()" class="input-group-text ikon" style="cursor:pointer"><i class="bi bi-eye-fill"></i></span>
                                                    </div>
                                                    <input type="password" id="password_confirm" name="password_confirm" class="form-control passwd" placeholder="Ulangi Password">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" data-toggle="tooltip" data-placement="top" title="Kosongkan password jika tidak ada perubahan."><i class="bi bi-question-circle"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" id="akun-submit" class="btn btn-dark mr-1 float-right">Simpan</button>
                                            <button type="button" id="akun-loading" class="btn btn-dark float-right" disabled>
                                                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div><!-- /.tab-pane akun -->

                            <!-- info -->
                            <div class="tab-pane fade" id="info">
                                <form id="info-form" data-cek="true">
                                    <input type="hidden" id="id_user" name="id_user" value="<?= $userId ?>">
                                    <input type="hidden" id="id_profil" name="id_profil" value="<?= $user->id_profil ?>">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control upper" id="perusahaan" name="perusahaan" placeholder="Perusahaan" value="<?= old('perusahaan', $user->perusahaan) ?>">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Whatsapp" value="<?= old('whatsapp', $user->whatsapp) ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="bi bi-telegram"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" id="telegram" name="telegram" placeholder="Telegram" value="<?= old('telegram', $user->telegram) ?>">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control upper" id="alamat" name="alamat" placeholder="Alamat" value="<?= old('alamat', $user->alamat) ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" id="info-submit" class="btn btn-dark mr-1 float-right">Simpan</button>
                                            <button type="button" id="info-loading" class="btn btn-dark float-right" disabled>
                                                <span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span>
                                                Loading...
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.tab-pane info -->

                        </div><!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
            </div>

        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section("js") ?>

<script>
    const $urlLogoutPerangkat = "<?= base_url($url . '/logout-perangkat') ?>";
    const $urlAkun = "<?= base_url($url . '/update-akun') ?>";
    const $urlInfo = "<?= base_url($url . '/update-info') ?>";

    let isPemilikProfil;
    <?php if (auth()->id() === $userId): ?>
        const $urlGetPerangkat = "<?= base_url($url . '/get-perangkat') ?>";
        isPemilikProfil = true;
    <?php else: ?>
        isPemilikProfil = false;
    <?php endif; ?>
</script>

<?= $this->include('plugin/validasi_js') ?>
<script src="<?= base_url('page/helper_form.min.js') ?>" defer></script>
<script src="<?= base_url('page/profil.min.js') ?>" defer></script>
<script src="<?= base_url('plugin/pica/pica.min.js') ?>" defer></script>
<script src="<?= base_url('page/upload_gambar.min.js') ?>" defer></script>
<?= $this->endSection() ?>