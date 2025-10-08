<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;
use CodeIgniter\Database\Query;
use Config\Database;
use App\Libraries\AuthLoginsLastIdLibrari;
use App\Libraries\AuthRememberLastIdLibrari;
use App\Libraries\UserLoginLibrari;
use App\Libraries\AuthSesiLibrari;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();
        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }

    // if (auth()->loggedIn()) {
    //     $authSesiModel = model('Auth/AuthSesiModel');

    //     $authSesiId = session_name() . ':' . session_id();
    //     $last = $authSesiModel->getDirubah($authSesiId);
    //     $now = time();

    //     if ($last && ($now - strtotime($last->dirubah)) > 300) {
    //         if ($authSesiModel->where('id', $authSesiId)->first()) {
    //             $authSesiModel->updateSesi($authSesiId);
    //         }
    //     }
    // }
});

// Tangkap event DBQuery untuk mencatat ID terakhir dari INSERT INTO tabel
Events::on('DBQuery', static function (Query $query) {
    if (! $query->isWriteType()) {
        return;
    }

    $sql = strtolower((string) $query);
    $db = Database::connect();

    // ================== LANGKAH DEBUGGING ==================
    // Log SEMUA query tulis untuk melihat bentuk aslinya.
    // log_message('debug', 'DBQuery WRITE DETECTED: ' . $sql); 
    // =======================================================

    // Get last id auth_logins
    if (strpos($sql, 'insert into `auth_logins`') !== false) {
        AuthLoginsLastIdLibrari::setId($db->insertID());
    }

    // --- BLOK 1: MENANGKAP ID ---
    // Cukup tangkap dan simpan ID saat remember token dibuat.
    // Gunakan pengecekan yang lebih longgar untuk menghindari masalah string.
    // if (strpos($sql, 'insert into') !== false && strpos($sql, 'auth_remember_tokens') !== false) {
    if (strpos($sql, 'insert into `auth_remember_tokens`') !== false) {
        $lastRememberId = $db->insertID();
        AuthRememberLastIdLibrari::setId($lastRememberId);
        // log_message('debug', "Menangkap dan menyimpan remember_id: {$lastRememberId}");
        return; // Selesai, jangan proses lebih lanjut di blok ini.
    }

    // Abaikan jika belum login
    // if (! auth()->loggedIn()) {
    //     return;
    // }

    // --- BLOK 2: MENGGUNAKAN ID ---
    // Blok ini hanya berjalan saat sesi baru dimasukkan ke DB.
    // if (strpos($sql, 'insert into') !== false && strpos($sql, 'auth_sesi') !== false) {
    if (strpos($sql, 'insert into `auth_sesi`') !== false) {
        // Ambil ID sesi yang baru saja dibuat
        // $sesiId = session_name() . ':' . session_id();

        // Ambil remember_id yang tadi disimpan
        $rememberId = AuthRememberLastIdLibrari::getId();

        (new AuthSesiLibrari())->updateAuthSesi($rememberId);
        // (new AuthSesiLibrari())->updateAuthSesi($sesiId, $rememberId);
        // if ($rememberId) {(new AuthSesiLibrari())->updateAuthSesi($sesiId, $rememberId);}
    }
});

// Login berhasil
Events::on('login', static function () {
    $authLogId = AuthLoginsLastIdLibrari::getId();
    if ($authLogId) {
        (new UserLoginLibrari())->logInfoLogin($authLogId);
        AuthLoginsLastIdLibrari::reset();
    }
});

// Login gagal
Events::on('failedLogin', static function () {
    $authLogId = AuthLoginsLastIdLibrari::getId();
    if ($authLogId) {
        (new UserLoginLibrari())->logInfoLogin($authLogId);
        AuthLoginsLastIdLibrari::reset();
    }
});
