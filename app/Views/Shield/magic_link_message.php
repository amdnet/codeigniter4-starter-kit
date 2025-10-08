<?= $this->extend(config('Auth')->views['layout']) ?>
<?= $this->section('judul') ?>
<title><?= lang('Auth.useMagicLink') . ' | ' . setting('App.siteNama') ?></title>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline rounded-lg">
            <?= $this->include('Shield/logo') ?>

            <div class="card-body">
                <p><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>