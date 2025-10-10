<?= $this->extend('layout/template.php') ?>

<?= $this->section("css") ?>
<?= $this->include('plugin/tabel_css') ?>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<section class="content">
    <div class="container-fluid">

        <div class="stat-container row">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="small-box bg-dark">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="login_total">0</h3>
                        <p>Total Login</p>
                    </div>
                    <div class="icon"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="small-box bg-success">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="login_berhasil">0</h3>
                        <p>Berhasil Login</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill-check"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="small-box bg-danger">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="login_gagal">0</h3>
                        <p>Gagal Login</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill-slash"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="small-box bg-danger">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="login_salah_email">0</h3>
                        <p>Salah Email</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill-x"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="small-box bg-danger">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="login_salah_password">0</h3>
                        <p>Salah Password</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill-x"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="small-box bg-danger">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <h3 class="stat-value" data-key="login_salah_lainnya">0</h3>
                        <p>Salah Lainnya</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-fill-x"></i></div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="info-box">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <span class="info-box-icon bg-success"><i class="bi bi-laptop"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Desktop</span>
                        <span class="stat-value info-box-number" data-key="login_desktop">0</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="info-box">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <span class="info-box-icon bg-success"><i class="bi bi-tablet"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Tablet</span>
                        <span class="stat-value info-box-number" data-key="login_tablet">0</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="info-box">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <span class="info-box-icon bg-success"><i class="bi bi-phone"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mobile</span>
                        <span class="stat-value info-box-number" data-key="login_mobile">0</span>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-3">
                <div class="info-box">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <span class="info-box-icon bg-danger"><i class="bi bi-robot"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Robot</span>
                        <span class="stat-value info-box-number" data-key="login_robot">0</span>
                    </div>
                </div>
            </div>
        </div><!-- row statistik-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabel-data" class="table table-bordered table-hover dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Status</th>
                                    <th class="desktop tablet-l">Waktu Login</th>
                                    <th class="desktop tablet-l">Tipe</th>
                                    <th class="desktop tablet-l">Nama User</th>
                                    <th class="desktop">Email User</th>
                                    <th class="desktop">IP Address</th>
                                    <th class="desktop">Perangkat</th>
                                    <th class="desktop">Sistem Operasi</th>
                                    <th class="none">Browser</th>
                                    <th class="none">Brand Model</th>
                                    <th class="none">Browser Agen</th>
                                    <th class="none">Negara</th>
                                    <th class="none">Wilayah</th>
                                    <th class="none">Distrik</th>
                                    <th class="none">Zona Waktu</th>
                                    <th class="none">ISP</th>
                                    <th class="none">Tipe Error</th>
                                    <th class="none">Info Error</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section("js") ?>
<?= $this->include('plugin/tabel_js') ?>
<script>
    const langText = {
        removeTitle: '<?= lang('App.remove-title') ?>',
        removeReset: '<?= lang('App.remove-reset') ?>',
        removeText: '<?= lang('App.remove-text') ?>'
    };
</script>
<script src="<?= base_url('page/helper_statistik.min.js') ?>" defer></script>
<script src="<?= base_url('page/user_login.min.js') ?>" defer></script>
<?= $this->endSection() ?>