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
                <div style="border-bottom: 1px solid rgba(0,0,0,.125);" class="my-3"></div>
                <p class="mb-1"><a href="<?= url_to('login') ?>">Kembali ke login</a></p>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>