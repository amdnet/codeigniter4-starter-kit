<?= $this->extend('layout/template.php') ?>

<?= $this->section("css") ?>
<?= $this->include('plugin/tabel_css') ?>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<section class="content">
    <div class="container-fluid">

        <div class="stat-container row">
            <div class="col-12 col-md-4 col-lg col-5">
                <div class="small-box bg-dark">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="user_total">0</h3>
                        <p>Total User</p>
                    </div>
                    <div class="icon"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg col-5">
                <div class="small-box bg-primary">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="user_aktif">0</h3>
                        <p>User Aktif</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill-check"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg col-5">
                <div class="small-box bg-danger">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="user_nonaktif">0</h3>
                        <p>User Nonaktif</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill-slash"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg col-5">
                <div class="small-box bg-success">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="user_admin">0</h3>
                        <p>User Admin</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg col-5">
                <div class="small-box bg-success">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="user_klien">0</h3>
                        <p>User Klien</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill"></i></div>
                </div>
            </div>
        </div><!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabel-data" class="table table-bordered table-hover dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama User</th>
                                    <th>Alamat Email</th>
                                    <th>Status</th>
                                    <th>Hak Akses</th>
                                    <th class="desktop">Terakhir Login</th>
                                    <th class="desktop">Waktu Dibuat</th>
                                    <th class="desktop">Waktu Dirubah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="modal-div" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary d-flex justify-content-center">
                <h5 class="modal-title"></h5>
            </div>

            <form id="form-data" class="pl-3 pr-3" data-cek="true">
                <div class="modal-body">
                    <input type="hidden" id="iduser" name="iduser">
                    <input type="hidden" id="idprofil" name="idprofil">

                    <div class="row">
                        <!-- akun -->
                        <div class="col-md-6">
                            <div class="my-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Nama Lengkap" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Alamat Email" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span onclick="cekpwd()" class="input-group-text ikon" style="cursor:pointer"><i class="bi bi-eye-fill"></i></span>
                                    </div>
                                    <input type="password" id="password" name="password" class="form-control passwd" placeholder="Password">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span onclick="cekpwd()" class="input-group-text ikon" style="cursor:pointer"><i class="bi bi-eye-fill"></i></span>
                                    </div>
                                    <input type="password" id="password_confirm" name="password_confirm" class="form-control passwd" placeholder="Ulangi Password">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="aktivasi"> Status <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="bi bi-person-fill-check"></i></label>
                                        </div>
                                        <select id="aktivasi" name="aktivasi" class="form-control">
                                            <option value="1">Aktif</option>
                                            <option value="0">Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="akses"> Hak Akses <span class="text-danger">*</span></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="bi bi-person-fill-gear"></i></label>
                                        </div>
                                        <select id="akses" name="akses" class="form-control">
                                            <option value="klien">Klien</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- profil -->
                        <div class="col-md-6">
                            <div class="my-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-building-fill"></i></span>
                                    </div>
                                    <input type="text" class="form-control upper" id="perusahaan" name="perusahaan" placeholder="Perusahaan">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Whatsapp">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-telegram"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="telegram" name="telegram" placeholder="Telegram">
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-house-fill"></i></span>
                                    </div>
                                    <input type="text" class="form-control upper" id="alamat" name="alamat" placeholder="Alamat">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btn-submit" class="btn btn-primary mr-1 float-right">Simpan</button>
                        <button type="button" id="btn-loading" class="btn btn-primary" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="button" id="btn-close" class="btn btn-danger float-right" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section("js") ?>
<?= $this->include('plugin/validasi_js') ?>
<?= $this->include('plugin/tabel_js') ?>
<script src="<?= base_url('page/helper_statistik.min.js') ?>" defer></script>
<script src="<?= base_url('page/user_list.min.js') ?>" defer></script>
<?= $this->endSection() ?>