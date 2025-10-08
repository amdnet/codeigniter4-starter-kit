<?php

namespace App\Models\Setting;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['class', 'key', 'value', 'type', 'context'];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [];
    protected $validationMessages = [];

    protected $afterInsert = ['clearCacheSetting'];
    protected $afterUpdate = ['clearCacheSetting'];
    protected $afterDelete = ['clearCacheSetting'];

    protected function clearCacheSetting(array $data)
    {
        cache()->delete('cache_setting');
        return $data;
    }

    public function validasiSistem(): array
    {
        return [
            'authRegistration' => [
                'label'  => 'Form Registrasi',
                'rules'  => 'required|in_list[true,false]',
            ],
            'authMagicLink' => [
                'label'  => 'Login Tanpa Sandi',
                'rules'  => 'required|in_list[true,false]',
            ],
            'authRemembering' => [
                'label'  => 'Centang "Ingat Saya"',
                'rules'  => 'required|in_list[true,false]',
            ],
            'authRememberLength' => [
                'label'  => 'Durasi "Ingat Saya"',
                'rules'  => 'required|integer|min_length[1]|max_length[10]',
            ],
        ];
    }

    public function validasiSitus(): array
    {
        return [
            'siteNama' => [
                'label'  => 'Nama Situs',
                'rules'  => 'required|string|min_length[5]|max_length[50]',
            ],
            'siteTagline' => [
                'label'  => 'Tagline',
                'rules'  => 'required|string|min_length[5]|max_length[50]',
            ],
            'siteTelp' => [
                'label'  => 'Telepon',
                'rules'  => 'required|min_length[5]|max_length[20]|integer',
            ],
            'siteWa' => [
                'label'  => 'WhatsApp',
                'rules'  => 'required|min_length[8]|max_length[15]|integer',
            ],
            'siteTelegram' => [
                'label'  => 'Telegram',
                'rules'  => 'required|min_length[8]|max_length[15]|integer',
            ],
            'siteEmail' => [
                'label'  => 'Email',
                'rules'  => 'required|min_length[10]|max_length[100]|valid_email',
            ],
            'siteAlamat' => [
                'label'  => 'Alamat',
                'rules'  => 'required|min_length[10]|max_length[255]',
            ],
        ];
    }

    public function validasiSmtp(): array
    {
        return [
            'smtpEmail' => [
                'label'  => 'Email Pengirim',
                'rules'  => 'required|min_length[10]|max_length[100]|valid_email',
            ],
            'smtpNama' => [
                'label'  => 'Nama Pengirim',
                'rules'  => 'required|min_length[5]|max_length[50]',
            ],
            'smtpPenerima' => [
                'label'  => 'Email Notifikasi',
                'rules'  => 'required|min_length[10]|max_length[100]',
            ],
            'smtpProtocol' => [
                'label'  => 'Server Protokol',
                'rules'  => 'required|in_list[mail,sendmail,smtp]',
            ],
            'smtpHost' => [
                'label'  => 'Server Host',
                'rules'  => 'required|min_length[10]|max_length[100]',
            ],
            'smtpPort' => [
                'label'  => 'Port Server',
                'rules'  => 'required|min_length[2]|max_length[5]|integer',
            ],
            'smtpUser' => [
                'label'  => 'Server Mail User',
                'rules'  => 'required|min_length[10]|max_length[100]',
            ],
            'smtpPass' => [
                'label'  => 'Server Mail Password',
                'rules'  => 'permit_empty|min_length[8]|max_byte[72]|strong_password[]',
            ],
            'smtpCrypto' => [
                'label'  => 'Port Koneksi',
                'rules'  => 'permit_empty|in_list[ssl,tls]'
            ],
        ];
    }

    public function validasiRecaptcha(): array
    {
        return [
            'gRecaptcha' => [
                'label'  => 'Google Recaptcha',
                'rules'  => 'required|in_list[true,false]',
            ],
            'gSiteKey' => [
                'label'  => 'Recaptcha Site Key',
                'rules'  => 'required|string|min_length[40]|max_length[40]',
            ],
            'gSecretKey' => [
                'label'  => 'Recaptcha Secret Key',
                'rules'  => 'required|string|min_length[40]|max_length[40]',
            ],
        ];
    }
}
