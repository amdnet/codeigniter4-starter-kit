<?php

namespace App\Libraries;

use CodeIgniter\Config\Services;
use CodeIgniter\Email\Email;
use Exception;

class EmailLibrari
{
    protected static array $cache = [
        'hash'  => null,
        'pass'  => null,
        'email' => null,
    ];

    protected static int $cacheTime = 0;
    protected static int $ttl = 900; // auto-refresh setiap 15 menit

    /**
     * Menginisialisasi Service Email dengan konfigurasi dinamis dari database.
     *
     * @return Email instance
     */
    protected function initializeDynamicEmail(): Email
    {
        $encrypter = Services::encrypter();
        $encryptedPass = setting('App.smtpPass');
        $hash = md5($encryptedPass ?? '');

        // refresh jika TTL habis
        if (time() - self::$cacheTime > self::$ttl) {
            self::$cache['email'] = null;
            self::$cacheTime = time();
        }

        // periksa jika password berubah
        if (self::$cache['hash'] !== $hash) {
            $smtpPassAsli = '';

            if (! empty($encryptedPass)) {
                try {
                    $smtpPassAsli = $encrypter->decrypt(base64_decode($encryptedPass));
                } catch (Exception $e) {
                    log_message('error', 'Gagal mendekripsi SMTP Password: ' . $e->getMessage());
                }
            }

            self::$cache = [
                'hash'  => $hash,
                'pass'  => $smtpPassAsli,
                'email' => null,
            ];
        }

        // buat instance baru kalau belum ada
        if (! self::$cache['email'] instanceof Email) {
            $config = [
                'protocol'   => setting('App.smtpProtocol'),
                'fromEmail'  => setting('App.smtpEmail'),
                'fromName'   => setting('App.smtpNama'),
                'SMTPHost'   => setting('App.smtpHost'),
                'SMTPUser'   => setting('App.smtpUser'),
                'SMTPPass'   => self::$cache['pass'],
                'SMTPPort'   => (int) setting('App.smtpPort'),
                'SMTPCrypto' => setting('App.smtpCrypto'),
            ];

            $email = Services::email();
            $email->initialize($config);
            self::$cache['email'] = $email;
        }

        return self::$cache['email'];
    }

    /**
     * Menyimpan status pengiriman email ke tabel log_email.
     *
     * Fungsi ini tidak mempengaruhi hasil pengiriman email utama.
     * Jika proses insert log gagal, error akan dicatat ke file log CodeIgniter,
     * tetapi tidak menghentikan alur program.
     *
     * @param string $emailUser   Alamat email penerima.
     * @param string $judulEmail  Judul atau subject email.
     * @param string $statusKirim Status pengiriman email ("Berhasil" atau "Gagal").
     * @param float  $waktuRender Lama waktu proses pengiriman (dalam detik, misal 1.23).
     * @param ?string $pesanError Pesan error jika terjadi kegagalan, opsional.
     *
     * @return bool True jika log berhasil disimpan, False jika gagal insert ke database.
     */
    protected function logEmail(string $emailUser, string $judulEmail, string $statusKirim, float $waktuRender, ?string $pesanError = null): bool
    {
        $data = [
            'user_id'   => auth()->id() ?? null,
            'email'     => $emailUser,
            'judul'     => $judulEmail,
            'status'    => $statusKirim,
            'render'    => number_format($waktuRender, 2),
            'error'     => $pesanError ?: null,
            'dibuat'    => date('Y-m-d H:i:s')
        ];
        // log_message('debug', 'LogEmail data: ' . print_r($data, true));

        try {
            model('Log/LogEmailModel')->insert($data);
            return true;
        } catch (\Throwable $e) {
            log_message('error', 'Gagal insert LogEmailModel: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Pengiriman email standar dengan template tetap dan lampiran opsional.
     *
     * @param string $email Penerima email.
     * @param string $judul Judul email.
     * @param string $pesan Isi pesan email (konten sederhana).
     * @param array  $lampiran Daftar path file untuk dilampirkan.
     * @return bool True jika email berhasil dikirim, False jika gagal.
     */
    public function kirimEmailStandar(string $email, string $judul, string $pesan, array $lampiran = []): bool
    {
        $startTime  = microtime(true);
        $status     = 'Gagal';
        $pesanError = null;
        $result     = false; // default: gagal

        try {
            // --- 1. Init email ---
            $emailConfig = $this->initializeDynamicEmail();

            // --- 2. Render view ---
            $renderView = view('email/standar', [
                'judul' => $judul,
                'pesan' => $pesan,
            ], ['saveData' => true]);

            // --- 3. Attach file ---
            foreach ($lampiran as $path) {
                if (file_exists($path)) {
                    $emailConfig->attach($path);
                } else {
                    log_message('warning', "Lampiran tidak ditemukan: {$path}");
                }
            }

            // --- 4. Setup email content ---
            $emailConfig->setFrom(setting('App.smtpEmail'), setting('App.smtpNama'));
            $emailConfig->setTo($email);
            $emailConfig->setSubject($judul);
            $emailConfig->setMessage($renderView);

            // --- 5. Send email ---
            $result = $emailConfig->send(false);

            if ($result) {
                $status = 'Berhasil';
            } else {
                $pesanError = $emailConfig->printDebugger(['headers']);
                log_message('error', "Gagal mengirim email ke {$email}: {$pesanError}");
            }
        } catch (Exception $e) {
            $pesanError = $e->getMessage();
            log_message('critical', 'Kesalahan Kritis EmailLibrari->kirimEmailStandar: ' . $pesanError);
        } finally {
            // --- 6. Logging ke database ---
            $renderTime = microtime(true) - $startTime;
            $this->logEmail($email, $judul, $status, $renderTime, $pesanError);
        }

        return $result;
    }

    /**
     * Pengiriman email khusus untuk invoice.
     *
     * @param string $email Penerima email.
     * @param string $judul Judul email (misal: "Invoice #INV-00123").
     * @param array $dataInvoice Data yang digunakan untuk template email (misal: nama, total, dll).
     * @param string|null $lampiran Path ke file PDF invoice (jika ada).
     * @return bool True jika terkirim, false jika gagal.
     */
    public function kirimEmailInvoice(string $email, string $judul, array $dataInvoice, ?string $lampiran = null): bool
    {
        $startTime  = microtime(true);
        $status     = 'Gagal';
        $pesanError = null;
        $result     = false;

        try {
            $emailConfig = $this->initializeDynamicEmail();

            // Siapkan data untuk template khusus invoice
            $emailData = [
                'judul'   => $judul,
                'nama'    => $dataInvoice['nama'] ?? 'Pelanggan',
                'nomor'   => $dataInvoice['nomor'] ?? '-',
                'tanggal' => $dataInvoice['tanggal'] ?? date('d-m-Y'),
                'total'   => $dataInvoice['total'] ?? 0,
            ];

            // Render template email khusus
            $renderView = view('email/invoice', $emailData, ['saveData' => true]);

            // Lampiran PDF invoice (opsional)
            if ($lampiran && file_exists($lampiran)) {
                $emailConfig->attach($lampiran);
            }

            // Detail email
            $emailConfig->setFrom(setting('App.smtpEmail'), setting('App.smtpNama'));
            $emailConfig->setTo($email);
            $emailConfig->setSubject($judul);
            $emailConfig->setMessage($renderView);

            // Kirim email
            $result = $emailConfig->send(false);

            if ($result) {
                $status = 'Berhasil';
            } else {
                $pesanError = $emailConfig->printDebugger(['headers']);
                log_message('error', "Gagal mengirim email invoice ke {$email}: {$pesanError}");
            }
        } catch (Exception $e) {
            $pesanError = $e->getMessage();
            log_message('critical', 'Kesalahan Kritis kirimEmailInvoice: ' . $pesanError);
            $result = false;
        } finally {
            $renderTime = microtime(true) - $startTime;
            $this->logEmail($email, $judul, $status, $renderTime, $pesanError);
        }

        return $result;
    }
}
