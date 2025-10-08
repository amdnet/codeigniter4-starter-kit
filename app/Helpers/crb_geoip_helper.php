<?php

use GeoIp2\Database\Reader;

/**
 * @see app\Libraries\UserLogger.php
 * @see app\Filters\UpdateSesiFilter.php
 * @see app\Helpers\crb_sessions_helper.php
 */
if (!function_exists('getGeoIpData')) {
    function getGeoIpData(string $ip = ''): array
    {
        helper('crb_cache');

        $default = [
            'negara'     => null,
            'wilayah'    => null,
            'distrik'    => null,
            'zona_waktu' => null,
            'isp'        => null
        ];

        // Ambil IP publik
        if (!$ip) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $ip = explode(',', $ip)[0];
        }

        // Normalisasi localhost IPv6 → IPv4
        if ($ip === '::1') {
            $ip = '127.0.0.1';
        }

        // Kalau localhost → data fake
        if ($ip === '127.0.0.1') {
            $cacheKey = 'geoip_' . auth()->id() . '_' . $ip;
            $cached = cache($cacheKey);
            if ($cached !== null) {
                return $cached;
            }

            $geoData = [
                'negara'     => 'Indonesia',
                'wilayah'    => 'Jawa Barat',
                'distrik'    => 'Cirebon',
                'zona_waktu' => 'Asia/Jakarta',
                'isp'        => 'PT Telekomunikasi Indonesia'
            ];

            cache()->save($cacheKey, $geoData, getDurasiCache('cache_geoip'));
            return $geoData;
        }

        // Cek cache CI4
        $cacheKey = 'geoip_' . auth()->id() . '_' . $ip;
        $cached = cache($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        // 1⃣ Ambil lokasi dari GeoLite2-City.mmdb
        $geoData = geoFromGeoLite2($ip);

        // 2⃣ ISP + fallback wilayah/distrik jika null
        $fallback = fallbackGeoIpApis($ip);
        $geoData['isp'] ??= $fallback['isp'] ?? null;
        $geoData['wilayah'] ??= $fallback['wilayah'] ?? null;
        $geoData['distrik'] ??= $fallback['distrik'] ?? null;

        // Simpan ke cache
        if (!empty($geoData['negara'])) {
            cache()->save($cacheKey, $geoData, getDurasiCache('cache_geoip'));
        }

        return $geoData ?: $default;
    }
}

if (!function_exists('geoFromGeoLite2')) {
    function geoFromGeoLite2(string $ip): array
    {
        $file = WRITEPATH . 'uploads/GeoLite2-City.mmdb';
        if (!is_file($file)) {
            return [];
        }

        try {
            $reader = new Reader($file);
            $record = $reader->city($ip);
            $reader->close();

            return [
                'negara'     => $record->country->name ?? null,
                'wilayah'    => $record->mostSpecificSubdivision->name ?? null,
                'distrik'    => $record->city->name ?? null,
                'zona_waktu' => $record->location->timeZone ?? null,
                'isp'        => null // diisi terpisah
            ];
        } catch (\Exception $e) {
            return [];
        }
    }
}

if (!function_exists('fallbackGeoIpApis')) {
    function fallbackGeoIpApis(string $ip): array
    {
        $result = [
            'isp'     => null,
            'wilayah' => null,
            'distrik' => null
        ];

        $ctx = stream_context_create(['http' => ['timeout' => 2]]);

        // 1⃣ ipapi.co
        $url = "https://ipapi.co/{$ip}/json/";
        $json = @file_get_contents($url, false, $ctx);
        if ($json) {
            $data = json_decode($json, true);
            $result['isp']     = $data['org']     ?? null;
            $result['wilayah'] = $data['region']  ?? null;
            $result['distrik'] = $data['city']    ?? null;
        }

        // 2⃣ geojs.io (jika masih null)
        if (!$result['isp'] || !$result['wilayah'] || !$result['distrik']) {
            $url = "https://get.geojs.io/v1/ip/geo/{$ip}.json";
            $json = @file_get_contents($url, false, $ctx);
            if ($json) {
                $data = json_decode($json, true);
                $result['isp']     ??= $data['organization_name'] ?? 'Null';
                $result['wilayah'] ??= $data['region']            ?? 'Null';
                $result['distrik'] ??= $data['city']              ?? 'Null';
            }
        }

        return $result;
    }
}
