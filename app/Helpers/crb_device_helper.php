<?php

use Config\Services;

if (!function_exists('getDeviceData')) {
    /**
     * Ambil data perangkat dari User-Agent.
     *
     * @see app\Libraries\UserLoginLibrari.php
     * @see app\Libraries\AuthSesiLibrari.php
     */
    function getDeviceData(): array
    {
        // Key cache unik per user
        // $cacheKey = 'device_' . md5($uaString);
        $cacheKey = 'device_' . auth()->id() . '_' . date('His');
        $cached = cache($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $ua = Services::request()->getUserAgent();
        $uaString = strtolower((string) $ua);

        // 3️⃣ Deteksi bit OS
        if (stripos($uaString, 'x64') !== false || stripos($uaString, 'win64') !== false || stripos($uaString, 'amd64') !== false) {
            $bit = '64-bit';
        } elseif (stripos($uaString, 'x86') !== false || stripos($uaString, 'i686') !== false) {
            $bit = '32-bit';
        }

        // 4️⃣ Deteksi perangkat
        if ($ua->isRobot()) {
            $device = 'Robot';
        } elseif (isTablet($uaString)) {
            $device = 'Tablet';
        } elseif ($ua->isMobile()) {
            $device = 'Mobile';
        } else {
            $device = 'Desktop';
        }

        // 5️⃣ Parsing manual untuk Mobile/Tablet
        if ($ua->isMobile()) {
            $os      = getMobileOS($uaString);
            $browser = getMobileBrowser($uaString);
            $brand   = getMobileBrand($uaString);
            $model   = getMobileModel($uaString);
        } else {
            $os      = trim($ua->getPlatform());
            $browser = trim($ua->getBrowser());
            $brand   = 'Umum';
            $model   = 'Umum';
        }

        $data = [
            'device'   => $device ?? 'Null',
            'bit'      => $bit ?? 'Null',
            'os'       => $os ?? 'Null',
            'browser'  => $browser ?? 'Null',
            'browserv' => trim($ua->getVersion()) ?? 'Null',
            'brand'    => $brand ?? 'Null',
            'model'    => $model ?? 'Null'
        ];

        // Simpan ke cache CI4
        helper('crb_cache');
        cache()->save($cacheKey, $data, getDurasiCache('cache_device'));

        return $data;
    }

    function isTablet(string $uaString): bool
    {
        return (
            strpos($uaString, 'ipad') !== false ||
            strpos($uaString, 'tablet') !== false ||
            strpos($uaString, 'nexus 7') !== false ||
            strpos($uaString, 'galaxy tab') !== false ||
            strpos($uaString, 'kindle') !== false
        );
    }

    function getMobileOS(string $ua): string
    {
        if (strpos($ua, 'android') !== false) return 'Android';
        if (strpos($ua, 'iphone') !== false || strpos($ua, 'ipad') !== false || strpos($ua, 'ios') !== false) return 'iOS';
        if (strpos($ua, 'symbian') !== false) return 'Symbian';
        if (strpos($ua, 'windows phone') !== false) return 'Windows Phone';
        return 'Tidak Diketahui';
    }

    function getMobileBrowser(string $ua): string
    {
        if (strpos($ua, 'chrome') !== false) return 'Chrome Mobile';
        if (strpos($ua, 'safari') !== false && strpos($ua, 'chrome') === false) return 'Safari Mobile';
        if (strpos($ua, 'firefox') !== false) return 'Firefox Mobile';
        if (strpos($ua, 'opera') !== false || strpos($ua, 'opr') !== false) return 'Opera Mobile';
        return 'Tidak Diketahui';
    }

    function getMobileBrand(string $ua): string
    {
        $ua = strtolower($ua);

        $brands = [
            'Advan'    => ['advan'],
            'Apple'    => ['iphone', 'ipad', 'macintosh'],
            'Asus'     => ['asus'],
            'Evercoss' => ['evercoss'],
            'Google'   => ['pixel', 'google'],
            'Honor'    => ['honor'],
            'Huawei'   => ['huawei'],
            'Infinix'  => ['infinix'],
            'Itel'     => ['itel'],
            'Lenovo'   => ['lenovo'],
            'Meizu'    => ['meizu'],
            'Motorola' => ['motorola', 'moto'],
            'Nokia'    => ['nokia'],
            'OnePlus'  => ['oneplus'],
            'Oppo'     => ['oppo'],
            'Realme'   => ['realme'],
            'Samsung'  => ['samsung', 'sm-', 'gt-'],
            'Sony'     => ['sony', 'xperia'],
            'Tecno'    => ['tecno'],
            'Vivo'     => ['vivo'],
            'Xiaomi'   => ['xiaomi', 'mi ', 'redmi', 'poco'],
            'ZTE'      => ['zte'],
        ];

        foreach ($brands as $brand => $patterns) {
            foreach ($patterns as $pattern) {
                if (strpos($ua, $pattern) !== false) {
                    return ucfirst($brand);
                }
            }
        }

        return 'Tidak Diketahui';
    }

    function getMobileModel(string $ua): string
    {
        // Contoh: cari pola SM-G991B atau iPhone13,3
        if (preg_match('/(sm-[a-z0-9]+|iphone[\d,]+|ipad[\d,]+|mi [a-z0-9]+|redmi [a-z0-9]+|infinix[-\s]?[a-z0-9]+|tecno[-\s]?[a-z0-9]+|itel[-\s]?[a-z0-9]+|advan[-\s]?[a-z0-9]+|evercoss[-\s]?[a-z0-9]+)/i', $ua, $match)) {
            return strtoupper($match[1]);
        }

        return 'Tidak Diketahui';
    }
}
