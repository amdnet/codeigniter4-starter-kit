<?php

namespace App\Libraries;

/**
 * Simpan informasi perangkat dan geoip user
 * @see app\Config\Events.php
 */
class UserLoginLibrari
{
    public function logInfoLogin(?int $authLogId): void
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
            'isp'        => $geo['isp']
        ]);
    }
}