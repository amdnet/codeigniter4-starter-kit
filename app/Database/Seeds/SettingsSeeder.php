<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // AUTH SISTEM
            ['class' => 'Config\App', 'key' => 'authRegistration', 'value' => 'false'],
            ['class' => 'Config\App', 'key' => 'authMagicLink', 'value' => 'false'],
            ['class' => 'Config\App', 'key' => 'authRemembering', 'value' => 'true'],
            ['class' => 'Config\App', 'key' => 'authRememberLength', 'value' => '2592000'],

            // CAPTCHA
            ['class' => 'Config\App', 'key' => 'gRecaptcha', 'value' => 'false'],
            ['class' => 'Config\App', 'key' => 'gSiteKey', 'value' => 'SiteKey'],
            ['class' => 'Config\App', 'key' => 'gSecretKey', 'value' => 'SecretKey'],

            // SITUS
            ['class' => 'Config\App', 'key' => 'siteNama', 'value' => 'Nama Situs'],
            ['class' => 'Config\App', 'key' => 'siteTagline', 'value' => 'Tagline singkat situs'],
            ['class' => 'Config\App', 'key' => 'siteTelp', 'value' => '0231123456'],
            ['class' => 'Config\App', 'key' => 'siteWa', 'value' => '0812345678'],
            ['class' => 'Config\App', 'key' => 'siteTelegram', 'value' => '0812345678'],
            ['class' => 'Config\App', 'key' => 'siteEmail', 'value' => 'nama@domain.com'],
            ['class' => 'Config\App', 'key' => 'siteAlamat', 'value' => 'Kota Cirebon, Jawa Barat'],

            // LOGO
            ['class' => 'Config\App', 'key' => 'logoIkon180', 'value' => 'crb-icon-180.png'],
            ['class' => 'Config\App', 'key' => 'logoIkon192', 'value' => 'crb-icon-192.png'],
            ['class' => 'Config\App', 'key' => 'logoIkon32', 'value' => 'crb-icon-32.png'],
            ['class' => 'Config\App', 'key' => 'logoIkon', 'value' => 'crb-icon.ico'],
            ['class' => 'Config\App', 'key' => 'logoWarna', 'value' => 'crb-logo-warna.png'],
            ['class' => 'Config\App', 'key' => 'logoPutih', 'value' => 'crb-logo-putih.png'],

            // SMTP / EMAIL
            ['class' => 'Config\App', 'key' => 'smtpEmail', 'value' => 'noreply@domain.com'],
            ['class' => 'Config\App', 'key' => 'smtpNama', 'value' => 'Noreply Domain'],
            ['class' => 'Config\App', 'key' => 'smtpPenerima', 'value' => 'nama@domain.com'],
            ['class' => 'Config\App', 'key' => 'smtpProtocol', 'value' => 'smtp'],
            ['class' => 'Config\App', 'key' => 'smtpHost', 'value' => 'smtp.domain.com'],
            ['class' => 'Config\App', 'key' => 'smtpPort', 'value' => 25], // integer
            ['class' => 'Config\App', 'key' => 'smtpUser', 'value' => 'noreply@domain.com'],
            ['class' => 'Config\App', 'key' => 'smtpPass', 'value' => 'password'],
            ['class' => 'Config\App', 'key' => 'smtpCrypto', 'value' => 'tls'],

            // SOSIAL MEDIA
            ['class' => 'Config\App', 'key' => 'facebook', 'value' => 'https://facebook.com/akun'],
            ['class' => 'Config\App', 'key' => 'instagram', 'value' => 'https://instagram.com/akun'],
            ['class' => 'Config\App', 'key' => 'tiktok', 'value' => 'https://tiktok.com/akun'],
            ['class' => 'Config\App', 'key' => 'youtube', 'value' => 'https://youtube.com/akun']
        ];

        foreach ($data as $row) {
            $key = $row['class'] . '.' . $row['key'];
            $value = $row['value'];
            service('settings')->set($key, $value);
        }
    }
}

// php spark db:seed SettingsSeeder