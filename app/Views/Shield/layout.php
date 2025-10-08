<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Aplikasi yang dibuat khusus untuk Cirebon Web" />
    <meta name="author" content="www.cirebonweb.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?= csrf_meta() ?>

    <?= $this->renderSection('judul') ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('upload/logo/' . (setting('App.logoIkon') ?: 'ch-favicon.ico')) ?>" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="<?= base_url('plugin/bootstrap/icheck-bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>" />
    <style>
        body {
            background-color: #e6eaef;
            background-image: url("data:image/svg+xml,%3csvg%20width='1512'%20height='783'%20viewBox='0%200%201512%20783'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cg%20clip-path='url(%23clip0_624_1517)'%3e%3cg%20filter='url(%23filter0_f_624_1517)'%3e%3cpath%20d='M564.056%20408V201C962.284%20201%201285.11%20293.677%201285.11%20408H564.056Z'%20fill='url(%23paint0_linear_624_1517)'/%3e%3cpath%20d='M564.057%20408V615C165.828%20615%20-157%20522.323%20-157%20408H564.057Z'%20fill='url(%23paint1_linear_624_1517)'/%3e%3c/g%3e%3c/g%3e%3cdefs%3e%3cfilter%20id='filter0_f_624_1517'%20x='-407'%20y='-49'%20width='1942.11'%20height='914'%20filterUnits='userSpaceOnUse'%20color-interpolation-filters='sRGB'%3e%3cfeFlood%20flood-opacity='0'%20result='BackgroundImageFix'/%3e%3cfeBlend%20mode='normal'%20in='SourceGraphic'%20in2='BackgroundImageFix'%20result='shape'/%3e%3cfeGaussianBlur%20stdDeviation='125'%20result='effect1_foregroundBlur_624_1517'/%3e%3c/filter%3e%3clinearGradient%20id='paint0_linear_624_1517'%20x1='924.584'%20y1='408'%20x2='924.584'%20y2='201'%20gradientUnits='userSpaceOnUse'%3e%3cstop%20stop-color='%23008FD6'/%3e%3cstop%20offset='1'%20stop-color='%2301A3F4'/%3e%3c/linearGradient%3e%3clinearGradient%20id='paint1_linear_624_1517'%20x1='203.528'%20y1='615'%20x2='203.528'%20y2='408'%20gradientUnits='userSpaceOnUse'%3e%3cstop%20stop-color='%23008FD6'/%3e%3cstop%20offset='1'%20stop-color='%2301A3F4'/%3e%3c/linearGradient%3e%3cclipPath%20id='clip0_624_1517'%3e%3crect%20width='1512'%20height='783'%20fill='white'/%3e%3c/clipPath%3e%3c/defs%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover
        }

        .pesan {
            border: 1px solid #bbb;
        }

        .peringatan {
            color: #c01b2cff;
            border: 1px solid #d32535;
        }

        .pesan,
        .peringatan {
            font-size: 15px;
            line-height: 20px;
            border-radius: 5px;
            padding: 5px 10px
        }

        .input-group-text {
            border: none;
        }
    </style>
</head>

<?= $this->renderSection('konten') ?>

<script src="<?= base_url('plugin/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('plugin/bootstrap/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('dist/js/adminlte.min.js') ?>"></script>
<?= $this->renderSection('js') ?>
</body>

</html>