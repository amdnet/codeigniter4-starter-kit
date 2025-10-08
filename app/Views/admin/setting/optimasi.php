<?= $this->extend('layout/template.php') ?>
<?= $this->section("css") ?>
<?= $this->include('plugin/tabel_css') ?>
<?= $this->endSection() ?>
<?= $this->section('konten') ?>
<section class="content">
    <div class="container-fluid">

        <div class="stat-container row">
            <div class="col-6 col-lg-3">
                <div class="small-box bg-white">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <div style="display: ruby;">
                            <h3 class="stat-value mr-1" data-key="logSize">0</h3>
                            <h4>mb</h4>
                        </div>
                        <p>
                            <span class="stat-value font-weight-bold" data-key="logCount" >0</span> → File Log Sistem
                            <span class="fz-15 ml-1" data-toggle="tooltip" data-placement="top" title="File log yang memiliki informasi seperti debug, info dan error sistem.">
                                <i class="bi bi-question-circle"></i>
                            </span>
                        </p>
                    </div>
                    <div class="icon"><i class="bi bi-file-earmark-binary"></i></div>
                    <div class="kotak-footer text-left">
                        <span class="stat-value text-dark pl-3" data-key="logTime"></span>
                        <a id="btn-hapus-log" class="float-right pr-3" role="button">Submit <i class="ml-1 bi bi-arrow-right-circle"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="small-box bg-white">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <div style="display: ruby;">
                            <h3 class="stat-value mr-1" data-key="debugSize">0</h3>
                            <h4>mb</h4>
                        </div>
                        <p>
                            <span class="stat-value font-weight-bold" data-key="debugCount">0</span> → File DebugBar
                            <span class="fz-15 ml-1" data-toggle="tooltip" data-placement="top" title="File debug-bar yang menyediakan informasi sekilas tentang permintaan halaman saat ini, termasuk hasil benchmark.">
                                <i class="bi bi-question-circle"></i>
                            </span>
                        </p>
                    </div>
                    <div class="icon"><i class="bi bi-file-earmark-lock"></i></div>
                    <div class="kotak-footer text-left">
                        <span class="stat-value text-dark pl-3" data-key="debugTime"></span>
                        <a id="btn-hapus-debug" class="float-right pr-3" role="button">Submit <i class="ml-1 bi bi-arrow-right-circle"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="small-box bg-white">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <div style="display: ruby;">
                            <h3 class="stat-value" data-key="tableCount">0</h3>
                            <h4>tabel</h4>
                        </div>
                        <p>
                            Database Optimasi
                            <span class="fz-15 ml-1" data-toggle="tooltip" data-placement="top" title="DB Optimasi → Membersihkan fragmentasi tabel → Mengembalikan ruang kosong → Mengoptimalkan kinerja query tabel database.">
                                <i class="bi bi-question-circle"></i>
                            </span>
                        </p>
                    </div>
                    <div class="icon"><i class="bi bi-database-up"></i></div>
                    <div class="kotak-footer text-left">
                        <span class="stat-value text-dark pl-3" data-key="dbOptimasiTime"></span>
                        <a id="btn-db-optimasi" class="float-right pr-3" role="button">Submit <i class="ml-1 bi bi-arrow-right-circle"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="small-box bg-white">
                    <div class="overlay dark">
                        <span class="spinner-border wh-3rem" role="status"></span>
                    </div>
                    <div class="inner">
                        <div style="display: ruby;">
                            <h3 class="stat-value mr-1" data-key="tableCount">0</h3>
                            <h4>tabel</h4>
                        </div>
                        <p>
                            Database Analisis
                            <span class="fz-15 ml-1" data-toggle="tooltip" data-placement="top" title="DB Analisis → Memperbarui statistik untuk query planner → Membantu MySQL memilih indeks terbaik saat eksekusi query">
                                <i class="bi bi-question-circle"></i>
                            </span>
                        </p>
                    </div>
                    <div class="icon"><i class="bi bi-database-check"></i></div>
                    <div class="kotak-footer text-left">
                        <span class="stat-value text-dark pl-3" data-key="dbAnalisisTime"></span>
                        <a id="btn-db-analisis" class="float-right pr-3" role="button">Submit <i class="ml-1 bi bi-arrow-right-circle"></i></a>
                    </div>
                </div>
            </div>

            <input type="hidden" data-key="dbRebuildTime">
        </div><!-- row -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="tabel-data" class="table table-bordered table-hover dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Tabel</th>
                                    <th>Baris Data</th>
                                    <th>Tipe</th>
                                    <th>Kelompok</th>
                                    <th>Ukuran</th>
                                    <th>Overhead</th>
                                    <th>Terakhir Update</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th class="text-right"></th> <!-- Baris -->
                                    <th></th> <!-- Tipe -->
                                    <th></th> <!-- Kelompok -->
                                    <th class="text-right"></th> <!-- Ukuran -->
                                    <th class="text-right"></th> <!-- Overhead -->
                                    <th></th> <!-- Terakhir Update -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section("js") ?>
<?= $this->include('plugin/validasi_js') ?>
<?= $this->include('plugin/tabel_js') ?>
<script src="<?= base_url('page/helper_statistik.min.js') ?>" defer></script>
<script src="<?= base_url('page/setting_optimasi.min.js') ?>" defer></script>
<?= $this->endSection() ?>