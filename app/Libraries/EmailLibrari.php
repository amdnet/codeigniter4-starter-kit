<?php

namespace App\Libraries;

use CodeIgniter\Config\Services;
use CodeIgniter\Email\Email;

class EmailLibrari
{
    /**
     * Menginisialisasi Service Email dengan konfigurasi dinamis dari database.
     *
     * @return Email instance
     */
    protected function initializeDynamicEmail(): Email
    {
        // Pastikan helper 'setting' tersedia
        if (! function_exists('setting')) {
            helper('setting');
        }

        $encrypter = Services::encrypter();
        $encryptedPass = setting('App.smtpPass');
        $smtpPassAsli = '';

        // Pastikan password ada dan bisa didekripsi
        if (! empty($encryptedPass)) {
            try {
                // Hati-hati dengan error dekripsi jika key berubah
                $smtpPassAsli = $encrypter->decrypt(base64_decode($encryptedPass));
            } catch (\Exception $e) {
                // Log the error but continue with empty password, or throw a specific exception
                log_message('error', 'Gagal mendekripsi SMTP Password: ' . $e->getMessage());
            }
        }

        // Buat array konfigurasi dinamis
        $config = [
            'protocol'   => setting('App.smtpProtocol', 'smtp'),
            'fromEmail'  => setting('App.smtpEmail', 'noreply@default.com'),
            'fromName'   => setting('App.smtpNama', 'No Reply Default'),
            'SMTPHost'   => setting('App.smtpHost', ''), // Kosongkan jika ingin force error jika DB kosong
            'SMTPUser'   => setting('App.smtpUser', ''),
            'SMTPPass'   => $smtpPassAsli, // Sudah didekripsi
            'SMTPPort'   => (int)setting('App.smtpPort', 587),
            'SMTPCrypto' => setting('App.smtpCrypto', 'tls'),
            'mailType'   => 'html',
            'charset'    => 'UTF-8',
        ];

        // Ambil instance Email dan inisialisasi dengan konfigurasi kustom
        // $email = Services::email();
        $email = new Email(config('Email'));
        $email->initialize($config);

        return $email;
    }

    /**
     * Mengirim email menggunakan konfigurasi dari database.
     *
     * @param string $to Penerima email
     * @param string $subject Judul email
     * @param string $message Isi pesan email (HTML/Text)
     * @param string $altMessage Pesan alternatif jika mailType text
     * @return bool Status pengiriman
     */
    public function sendEmail(string $to, string $subject, string $message, ?string $altMessage = null): bool
    {
        $email = $this->initializeDynamicEmail();

        $email->setFrom(setting('App.smtpEmail', 'noreply@default.com'), setting('App.smtpNama', 'No Reply Default'));
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);

        // Jika Anda memiliki pesan teks alternatif, atur di sini
        if ($altMessage) {
            $email->setAltMessage($altMessage);
        }

        return $email->send(false); // Parameter false agar tidak menampilkan debugger otomatis
    }
}
