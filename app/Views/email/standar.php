<?= $this->extend('email/layout') ?>

<?= $this->section('content') ?>
<h2><?= esc($judul ?? 'Notifikasi Email') ?></h2>
<p>Halo,</p>
<p><?= nl2br(esc($pesan ?? 'Halo, ini adalah pesan tes dari CodeIgniter 4 menggunakan konfigurasi SMTP dari Librari!')) ?></p>

<p>Terima kasih atas perhatian Anda.</p>

<a href="<?= base_url() ?>" class="btn-primary">Kunjungi Situs</a>
<?= $this->endSection() ?>