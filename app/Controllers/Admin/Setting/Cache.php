<?php

namespace App\Controllers\Admin\Setting;

use App\Controllers\BaseController;
use App\Models\Setting\SettingModel;
helper('crb_cache');

class Cache extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . '*');
        $dataCache = [];

        foreach ($files as $file) {
            if (is_file($file)) {
                $raw = file_get_contents($file);
                $data = @unserialize($raw);

                if (is_array($data) && isset($data['time'], $data['ttl'])) {
                    $timeCreated = date('Y-m-d H:i:s', $data['time']);
                    $ttl = $data['ttl'];

                    if ($ttl === 0) {
                        $timeExpire = 'lifetime';
                    } else {
                        $timeExpire = date('Y-m-d H:i:s', $data['time'] + $ttl);
                    }

                    $cache[] = [
                        'name'        => basename($file),
                        'created'     => $timeCreated,
                        'expires'     => $timeExpire,
                        'ttl'         => $ttl
                    ];
                }
            }
        }

        $data = [
            'url' => 'admin/setting-cache',
            'pageTitle' => 'Setting Cache',
            'navTitle' => 'Cache',
            'navigasi' => '<a href="/admin/setting">Setting</a> &nbsp;',
            'durasiCache' => loadDurasiCache(),
            'cache' => $dataCache
        ];
        return view('admin/setting/cache', $data);
    }

    public function tabel()
    {
        $result = ['data' => []];

        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . '*');
        $no = 1;

        foreach ($files as $file) {
            if (is_file($file)) {
                $raw = file_get_contents($file);
                $cacheData = @unserialize($raw);

                if (is_array($cacheData) && isset($cacheData['time'], $cacheData['ttl'])) {
                    $timeCreated = date('d.m.Y → H:i:s', $cacheData['time']);
                    $ttl = $cacheData['ttl'];

                    if ($ttl === 0) {
                        $timeExpire = 'lifetime';
                    } else {
                        $expireTimestamp = $cacheData['time'] + $ttl;
                        $now = time();

                        // Kalau mau hitung sisa waktu dari sekarang
                        $remaining = $expireTimestamp - $now;

                        if ($remaining < 0) {
                            $timeExpire = '<span class="lencana bg-danger">expired</span>';
                        } else {
                            $days = floor($remaining / 86400); // 1 hari = 86400 detik

                            if ($days > 0) {
                                // Format normal: Hari & Jam
                                $hours = floor(($remaining % 86400) / 3600);
                                $timeExpire = sprintf('%02d Hari %02d Jam', $days, $hours);
                            } else {
                                // Kalau kurang dari 1 hari → Jam & Menit
                                $hours = floor($remaining / 3600);
                                $minutes = floor(($remaining % 3600) / 60);
                                $timeExpire = sprintf('%02d Jam %02d Menit', $hours, $minutes);
                            }
                        }
                    }

                    // Ambil tipe cache dari nama file
                    $baseName = basename($file);
                    $parts = explode('_', $baseName, 2); // pecah jadi max 2 bagian
                    $tipeCache = $parts[0]; // ambil prefix sebelum "_"

                    // Konversi TTL ke nama durasi
                    $ttlNameMap = [
                        3600       => 'Satu Jam',
                        21600      => 'Enam Jam',
                        43200      => 'Dua Belas Jam',
                        86400      => 'Satu Hari',
                        604800     => 'Satu Minggu',
                        2592000    => 'Satu Bulan',
                        31536000   => 'Satu Tahun',
                        0          => 'Lifetime'
                    ];
                    $durasiTtl = $ttlNameMap[$ttl] ?? $ttl . ' detik';

                    $btn = '<button class="btn btn-sm btn-danger btn-delete" data-filename="' . basename($file) . '">hapus</button>';

                    $result['data'][] = [
                        $no++,
                        $tipeCache,
                        $durasiTtl,
                        $timeExpire,
                        $timeCreated,
                        basename($file),
                        $ttl,
                        $btn
                    ];
                }
            }
        }
        return $this->response->setJSON($result);
    }

    public function simpan()
    {
        // 🔹 Ambil lokasi file dari helper, tanpa perlu menulis ulang path
        $lokasiJson = getLokasiCache();

        // 🔹 Ambil data lama dari helper
        $data = loadDurasiCache();

        // 🔹 Update hanya key yang dikirim dari form
        foreach ($this->request->getPost() as $key => $value) {
            $data[$key] = (int) $value;
        }

        // 🔹 Simpan kembali ke file JSON
        file_put_contents($lokasiJson, json_encode($data, JSON_PRETTY_PRINT));
        return $this->response->setJSON(['success' => true, 'messages' => 'Durasi cache berhasil diperbarui']);
    }

    public function hapus()
    {
        $filename = $this->request->getPost('filename');
        $cacheKey = basename($filename); // keamanan
        $path     = WRITEPATH . 'cache/' . $cacheKey;

        if (!is_file($path)) {
            return $this->response->setJSON(['success' => false, 'messages' => 'File tidak ditemukan']);
        }

        // Hapus file cache
        if (is_file($path)) {
            unlink($path);
        }
        
        return $this->response->setJSON(['success' => true, 'messages' => lang("App.delete-success")]);
    }

}
