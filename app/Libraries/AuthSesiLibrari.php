<?php

namespace App\Libraries;

use Config\Services;

class AuthSesiLibrari
{
    /**
     * Update kolom kustom di tabel auth_sesi setelah dibuat.
     * @param int|null $rememberId ID dari auth_remember_tokens (jika ada).
     */
    public function updateAuthSesi(?int $rememberId): void
    {
        $sesiId = session_name() . ':' . session_id();
        $rememberId = $rememberId ?? null;
        // log_message('debug', "sesiId = {$sesiId}");

        $cacheKey = 'device_info';

        // Gunakan cache session jika tersedia
        if (session()->has($cacheKey)) {
            $deviceInfo = session($cacheKey);
        } else {
            $ua = Services::request()->getUserAgent();
            $uaString = strtolower((string) $ua);

            if ($ua->isRobot()) {
                $device = 'Robot';
            } elseif ($this->isTablet($uaString)) {
                $device = 'Tablet';
            } elseif ($ua->isMobile()) {
                $device = 'Mobile';
            } else {
                $device = 'Desktop';
            }

            $deviceInfo = [
                'perangkat' => $device ?? 'Null',
                'os'        => trim($ua->getPlatform()) ?? 'OS Null',
                'browser'   => trim($ua->getBrowser()) ?? 'Browser Null'
            ];

            // Simpan ke session untuk cache lokal
            session()->set($cacheKey, $deviceInfo);
        }

        $data = array_merge([
            'user_id'     => auth()->id(),
            'remember_id' => $rememberId
        ], $deviceInfo);

        try {
            model('Auth/AuthSesiModel')->update($sesiId, $data);
            // $affected = model('Auth/AuthSesiModel')->affectedRows(); // atau $model->builder()->affectedRows()
            // log_message('debug', "Update auth_sesi sukses untuk sesi {$sesiId}, affected rows: {$affected}, remember_id: {$rememberId}");
            // log_message('debug', "Update auth_sesi sukses untuk sesi {$sesiId} dengan remember_id {$rememberId}");
        } catch (\Throwable $e) {
            log_message('error', 'Gagal update auth_sesi: ' . $e->getMessage());
        }
    }

    /**
     * Deteksi tablet berdasarkan string User-Agent.
     */
    private function isTablet(string $uaString): bool
    {
        return (
            strpos($uaString, 'ipad') !== false ||
            strpos($uaString, 'tablet') !== false ||
            strpos($uaString, 'nexus 7') !== false ||
            strpos($uaString, 'galaxy tab') !== false ||
            strpos($uaString, 'kindle') !== false
        );
    }
}