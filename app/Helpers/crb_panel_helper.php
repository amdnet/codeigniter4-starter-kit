<?php

if (!function_exists('panel_setting')) {
    /**
     * crb_panel_helper
     * Digunakan untuk simpan konfigurasi tanpa menulis php
     * Ambil nilai dari json/crb_panel.json
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function panel_setting(string $key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $filePath = WRITEPATH . 'json/crb_panel.json';
            if (is_file($filePath)) {
                $json = file_get_contents($filePath);
                $settings = json_decode($json, true) ?: [];
            } else {
                $settings = [];
            }
        }
        return $settings[$key] ?? $default;
    }
}
