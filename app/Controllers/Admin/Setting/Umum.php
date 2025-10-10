<?php

namespace App\Controllers\Admin\Setting;

use App\Controllers\BaseController;
use App\Models\Setting\SettingModel;

class Umum extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $data = [
            'url' => 'admin/setting/umum',
            'pageTitle' => 'Setting Umum',
            'navTitle' => 'Umum',
            'navigasi' => '<a href="/admin/setting">Setting</a>'
        ];
        return view('admin/setting/umum', $data);
    }

    public function simpanSistem()
    {
        if (! $this->validate($this->settingModel->validasiSistem())) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        try {
            setting('App.authRegistration', $this->request->getPost('authRegistration'));
            setting('App.authMagicLink', $this->request->getPost('authMagicLink'));
            setting('App.authRemembering', $this->request->getPost('authRemembering'));
            setting('App.authRememberLength', $this->request->getPost('authRememberLength'));
        } catch (\Throwable $e) {
            log_message('error', 'Gagal simpan sistem: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => lang("App.update-error")]);
        }
        return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
    }

    public function simpanSitus()
    {
        if (! $this->validate($this->settingModel->validasiSitus())) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        try {
            setting('App.siteNama', $this->request->getPost('siteNama'));
            setting('App.siteTagline', $this->request->getPost('siteTagline'));
            setting('App.siteTelp', $this->request->getPost('siteTelp'));
            setting('App.siteWa', $this->request->getPost('siteWa'));
            setting('App.siteTelegram', $this->request->getPost('siteTelegram'));
            setting('App.siteEmail', $this->request->getPost('siteEmail'));
            setting('App.siteAlamat', $this->request->getPost('siteAlamat'));
        } catch (\Throwable $e) {
            log_message('error', 'Gagal simpan situs: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => lang("App.update-error")]);
        }
        return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
    }

    public function simpanSmtp()
    {
        if (! $this->validate($this->settingModel->validasiSmtp())) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        try {
            setting('App.smtpEmail', $this->request->getPost('smtpEmail'));
            setting('App.smtpNama', $this->request->getPost('smtpNama'));
            setting('App.smtpPenerima', $this->request->getPost('smtpPenerima'));
            setting('App.smtpProtocol', $this->request->getPost('smtpProtocol'));
            setting('App.smtpHost', $this->request->getPost('smtpHost'));
            setting('App.smtpPort', $this->request->getPost('smtpPort'));
            setting('App.smtpUser', $this->request->getPost('smtpUser'));
            setting('App.smtpCrypto', $this->request->getPost('smtpCrypto'));

            $smtpPassRaw = $this->request->getPost('smtpPass');
            if (trim($smtpPassRaw) !== '') {
                $encrypter = service('encrypter');
                $smtpPass = base64_encode($encrypter->encrypt($smtpPassRaw));
                setting('App.smtpPass', $smtpPass);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Gagal simpan smtp: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => lang("App.update-error")]);
        }
        return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
    }

    public function simpanRecaptcha()
    {
        if (! $this->validate($this->settingModel->validasiRecaptcha())) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        try {
            setting('App.gRecaptcha', $this->request->getPost('gRecaptcha'));
            setting('App.gSiteKey', $this->request->getPost('gSiteKey'));
            setting('App.gSecretKey', $this->request->getPost('gSecretKey'));
        } catch (\Throwable $e) {
            log_message('error', 'Gagal simpan recaptcha: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => lang("App.update-error")]);
        }
        return $this->response->setJSON(['success'  => true, 'messages' => lang("App.update-success")]);
    }

    public function tesSmtp()
    {
        $penerima = $this->request->getPost('testEmail');
        $judul    = "Tes Pengiriman Email CI4 Dinamis";
        $pesan    = "Halo, ini adalah pesan tes dari CodeIgniter 4 menggunakan konfigurasi SMTP dari Librari!";
        // $lampiran = WRITEPATH . 'json/crb_cache.json';

        $emailLibrari = new \App\Libraries\EmailLibrari();
        // if ($emailLibrari->kirimEmailStandar($penerima, $judul, $pesan, [$lampiran])) {
        if ($emailLibrari->kirimEmailStandar($penerima, $judul, $pesan)) {
            return redirect()->back()->with('sukses', 'Email berhasil dikirim menggunakan pengaturan DB!');
        } else {
            return redirect()->back()->with('error', 'Email gagal dikirim. Cek log atau debugger.');
        }
    }

    public function simpanTransaksi()
    {
        $response = [];
        $rules = $this->settingModel->validasiSistem();
        if (! $this->validate($rules)) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        $this->db->transBegin();

        try {
            $data = [
                'authRegistration' => $this->request->getPost('authRegistration'),
                'authMagicLink' => $this->request->getPost('authMagicLink'),
                'authRemembering' => $this->request->getPost('authRemembering'),
                'authRememberLength' => $this->request->getPost('authRememberLength')
            ];

            foreach ($data as $key => $value) {
                $existing = $this->settingModel->where('key', $key)->first();
                if ($existing) {
                    $this->settingModel->update($existing['id'], ['value' => $value]);
                }
            }

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                $response = ['success'  => false, 'messages' => lang("App.update-error")];
            } else {
                $this->db->transCommit();
                $response = ['success'  => true, 'messages' => lang("App.update-success")];
            }

            $this->db->transComplete();
            return $this->response->setJSON($response);
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', 'Gagal simpan sistem: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => 'Terjadi kesalahan saat menyimpan data sistem.']);
        }
    }
}
