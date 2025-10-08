<?= $this->extend('layout/template.php') ?>

<?= $this->section("css") ?>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            
            <div class="col-md-7 mb-4">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#sistem" data-toggle="tab">Sistem</a></li>
                            <li class="nav-item"><a class="nav-link" href="#situs" data-toggle="tab">Situs</a></li>
                            <li class="nav-item"><a class="nav-link" href="#logo" data-toggle="tab">Logo</a></li>
                            <li class="nav-item"><a class="nav-link" href="#smtp" data-toggle="tab">Smtp</a></li>
                            <li class="nav-item"><a class="nav-link" href="#recaptcha" data-toggle="tab">Recaptcha</a></li>
                        </ul>
                    </div><!-- /.card-header -->

                    <div class="card-body">
                        <div class="tab-content">

                            <!-- sistem -->
                            <div class="tab-pane active fade show" id="sistem">
                                <?= $this->include('admin/setting/umum/sistem') ?>
                            </div>
                            <!-- /.tab-pane situs -->

                            <!-- situs -->
                            <div class="tab-pane fade" id="situs">
                                <?= $this->include('admin/setting/umum/situs') ?>
                            </div>
                            <!-- /.tab-pane situs -->

                            <!-- logo -->
                            <div class="tab-pane fade" id="logo">
                                <?= $this->include('admin/setting/umum/logo') ?>
                            </div>
                            <!-- /.tab-pane logo -->

                            <!-- smtp -->
                            <div class="tab-pane fade" id="smtp">
                                <?= $this->include('admin/setting/umum/smtp') ?>
                            </div>
                            <!-- /.tab-pane smtp -->

                            <!-- recaptcha -->
                            <div class="tab-pane fade" id="recaptcha">
                                <?= $this->include('admin/setting/umum/recaptcha') ?>
                            </div>
                            <!-- /.tab-pane recaptcha -->

                        </div> <!-- /.tab-content -->
                    </div> <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section("js") ?>
<?= $this->include('plugin/validasi_js') ?>
<script src="<?= base_url('page/helper_form.min.js') ?>" defer></script>
<script src="<?= base_url('page/setting_umum.min.js') ?>" defer></script>
<script src="<?= base_url('plugin/pica/pica.min.js') ?>" defer></script>
<script src="<?= base_url('page/upload_gambar_multi.min.js') ?>" defer></script>
<?= $this->endSection() ?>