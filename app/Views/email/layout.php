<?php helper('crb_telepon'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judul ?? 'Notifikasi Email') ?></title>
    <style>.email-wrapper,body{background-color:#f3f4f6}body{font-family:'Segoe UI',Arial,sans-serif;margin:0;padding:0;color:#333}.email-wrapper{width:100%;padding:30px 0}.email-container{max-width:640px;margin:0 auto;background-color:#fff;border-radius:10px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,.05)}.email-header{background:linear-gradient(135deg,#0028aa,#0038dd);color:#fff;text-align:center;padding:15px 0}.email-header img{max-width:300px}.email-header h1{margin:0;font-size:25px;letter-spacing:.5px}.email-content{padding:30px 40px;line-height:1.7;color:#444}.email-content h2{color:#0028aa;font-size:20px;margin-top:0}.email-content p{margin-bottom:15px}.email-footer{background-color:#fafafa;text-align:center;padding:20px;font-size:13px;color:#444;border-top:1px solid #e5e5e5}.email-footer a{color:#0028aa;text-decoration:none;margin:0 5px}.btn-primary{display:inline-block;font-size:14px;background-color:#0028aa;color:#fff!important;padding:7px 16px;border-radius:6px;text-decoration:none;font-weight:600;margin-top:10px}.btn-primary:hover{background-color:#001c7a}</style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <img src="<?= base_url('upload/logo/') . setting('App.logoPutih') ?>" alt="<?= esc(setting('App.siteNama')) ?>">
            </div>

            <div class="email-content">
                <?= $this->renderSection('content') ?>
            </div>

            <div class="email-footer">
                <p>Pesan ini dikirim otomatis. Mohon tidak membalas email ini.</p>
                <p>
                    <a href="<?= base_url('/') ?>">Home</a> |
                    <a href="<?= base_url('/login') ?>">Login</a> |
                    <a href="mailto:<?= setting('App.siteEmail') ?>">Email</a> |
                    <?php if ($telp = link_telp(setting('App.siteTelp'))): ?>
                        <a href="<?= $telp ?>" rel="nofollow">Telepon</a> |
                    <?php endif; ?>
                    <?php if ($wa = link_wa(setting('App.siteWa'))): ?>
                        <a href="<?= $wa ?>" target="_blank" rel="nofollow">WhatsApp</a> |
                    <?php endif; ?>
                    <?php if ($tg = link_telegram(setting('App.siteTelegram'))): ?>
                        <a href="<?= $tg ?>" target="_blank" rel="nofollow">Telegram</a> |
                    <?php endif; ?>
                </p>
                <p>&copy; <?= date('Y') ?> | <?= esc(setting('App.siteNama')) ?> - <?= esc(setting('App.siteTagline')) ?></p>
            </div>
        </div>
    </div>
</body>

</html>