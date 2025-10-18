<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Dashboard
$routes->get('/', 'Home::index', ['filter' => 'session']);
$routes->get('lihat', 'Home::lihat');
$routes->get('cace', 'Home::cace');

// Role superadmin, admin
$routes->group('admin', ['filter' => 'group:superadmin,admin'], function ($routes) {
    // dashboard
    $routes->get('', 'Admin\Dashboard::index');

    // admin -> statistik json
    $routes->group('statistik', function ($routes) {
        $routes->get('user-list', 'Admin\Statistik::userList');
        $routes->get('user-login', 'Admin\Statistik::userLogin');
    });

    // Grup: admin -> user
    $routes->group('user', function ($routes) {
        $routes->addRedirect('', 'admin/user/user-list');
        // admin/user/user-list
        $routes->group('user-list', function ($routes) {
            $routes->get('', 'Admin\User\UserList::index');
            $routes->post('tabel', 'Admin\User\UserList::tabel');
            $routes->post('get-id', 'Admin\User\UserList::getId');
            $routes->post('simpan', 'Admin\User\UserList::simpan');
            $routes->post('update', 'Admin\User\UserList::update');
        });

        // admin/user/user-login
        $routes->group('user-login', function ($routes) {
            $routes->get('', 'Admin\User\UserLogin::index');
            $routes->post('tabel', 'Admin\User\UserLogin::tabel');
            $routes->post('hapus', 'Admin\User\UserLogin::hapus');
            $routes->post('reset', 'Admin\User\UserLogin::reset');
            $routes->post('refresh', 'Admin\User\UserLogin::refresh');
        });
    });

    // Grup: admin -> setting
    $routes->group('setting', function ($routes) {
        $routes->addRedirect('', 'admin/setting/umum');
        // $routes->get('', 'Admin\Setting::index');

        // admin/setting/umum
        $routes->group('umum', function ($routes) {
            $routes->get('', 'Admin\Setting\Umum::index');
            $routes->post('simpan-sistem', 'Admin\Setting\Umum::simpanSistem');
            $routes->post('simpan-situs', 'Admin\Setting\Umum::simpanSitus');
            $routes->post('simpan-smtp', 'Admin\Setting\Umum::simpanSmtp');
            $routes->post('tes-smtp', 'Admin\Setting\Umum::tesSmtp');
            $routes->post('simpan-recaptcha', 'Admin\Setting\Umum::simpanRecaptcha');

            // admin/setting/umum/simpan-logo-*
            $routes->post('simpan-logo-warna', 'Admin\Setting\UmumLogo::simpanLogoWarna');
            $routes->post('simpan-logo-putih', 'Admin\Setting\UmumLogo::simpanLogoPutih');
            $routes->post('simpan-logo-ikon', 'Admin\Setting\UmumLogo::simpanLogoIkon');
            $routes->post('simpan-logo-ikon32', 'Admin\Setting\UmumLogo::simpanLogoIkon32');
            $routes->post('simpan-logo-ikon180', 'Admin\Setting\UmumLogo::simpanLogoIkon180');
            $routes->post('simpan-logo-ikon192', 'Admin\Setting\UmumLogo::simpanLogoIkon192');
        });

        // admin/setting/cache
        $routes->group('cache', function ($routes) {
            $routes->get('', 'Admin\Setting\Cache::index');
            $routes->post('tabel', 'Admin\Setting\Cache::tabel');
            $routes->post('simpan', 'Admin\Setting\Cache::simpan');
            $routes->post('hapus', 'Admin\Setting\Cache::hapus');
        });

        // admin/setting/optimasi
        $routes->group('optimasi', function ($routes) {
            $routes->get('', 'Admin\Setting\Optimasi::index');
            $routes->get('get-info', 'Admin\Setting\Optimasi::getInfo');
            $routes->post('hapus-log', 'Admin\Setting\Optimasi::hapusLog');
            $routes->post('hapus-debug', 'Admin\Setting\Optimasi::hapusDebug');
            $routes->post('db-optimasi', 'Admin\Setting\Optimasi::dbOptimasi');
            $routes->post('db-tabel', 'Admin\Setting\Optimasi::dbTabel');
            $routes->post('db-analisis', 'Admin\Setting\Optimasi::dbAnalisis');
            $routes->post('db-refresh', 'Admin\Setting\Optimasi::dbRefresh');
        });
    });
});

$routes->group('klien', ['filter' => 'group:klien'], function ($routes) {
    // dashboard
    $routes->get('', 'Klien\Dashboard::index');
});

// Role umum
$routes->group('', ['filter' => 'session'], function ($routes) {
    $routes->group('profil', function ($routes) {
        $routes->get('', 'Profil::index');
        $routes->post('update-foto', 'Profil::updateFoto');
        $routes->post('update-akun', 'Profil::updateAkun');
        $routes->post('update-info', 'Profil::updateInfo');
        $routes->get('get-perangkat', 'Profil::getPerangkat');
        $routes->post('get-perangkat', 'Profil::getPerangkat');
        $routes->post('logout-perangkat', 'Profil::logoutPerangkatLain');
    });
});

service('auth')->routes($routes, ['except' => ['login', 'magic-link']]);

// login
$routes->get('login', 'Auth\Login::loginView', ['as' => 'login']);
$routes->post('login', 'Auth\Login::loginAction');

// magic-link
$routes->get('login/magic-link', 'Auth\MagicLink::loginView', ['as' => 'magic-link']);
$routes->post('login/magic-link', 'Auth\MagicLink::loginAction');
$routes->get('verify-magic-link', 'Auth\MagicLink::verify', ['as' => 'verify-magic-link']);
