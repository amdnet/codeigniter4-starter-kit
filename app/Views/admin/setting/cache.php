<?= $this->extend('layout/template.php') ?>

<?= $this->section("css") ?>
<?= $this->include('plugin/tabel_css') ?>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<section class="content">
    <div class="container-fluid">
        <!-- <div class="row justify-content-md-center"> -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Durasi Cache</h3>
                    </div>
                    <div class="card-body">

                        <form id="cache-form" data-cek="true">
                            <!-- Cache Geo IP -->
                            <div class="form-group row">
                                <label for="cache_geoip" class="col-12 col-lg-4 col-form-label">User Geo IP</label>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="bi bi-alarm"></i></label>
                                        </div>
                                        <select id="cache_geoip" name="cache_geoip" class="form-control">
                                            <option value="3600" <?= $durasiCache['cache_geoip'] == 3600 ? 'selected' : '' ?>>Satu Jam</option>
                                            <option value="21600" <?= $durasiCache['cache_geoip'] == 21600 ? 'selected' : '' ?>>Enam Jam</option>
                                            <option value="43200" <?= $durasiCache['cache_geoip'] == 43200 ? 'selected' : '' ?>>Dua Belas Jam</option>
                                            <option value="86400" <?= $durasiCache['cache_geoip'] == 86400 ? 'selected' : '' ?>>Satu Hari</option>
                                            <option value="604800" <?= $durasiCache['cache_geoip'] == 604800 ? 'selected' : '' ?>>Satu Minggu</option>
                                            <option value="2592000" <?= $durasiCache['cache_geoip'] == 2592000 ? 'selected' : '' ?>>Satu Bulan</option>
                                            <option value="31536000" <?= $durasiCache['cache_geoip'] == 31536000 ? 'selected' : '' ?>>Satu Tahun</option>
                                            <option value="0" <?= $durasiCache['cache_geoip'] == 0 ? 'selected' : '' ?>>Lifetime</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Cache Device Detector -->
                            <div class="form-group row">
                                <label for="cache_device" class="col-12 col-lg-4 col-form-label">User Device</label>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="bi bi-alarm"></i></label>
                                        </div>
                                        <select id="cache_device" name="cache_device" class="form-control">
                                            <option value="3600" <?= $durasiCache['cache_device'] == 3600 ? 'selected' : '' ?>>Satu Jam</option>
                                            <option value="21600" <?= $durasiCache['cache_device'] == 21600 ? 'selected' : '' ?>>Enam Jam</option>
                                            <option value="43200" <?= $durasiCache['cache_device'] == 43200 ? 'selected' : '' ?>>Dua Belas Jam</option>
                                            <option value="86400" <?= $durasiCache['cache_device'] == 86400 ? 'selected' : '' ?>>Satu Hari</option>
                                            <option value="604800" <?= $durasiCache['cache_device'] == 604800 ? 'selected' : '' ?>>Satu Minggu</option>
                                            <option value="2592000" <?= $durasiCache['cache_device'] == 2592000 ? 'selected' : '' ?>>Satu Bulan</option>
                                            <option value="31536000" <?= $durasiCache['cache_device'] == 31536000 ? 'selected' : '' ?>>Satu Tahun</option>
                                            <option value="0" <?= $durasiCache['cache_device'] == 0 ? 'selected' : '' ?>>Lifetime</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Cache Statistik User List -->
                            <div class="form-group row">
                                <label for="statistik_user_list" class="col-12 col-lg-4 col-form-label">Stat User List</label>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="bi bi-alarm"></i></label>
                                        </div>
                                        <select id="statistik_user_list" name="statistik_user_list" class="form-control">
                                            <option value="3600" <?= $durasiCache['statistik_user_list'] == 3600 ? 'selected' : '' ?>>Satu Jam</option>
                                            <option value="21600" <?= $durasiCache['statistik_user_list'] == 21600 ? 'selected' : '' ?>>Enam Jam</option>
                                            <option value="43200" <?= $durasiCache['statistik_user_list'] == 43200 ? 'selected' : '' ?>>Dua Belas Jam</option>
                                            <option value="86400" <?= $durasiCache['statistik_user_list'] == 86400 ? 'selected' : '' ?>>Satu Hari</option>
                                            <option value="604800" <?= $durasiCache['statistik_user_list'] == 604800 ? 'selected' : '' ?>>Satu Minggu</option>
                                            <option value="2592000" <?= $durasiCache['statistik_user_list'] == 2592000 ? 'selected' : '' ?>>Satu Bulan</option>
                                            <option value="31536000" <?= $durasiCache['statistik_user_list'] == 31536000 ? 'selected' : '' ?>>Satu Tahun</option>
                                            <option value="0" <?= $durasiCache['statistik_user_list'] == 0 ? 'selected' : '' ?>>Lifetime</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Cache Statistik User Login -->
                            <div class="form-group row">
                                <label for="statistik_user_login" class="col-12 col-lg-4 col-form-label">Stat User Login</label>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text"><i class="bi bi-alarm"></i></label>
                                        </div>
                                        <select id="statistik_user_login" name="statistik_user_login" class="form-control">
                                            <option value="3600" <?= $durasiCache['statistik_user_login'] == 3600 ? 'selected' : '' ?>>Satu Jam</option>
                                            <option value="21600" <?= $durasiCache['statistik_user_login'] == 21600 ? 'selected' : '' ?>>Enam Jam</option>
                                            <option value="43200" <?= $durasiCache['statistik_user_login'] == 43200 ? 'selected' : '' ?>>Dua Belas Jam</option>
                                            <option value="86400" <?= $durasiCache['statistik_user_login'] == 86400 ? 'selected' : '' ?>>Satu Hari</option>
                                            <option value="604800" <?= $durasiCache['statistik_user_login'] == 604800 ? 'selected' : '' ?>>Satu Minggu</option>
                                            <option value="2592000" <?= $durasiCache['statistik_user_login'] == 2592000 ? 'selected' : '' ?>>Satu Bulan</option>
                                            <option value="31536000" <?= $durasiCache['statistik_user_login'] == 31536000 ? 'selected' : '' ?>>Satu Tahun</option>
                                            <option value="0" <?= $durasiCache['statistik_user_login'] == 0 ? 'selected' : '' ?>>Lifetime</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Baris 3: Tombol -->
                            <div class="form-group row">
                                <div class="col-sm-12 text-right">
                                    <button type="button" id="cache-loading" class="btn btn-secondary" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button type="submit" id="cache-submit" class="btn btn-secondary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Cache</h3>
                    </div>
                    <div class="card-body">
                        <table id="tabel-data" class="table table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <th class="all">No.</th>
                                    <th class="all">Tipe</th>
                                    <th class="all">Durasi</th>
                                    <th class="min-tablet-l">Cache Berakhir</th>
                                    <th class="desktop">Cache Dibuat</th>
                                    <th class="none">Nama File</th>
                                    <th class="none">Cache TTL</th>
                                    <th class="min-tablet-l">Aksi</th>
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
<?= $this->include('plugin/validasi_js') ?>
<?= $this->include('plugin/tabel_js') ?>
<script src="<?= base_url('page/setting_cache.min.js') ?>" defer></script>
<?= $this->endSection() ?>