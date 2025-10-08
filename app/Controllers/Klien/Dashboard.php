<?php

namespace App\Controllers\Klien;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = [
            'pageTitle' => 'Dashboard',
            'navigasi' => '',
        ];
        return view('klien/dashboard', $data);
    }
}
