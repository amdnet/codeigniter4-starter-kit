<?php

namespace App\Controllers\Admin\Setting;

use App\Controllers\BaseController;
use App\Models\Setting\SettingModel;

class UmumLogo extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function simpanLogoWarna()
    {
        $file = $this->request->getFile('logo_warna');
        if (!$file->isValid()) {
            return redirect()->back()->with('errors', $file->getErrorString());
        }

        if (!$this->validate([
            'logo_warna' => [
                'label' => 'File gambar',
                'rules' => 'uploaded[logo_warna]|is_image[logo_warna]|mime_in[logo_warna,image/jpg,image/jpeg,image/png]|max_size[logo_warna,1024]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah.',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Format gambar harus .jpg, .jpeg atau .png',
                    'max_size' => 'Ukuran gambar maksimal 1 MB.'
                ]
            ],
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $uploadPath = FCPATH . 'upload/logo/';
        $ext = $file->getExtension();
        $newName = 'logo-warna.' . $ext;

        // Ambil nama lama dari DB
        $oldName = setting('App.logoWarna') ?? null;

        // Hapus file lama jika bukan default (crb-...)
        if ($oldName && file_exists($uploadPath . $oldName) && strpos($oldName, 'crb-') !== 0) {
            unlink($uploadPath . $oldName);
        }

        // Pindahkan file baru
        $file->move($uploadPath, $newName, true);

        // Update DB
        if (setting('App.logoWarna', $newName)) {
            session()->setFlashdata('sukses', lang("App.update-success"));
        } else {
            session()->setFlashdata('error', lang("App.update-error"));
        }
        return redirect()->back();
    }

    public function simpanLogoPutih()
    {
        $file = $this->request->getFile('logo_putih');
        if (!$file->isValid()) {
            return redirect()->back()->with('errors', $file->getErrorString());
        }

        if (!$this->validate([
            'logo_putih' => [
                'label' => 'File gambar',
                'rules' => 'uploaded[logo_putih]|is_image[logo_putih]|mime_in[logo_putih,image/jpg,image/jpeg,image/png]|max_size[logo_putih,1024]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah.',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Format gambar harus .jpg, .jpeg atau .png',
                    'max_size' => 'Ukuran gambar maksimal 1 MB.'
                ]
            ],
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $uploadPath = FCPATH . 'upload/logo/';
        $ext = $file->getExtension();
        $newName = 'logo-putih.' . $ext;

        $oldName = setting('App.logoPutih') ?? null;

        if ($oldName && file_exists($uploadPath . $oldName) && strpos($oldName, 'crb-') !== 0) {
            unlink($uploadPath . $oldName);
        }

        $file->move($uploadPath, $newName, true);

        if (setting('App.logoPutih', $newName)) {
            session()->setFlashdata('sukses', lang("App.update-success"));
        } else {
            session()->setFlashdata('error', lang("App.update-error"));
        }
        return redirect()->back();
    }

    public function simpanLogoIkon()
    {
        $file = $this->request->getFile('logo_ikon');
        if (!$file->isValid()) {
            return redirect()->back()->with('errors', $file->getErrorString());
        }

        if (!$this->validate([
            'logo_ikon' => [
                'label' => 'File gambar',
                'rules' => 'uploaded[logo_ikon]|is_image[logo_ikon]|mime_in[logo_ikon,image/ico]|max_size[logo_ikon,124]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah.',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Format gambar harus .ico',
                    'max_size' => 'Ukuran gambar maksimal 100 KB.'
                ]
            ],
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // ✅ Validasi ukuran pixel
        $imageInfo = getimagesize($file->getTempName());
        if ($imageInfo[0] !== 32 || $imageInfo[1] !== 32) {
            return redirect()->back()->with('error', 'Ukuran favicon harus tepat 32 x 32 piksel.');
        }

        $uploadPath = FCPATH . 'upload/logo/';
        $ext = $file->getExtension();
        $newName = 'icon.' . $ext;

        $oldName = setting('App.logoIkon') ?? null;
        if ($oldName && file_exists($uploadPath . $oldName) && strpos($oldName, 'crb-') !== 0) {
            unlink($uploadPath . $oldName);
        }

        $file->move($uploadPath, $newName, true);

        if (setting('App.logoIkon', $newName)) {
            session()->setFlashdata('sukses', lang("App.update-success"));
        } else {
            session()->setFlashdata('error', lang("App.update-error"));
        }
        return redirect()->back();
    }

    public function simpanLogoIkon32()
    {
        $file = $this->request->getFile('logo_ikon32');
        if (!$file->isValid()) {
            return redirect()->back()->with('errors', $file->getErrorString());
        }

        if (!$this->validate([
            'logo_ikon32' => [
                'label' => 'File gambar',
                'rules' => 'uploaded[logo_ikon32]|is_image[logo_ikon32]|mime_in[logo_ikon32,image/png]|max_size[logo_ikon32,124]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah.',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Format gambar harus .png',
                    'max_size' => 'Ukuran gambar maksimal 100 KB.'
                ]
            ],
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $imageInfo = getimagesize($file->getTempName());
        if ($imageInfo[0] !== 32 || $imageInfo[1] !== 32) {
            return redirect()->back()->with('error', 'Ukuran favicon harus tepat 32 x 32 piksel.');
        }

        $uploadPath = FCPATH . 'upload/logo/';
        $ext = $file->getExtension();
        $newName = 'icon-32.' . $ext;

        $oldName = setting('App.logoIkon32') ?? null;
        if ($oldName && file_exists($uploadPath . $oldName) && strpos($oldName, 'crb-') !== 0) {
            unlink($uploadPath . $oldName);
        }

        $file->move($uploadPath, $newName, true);

        if (setting('App.logoIkon32', $newName)) {
            session()->setFlashdata('sukses', lang("App.update-success"));
        } else {
            session()->setFlashdata('error', lang("App.update-error"));
        }

        return redirect()->back();
    }

    public function simpanLogoIkon180()
    {
        $file = $this->request->getFile('logo_ikon180');
        if (!$file->isValid()) {
            return redirect()->back()->with('errors', $file->getErrorString());
        }

        if (!$this->validate([
            'logo_ikon180' => [
                'label' => 'File gambar',
                'rules' => 'uploaded[logo_ikon180]|is_image[logo_ikon180]|mime_in[logo_ikon180,image/png]|max_size[logo_ikon180,124]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah.',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Format gambar harus .png',
                    'max_size' => 'Ukuran gambar maksimal 100 KB.'
                ]
            ],
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $imageInfo = getimagesize($file->getTempName());
        if ($imageInfo[0] !== 180 || $imageInfo[1] !== 180) {
            return redirect()->back()->with('error', 'Ukuran favicon harus tepat 180 x 180 piksel.');
        }

        $uploadPath = FCPATH . 'upload/logo/';
        $ext = $file->getExtension();
        $newName = 'icon-180.' . $ext;

        $oldName = setting('App.logoIkon180') ?? null;
        if ($oldName && file_exists($uploadPath . $oldName) && strpos($oldName, 'crb-') !== 0) {
            unlink($uploadPath . $oldName);
        }

        $file->move($uploadPath, $newName, true);

        if (setting('App.logoIkon180', $newName)) {
            session()->setFlashdata('sukses', lang("App.update-success"));
        } else {
            session()->setFlashdata('error', lang("App.update-error"));
        }
        return redirect()->back();
    }

    public function simpanLogoIkon192()
    {
        $file = $this->request->getFile('logo_ikon192');
        if (!$file->isValid()) {
            return redirect()->back()->with('errors', $file->getErrorString());
        }

        if (!$this->validate([
            'logo_ikon192' => [
                'label' => 'File gambar',
                'rules' => 'uploaded[logo_ikon192]|is_image[logo_ikon192]|mime_in[logo_ikon192,image/png]|max_size[logo_ikon192,124]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah.',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Format gambar harus .png',
                    'max_size' => 'Ukuran gambar maksimal 100 KB.'
                ]
            ],
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $imageInfo = getimagesize($file->getTempName());
        if ($imageInfo[0] !== 192 || $imageInfo[1] !== 192) {
            return redirect()->back()->with('error', 'Ukuran favicon harus tepat 192 x 192 piksel.');
        }

        $uploadPath = FCPATH . 'upload/logo/';
        $ext = $file->getExtension();
        $newName = 'icon-192.' . $ext;

        $oldName = setting('App.logoIkon192') ?? null;
        if ($oldName && file_exists($uploadPath . $oldName) && strpos($oldName, 'crb-') !== 0) {
            unlink($uploadPath . $oldName);
        }

        $file->move($uploadPath, $newName, true);
        // $success = $this->settingModel->where('key', 'logoIkon192')->set(['value' => $newName])->update();

        if (setting('App.logoIkon192', $newName)) {
            session()->setFlashdata('sukses', lang("App.update-success"));
        } else {
            session()->setFlashdata('error', lang("App.update-error"));
        }
        return redirect()->back();
    }
}
