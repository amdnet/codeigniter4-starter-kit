<?php

namespace App\Libraries;

/**
 * Simpan informasi perangkat, geoip dan error
 * 
 * @param ?int $authLogId Last id dari tabel auth_logins
 * @param ?string $tipeError Kategori tipe error
 * @param ?string $infoError Detail informasi error
 * @see app\Controllers\Auth\Login.php
 * 
 * @return void
 */
class UserLoginLibrari
{
    public function logInfoLogin(?int $authLogId, ?string $tipeError = null, ?string $infoError = null): void
    {
        if ($authLogId === null) {
            return;
        }

        helper(['crb_device', 'crb_geoip']);
        $device = getDeviceData();
        $geo = getGeoIpData();

        $userLoginModel = model('User/UserLoginModel');
        $userLoginModel->insert([
            'login_id'   => $authLogId,
            'perangkat'  => $device['device'],
            'os'         => $device['os'] . ' ' . $device['bit'],
            'browser'    => $device['browser'] . ' ' . $device['browserv'],
            'brand'      => $device['brand'],
            'model'      => $device['model'],
            'negara'     => $geo['negara'],
            'wilayah'    => $geo['wilayah'],
            'distrik'    => $geo['distrik'],
            'zona_waktu' => $geo['zona_waktu'],
            'isp'        => $geo['isp'],
            'tipe'       => $tipeError,
            'error'      => $infoError
        ]);
    }
}
