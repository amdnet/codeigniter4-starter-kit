<?php

namespace App\Libraries;

use CodeIgniter\Config\Services;
use CodeIgniter\Email\Email;
use Exception;

class EmailLibrari
{
    /**
     * Menginisialisasi Service Email dengan konfigurasi dinamis dari database.
     *
     * @return Email instance
     */
    protected function configEmail(): Email
    {
        $config = [
            'protocol'   => setting('App.smtpProtocol'),
            'SMTPHost'   => setting('App.smtpHost'),
            'SMTPUser'   => setting('App.smtpUser'),
            'SMTPPass'   => setting('App.smtpPass'),
            'SMTPPort'   => setting('App.smtpPort'),
            'SMTPCrypto' => setting('App.smtpCrypto'),
            'mailType'   => 'html',
            'charset'    => 'UTF-8',
            'CRLF'       => "\r\n",
            'newline'    => "\r\n",
        ];

        $email = Services::email($config);
        $email->setFrom(setting('App.smtpEmail'), setting('App.smtpNama'));

        return $email;
    }

    /**
     * Fungsi utama kirim email generik (master).
     * Bisa digunakan untuk semua jenis email (manual, otomatis, sistem Shield, dll).
     *
     * @param string $email Tujuan email
     * @param string $judul Subjek email
     * @param string $body Konten pesan dan template email (default HTML)
     * @param ?array $lampiran Daftar file path (opsional)
     * @return bool True jika terkirim, false jika gagal
     */
    public function kirimEmail(string $email, string $judul, string $body, ?array $lampiran = null): bool
    {
        $awalRender = microtime(true);
        $status = 'Gagal';
        $pesanError = null;
        $result = false;

        $emailConfig = $this->configEmail();

        try {
            $emailConfig->setTo($email);
            $emailConfig->setSubject($judul);
            $emailConfig->setMessage($body);

            // === Proses lampiran kalau ada ===
            if (! empty($lampiran)) {
                foreach ($lampiran as $file) {
                    if (is_file($file)) {
                        $emailConfig->attach($file);
                    } else {
                        log_message('warning', "Lampiran tidak ditemukan: {$file}");
                    }
                }
            }

            $result = $emailConfig->send(false);

            if ($result) {
                $status = 'Berhasil';
            } else {
                $pesanError = $emailConfig->printDebugger(['headers']);
                log_message('error', "Gagal mengirim email ke {$email}: {$pesanError}");
            }
        } catch (Exception $e) {
            $pesanError = $e->getMessage();
            log_message('critical', 'Kesalahan Kritis kirimEmail: ' . $pesanError);
        } finally {
            $waktuRender = microtime(true) - $awalRender;
            $this->logEmail($email, $judul, $status, $waktuRender, $pesanError);
        }

        $emailConfig->clear();
        return $result;
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
     * @param ?string $pesanError Pesan error jika terjadi kegagalan (opsional).
     *
     * @return bool True jika log berhasil disimpan, False jika gagal insert ke database.
     */
    protected function logEmail(string $emailUser, string $judulEmail, string $statusKirim, float $waktuRender, ?string $pesanError = null): bool
    {
        $data = [
            'admin'     => auth()->user()->username ?? 'Sistem',
            'email'     => $emailUser,
            'judul'     => $judulEmail,
            'status'    => $statusKirim,
            'render'    => number_format($waktuRender, 2),
            'error'     => $pesanError ?: null,
            'dibuat'    => date('Y-m-d H:i:s')
        ];

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
     * @param ?array  $lampiran Daftar path file untuk dilampirkan.
     * @return bool True jika email berhasil dikirim, False jika gagal.
     */
    public function emailStandar(string $email, string $judul, string $pesan, ?array $lampiran = null): bool
    {
        $body = view('email/standar', [
            'judul' => $judul,
            'pesan' => $pesan,
        ], ['saveData' => true]);

        return $this->kirimEmail($email, $judul, $body, $lampiran);
    }

    /**
     * Pengiriman email khusus untuk invoice.
     *
     * @param string $email Penerima email.
     * @param string $judul Judul email (misal: "Invoice #INV-00123").
     * @param array $dataInvoice Data yang digunakan untuk template email (misal: nama, total, dll).
     * @param ?array $lampiran Path ke file PDF invoice (jika ada).
     * @return bool True jika terkirim, false jika gagal.
     */
    public function emailInvoice(string $email, string $judul, array $dataInvoice, ?array $lampiran = null): bool
    {
        $body = view('email/invoice', [
            'judul'   => $judul,
            'nama'    => $dataInvoice['nama'] ?? '-',
            'nomor'   => $dataInvoice['nomor'] ?? '-',
            'tanggal' => $dataInvoice['tanggal'] ?? date('d-m-Y'),
            'total'   => number_format($dataInvoice['total'] ?? 0, 0, ',', '.'),
        ], ['saveData' => true]);

        $lampiranList = $lampiran ? [$lampiran] : [];

        return $this->kirimEmail($email, $judul, $body, $lampiranList);
    }
}
