<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;
use CodeIgniter\Database\Query;
use Config\Database;
use App\Libraries\AuthLoginsLastIdLibrari;
use App\Libraries\AuthRememberLastIdLibrari;
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
});

Events::on('DBQuery', static function (Query $query) {
    if (! $query->isWriteType()) {
        return;
    }

    $sql = strtolower((string) $query);
    $db = Database::connect();

    if (strpos($sql, 'insert into `auth_logins`') !== false) {
        AuthLoginsLastIdLibrari::setId($db->insertID());
    }

    if (strpos($sql, 'insert into `auth_remember_tokens`') !== false) {
        $lastRememberId = $db->insertID();
        AuthRememberLastIdLibrari::setId($lastRememberId);
        return;
    }

    if (strpos($sql, 'insert into `auth_sesi`') !== false) {
        $rememberId = AuthRememberLastIdLibrari::getId();
        (new AuthSesiLibrari())->updateAuthSesi($rememberId);
    }
});