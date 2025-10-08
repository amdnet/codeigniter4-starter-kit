<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="description" content="<?= setting('App.siteTagline') ?>" />
  <meta name="author" content="www.cirebonweb.com" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="robots" content="noindex,nofollow" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="csrf-token" content="<?= csrf_hash() ?>" />

  <title><?= esc($pageTitle) . ' | ' . setting('App.siteNama') ?></title>
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('upload/logo/' . (setting('App.logoIkon180') ?: 'crb-icon-180.png')) ?>">
  <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('upload/logo/' . (setting('App.logoIkon192') ?: 'crb-icon-192.png')) ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('upload/logo/' . (setting('App.logoIkon32') ?: 'crb-icon-32.png')) ?>">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('upload/logo/' . (setting('App.logoIkon') ?: 'crb-icon.ico')) ?>">
  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" as="style" />
  <link rel="preload" href="<?= base_url('dist/css/adminlte.min.css') ?>" as="style" />
  <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('plugin/sweetalert/sweetalert2.min.css') ?>" />
  <?= $this->renderSection('css') ?>
  <link rel="stylesheet" href="<?= base_url('dist/css/custom.min.css') ?>" />
</head>

<body class="hold-transition sidebar-mini">

  <!-- loading modal bootstrap -->
  <div class="modal fade" id="progressModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center">
        <div class="modal-body">
          <div class="progress" style="height: 35px;font-size: 14px">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%">0 %</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="wrapper">
    <!-- Preloader -->
    <!-- https://icon-sets.iconify.design/svg-spinners/ -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24">
        <rect width="10" height="10" x="1" y="1" fill="currentColor" rx="1">
          <animate id="SVG7WybndBt" fill="freeze" attributeName="x" begin="0;SVGo3aOUHlJ.end" dur="0.2s" values="1;13" />
          <animate id="SVGVoKldbWM" fill="freeze" attributeName="y" begin="SVGFpk9ncYc.end" dur="0.2s" values="1;13" />
          <animate id="SVGKsXgPbui" fill="freeze" attributeName="x" begin="SVGaI8owdNK.end" dur="0.2s" values="13;1" />
          <animate id="SVG7JzAfdGT" fill="freeze" attributeName="y" begin="SVG28A4To9L.end" dur="0.2s" values="13;1" />
        </rect>
        <rect width="10" height="10" x="1" y="13" fill="currentColor" rx="1">
          <animate id="SVGUiS2jeZq" fill="freeze" attributeName="y" begin="SVG7WybndBt.end" dur="0.2s" values="13;1" />
          <animate id="SVGU0vu2GEM" fill="freeze" attributeName="x" begin="SVGVoKldbWM.end" dur="0.2s" values="1;13" />
          <animate id="SVGOIboFeLf" fill="freeze" attributeName="y" begin="SVGKsXgPbui.end" dur="0.2s" values="1;13" />
          <animate id="SVG14lAaeuv" fill="freeze" attributeName="x" begin="SVG7JzAfdGT.end" dur="0.2s" values="13;1" />
        </rect>
        <rect width="10" height="10" x="13" y="13" fill="currentColor" rx="1">
          <animate id="SVGFpk9ncYc" fill="freeze" attributeName="x" begin="SVGUiS2jeZq.end" dur="0.2s" values="13;1" />
          <animate id="SVGaI8owdNK" fill="freeze" attributeName="y" begin="SVGU0vu2GEM.end" dur="0.2s" values="13;1" />
          <animate id="SVG28A4To9L" fill="freeze" attributeName="x" begin="SVGOIboFeLf.end" dur="0.2s" values="1;13" />
          <animate id="SVGo3aOUHlJ" fill="freeze" attributeName="y" begin="SVG14lAaeuv.end" dur="0.2s" values="1;13" />
        </rect>
      </svg>
    </div>

    <?= $this->include('layout/navbar'); ?>
    <?= $this->include('layout/sidebar'); ?>

    <div class="content-wrapper">
      <!-- awal judul halaman -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1><?= $pageTitle ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <?php $home_link = (auth()->user()->inGroup('klien')) ? 'klien' : 'admin'; ?>
                <li class="breadcrumb-item"><a href="<?= base_url($home_link) ?>">Home</a></li>
                <li class="breadcrumb-item active"><?= $navigasi . '→ &nbsp;' . ($navTitle ?? $pageTitle) ?></li>
              </ol>
            </div>
          </div>
        </div>
      </section>

      <!-- awal konten -->
      <?= $this->renderSection('konten') ?>
    </div>

    <footer class="main-footer d-flex flex-column flex-md-row justify-content-between align-items-center">
      <div class="text-center text-md-left">
        Copyright &copy; 2014 - <?= date("Y"); ?> | All rights reserved. <br>
        <a href="/"><?= setting('App.siteNama') . ' - ' . setting('App.siteTagline') ?></a>

      </div>

      <div class="text-center text-md-right">
        Versi 1.0.50 <br>
        Render: <span id="microtime"></span> detik. <br>
      </div>
    </footer>

  </div>

  <script src="<?= base_url('plugin/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('plugin/bootstrap/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
  <script src="<?= base_url('plugin/sweetalert/sweetalert2.min.js') ?>" defer></script>
  <script src="<?= base_url('page/beranda.min.js') ?>" defer></script>
  <?= $this->renderSection('js') ?>
  <script>
    $(document).ready(function() {
    <?php if (session()->getFlashdata('sukses')): ?>
    Swal.fire({title:'Sukses',html:'<?= session()->getFlashdata('sukses') ?>',icon:'success'});
    <?php elseif (session()->getFlashdata('error')): ?>
    Swal.fire({title:'Error',html:'<?= session()->getFlashdata('error') ?>',icon:'error'});
    <?php elseif (session()->getFlashdata('errors')): ?>
    <?php $errors = session()->getFlashdata('errors');if(!is_array($errors)){$errors = [$errors];}?>
    let errors = '<?= implode('<br>', $errors) ?>';
    Swal.fire({title:'Error Validasi',html: errors,icon:'error'});
    <?php endif; ?>
    });
    window.addEventListener("load",(function(){const renderTime=performance.now();document.getElementById("microtime").textContent=(renderTime/1e3).toFixed(2)}));;
  </script>

</body>

</html>
<!-- Penggunaan memori: <?= number_format(memory_get_usage() / 1048576, 2) ?> mb -->
<!-- Waktu eksekusi server: {elapsed_time} detik -->
<!-- Waktu render framework: <?= number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 4) ?> detik -->
<!-- Versi framwork: <?= \CodeIgniter\CodeIgniter::CI_VERSION ?> -->