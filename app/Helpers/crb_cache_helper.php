<?php

/**
 * helper('crb_cache')
 * Digunakan pada:
 * -> app\Helpers\crb_setting_helper.php
 * -> app\Controllers\Setting\CacheController.php
 * Lokasi file:
 * writable\json\crb_cache.json
 */

if (! function_exists('getLokasiCache')) {
    /**
     * Mengembalikan lokasi file JSON untuk konfigurasi cache.
     *
     * @return string
     */
    function getLokasiCache(): string
    {
        return WRITEPATH . 'json/crb_cache.json';
    }
}

if (! function_exists('loadDurasiCache')) {
    /**
     * Membaca file writable/json/crb_cache.json
     * dan mengembalikan array durasi cache.
     *
     * @return array
     */
    function loadDurasiCache(): array
    {
        $lokasiJson = getLokasiCache();

        // Default value jika file belum ada 
        // 31536000 = 1 tahun
        // 604800 = 7 hari
        $defaults = [
            // 'cache_setting_umum' => 31536000,
            'cache_geoip' => 604800,
            'cache_device' => 604800,
            'statistik_user_list' => 3600,
            'statistik_user_login' => 3600
        ];

        if (is_file($lokasiJson)) {
            $json = json_decode(file_get_contents($lokasiJson), true);
            if (is_array($json)) {
                // Merge supaya default tetap ada kalau key baru belum diset
                return array_merge($defaults, $json);
            }
        }
        return $defaults;
    }
}

if (! function_exists('getDurasiCache')) {
    /**
     * Ambil durasi cache untuk key tertentu
     *
     * @param string $key
     * @param int    $default
     * @return int
     */
    function getDurasiCache(string $key, int $default = 0): int
    {
        $all = loadDurasiCache();
        return isset($all[$key]) ? (int) $all[$key] : $default;
    }
}

if (! function_exists('cacheSetting')) {
    function cacheSetting(bool $force = false): array
    {
        $cacheKey = 'cache_setting_umum';
        $cacheSetting = cache($cacheKey);

        if ($force || $cacheSetting === null) {
            $settingModel = new \App\Models\Setting\SettingModel();
            $rows = $settingModel->findAll();
            $cacheSetting = [];

            foreach ($rows as $row) {
                $cacheSetting[$row['class']][$row['key']] = [
                    'value' => $row['value'],
                    'type'  => $row['type'] ?? 'string'
                ];
            }

            cache()->save($cacheKey, $cacheSetting, getDurasiCache('cache_setting_umum'));
        }

        return $cacheSetting;
    }
}