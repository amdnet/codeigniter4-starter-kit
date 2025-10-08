<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
helper('crb_statistik');

class Statistik extends Controller
{
    public function userList()
    {
        return $this->response->setJSON(statUserList());
    }

    public function userLogin()
    {
        return $this->response->setJSON(statUserLogin());
    }
}
