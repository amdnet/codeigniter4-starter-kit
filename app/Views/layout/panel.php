  <?php if (panel_logo('favicon_apple_touch', true)): ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('upload/logo/' . (setting('App.logoIkon180') ?: 'ch-icon-180.png')) ?>">
  <?php endif; ?>

  <?php if (panel_logo('favicon_192', true)): ?>
    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('upload/logo/' . (setting('App.logoIkon192') ?: 'ch-favicon-192.png')) ?>">
  <?php endif; ?>

  <?php if (panel_logo('favicon_32', true)): ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('upload/logo/' . (setting('App.logoIkon32') ?: 'ch-favicon-32.png')) ?>">
  <?php endif; ?>

  <?php if (panel_logo('favicon_ico', true)): ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('upload/logo/' . (setting('App.logoIkon') ?: 'ch-favicon.ico')) ?>">
  <?php endif; ?>