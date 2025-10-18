<?= $this->extend('email/layout') ?>

<?= $this->section('content') ?>
<h2><?= lang('Auth.magicLinkSubject') ?></h2>
<title><?= lang('Auth.magicLinkSubject') ?></title>
<a href="<?= url_to('verify-magic-link') ?>?token=<?= $token ?>" class="btn-primary"><?= lang('Auth.login') ?></a>

<p><b><?= lang('Auth.emailInfo') ?></b></p>
<ul style="padding-left: 20px;">
    <li><?= lang('Auth.emailIpAddress') ?> <?= esc($ipAddress) ?></li>
    <li><?= lang('Auth.emailDevice') ?> <?= esc($userAgent) ?></li>
    <li><?= lang('Auth.emailDate') ?> <?= esc($date) ?></li>
</ul>
<?= $this->endSection() ?>