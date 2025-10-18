<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (auth()->user()->inGroup('admin')) {
            return redirect()->to('admin');
        } elseif (auth()->user()->inGroup('klien')) {
            return redirect()->to('klien');
        } else {
            return redirect()->to('login');
        }
    }

    public function lihat()
    {
        $data = [
            'token' => '12345',
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0',
            'date' => '2025-10-18 19:51:28'

        ];
        return view('Shield/Email/magic_link_email', $data);
    }

    public function cace()
    {
        $cachePath = WRITEPATH . 'cache/';
        $files = glob($cachePath . '*');
        $list = [];

        foreach ($files as $file) {
            if (is_file($file)) {
                $raw = file_get_contents($file);
                $data = @unserialize($raw);

                if (is_array($data) && isset($data['time'], $data['ttl'])) {
                    $timeCreated = date('Y-m-d H:i:s', $data['time']);
                    $ttl = $data['ttl'];

                    if ($ttl === 0) {
                        $timeExpire = 'lifetime';
                    } else {
                        $timeExpire = date('Y-m-d H:i:s', $data['time'] + $ttl);
                    }

                    $list[] = [
                        'name'        => basename($file),
                        'created'     => $timeCreated,
                        'expires'     => $timeExpire,
                        'ttl'         => $ttl
                    ];
                }
            }
        }

        $info = [
            'pageTitle' => 'User List',
            'navigasi' => '',
            'url' => 'user-list',
            'list' => $list
        ];
        return view('cache_inspector', $info);
    }
}
