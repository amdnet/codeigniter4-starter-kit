<?php

namespace App\Controllers\Admin\User;

use App\Controllers\BaseController;
use App\Models\User\UserModel;
use App\Models\User\UserProfilModel;
use CodeIgniter\Shield\Entities\User;

class UserList extends BaseController
{
    protected $userModel;
    protected $userProfilModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userProfilModel = new UserProfilModel();
    }

    public function index()
    {
        $data = [
            'url' => 'admin/user/user-list',
            'pageTitle' => 'Daftar User List',
            'navTitle' => 'User List',
            'navigasi' => '<a href="/admin/user">User</a> &nbsp;',
        ];
        return view('admin/user/user_list', $data);
    }

    public function tabel()
    {
        $encrypter = service('encrypter');

        $data['data'] = array();
        $result = $this->userModel->tabelUserList();
        foreach ($result as $key => $value) {

            $idUser = base64_encode($encrypter->encrypt($value->iduser));

            $status = $value->active ? '<span class="lencana bg-primary">aktif</span>' : '<span class="lencana bg-danger">non aktif</span>';

            $ops = '<div class="btn-group" role="group">';
            $ops .= '<a class="btn btn-sm btn-dark" type="button" onclick="simpan(' . $value->iduser . ')">edit</a>';
            $ops .= '<a href="' . base_url('profil/?id=') . urlencode($idUser) . '" class="btn btn-sm btn-success" role="button">profil</a>';
            $ops .= '</div>';

            $data['data'][$key] = array(
                $value->iduser,
                $value->username,
                $value->email,
                $status,
                $value->group,
                $value->last_used_at,
                $value->created_at,
                $value->updated_at,
                $ops,
            );
        }
        return $this->response->setJSON($data);
    }

    public function getId()
    {
        $id = $this->request->getPost('userId');
        if ($this->validation->check($id, 'required|numeric')) {
            $data = $this->userModel->getId($id);
            return $this->response->setJSON($data);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function simpan()
    {
        // 🔒 Cek permission di awal
        if (! auth()->user()->can('klien.create')) {
            return $this->response->setJSON([
                'success'  => false,
                'messages' => 'Anda tidak memiliki izin untuk menambah user.'
            ]);
        }

        $response = [];
        $users = auth()->getProvider();

        $aktivasi = $this->request->getPost('aktivasi');
        $status = ($aktivasi === '0') ? 'banned' : null;
        
        $user = new User([
            'username' => $this->request->getPost('username'),
            'status' => $status,
            'active' => $aktivasi,
            'email'    => trim($this->request->getPost('email')),
            'password' => $this->request->getPost('password')
        ]);

        $profil = [
            'perusahaan' => $this->request->getPost('perusahaan'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'telegram' => $this->request->getPost('telegram'),
            'alamat' => $this->request->getPost('alamat'),
        ];

        $rules = [
            'username' => ['label' => 'Nama User', 'rules' => 'required|min_length[3]|max_length[30]|is_unique[users.username]'],
            'email' => ['label' => 'Alamat Email', 'rules' => 'required|max_length[50]|valid_email|is_unique[auth_identities.secret]'],
            'password' => ['label' => 'Password', 'rules' => 'required|min_length[8]|max_byte[72]|strong_password[]'],
            'password_confirm' => ['label' => 'Konfirmasi Password', 'rules' => 'matches[password]'],
        ];

        $data = $this->request->getPost(array_keys($rules));

        try {
            $this->db->transStart();

            if (! $this->validateData($data, $rules)) {
                $response = ['success'  => false, 'messages' => $this->validation->getErrors()];
            } else {
                if ($users->save($user)) {
                    $idUser = $users->getInsertID();
                    $user = $users->findById($idUser);

                    $hakAkses = $this->request->getPost('akses');
                    $user->addGroup($hakAkses);
                    // $this->userProfilModel->insert(['pf_iduser' => $idUser]);

                    $profilData = array_merge($profil, ['user_id' => $idUser]);

                    if (! $this->validateData($profilData, $this->userProfilModel->validasiSimpan())) {
                        $this->db->transRollback();
                        return $this->response->setJSON(['success'  => false, 'messages' => $this->validator->getErrors()]);
                    }

                    if (! $this->userProfilModel->insert($profilData)) {
                        $this->db->transRollback();
                        return $this->response->setJSON(['success'  => false, 'messages' => $this->userProfilModel->errors()]);
                    }

                    $response = ['success'  => true, 'messages' => lang("App.insert-success")];
                } else {
                    $response = ['success'  => false, 'messages' => lang("App.insert-error")];
                }
            }

            $this->db->transComplete();

            cache()->delete('statistik_user_list');

            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Gagal simpan transaksi: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => 'Terjadi kesalahan saat menyimpan data user.']);
        }
    }

    public function update()
    {
        // 🔒 Cek permission di awal
        if (! auth()->user()->can('klien.edit')) {
            return $this->response->setJSON([
                'success'  => false,
                'messages' => 'Anda tidak memiliki izin untuk mengedit user.'
            ]);
        }

        $response = [];
        $users = auth()->getProvider();
        $idUser = $this->request->getPost('iduser');
        $user = $users->findById($idUser);

        // Cek jika user ditemukan
        if (!$user) {
            return $this->response->setJSON(['success'  => false, 'messages' => 'ID User tidak ditemukan.']);
        }

        $aktivasi = $this->request->getPost('aktivasi');
        $status = ($aktivasi === '0') ? 'banned' : null;

        $userData = [
            'username' => $this->request->getPost('username'),
            'status' => $status,
            'active' => $aktivasi,
            'email' => trim($this->request->getPost('email'))
        ];

        if ($this->request->getPost('password')) {
            $userData['password'] = $this->request->getPost('password');
        }

        $rules = [
            'username' => ['label' => 'Nama User', 'rules' => 'required|min_length[3]|max_length[30]|is_unique[users.username,id,' . $idUser . ']'],
            'email' => ['label' => 'Alamat Email', 'rules' => 'required|max_length[50]|valid_email|is_unique[auth_identities.secret,user_id,' . $idUser . ']'],
            'password' => ['label' => 'Password', 'rules' => 'permit_empty|min_length[8]|max_byte[72]|strong_password[]'],
            'password_confirm' => ['label' => 'Konfirmasi Password', 'rules' => 'matches[password]'],
        ];

        $data = $this->request->getPost(array_keys($rules));

        if (!$this->validateData($data, $rules)) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        $profilId = $this->request->getPost('idprofil');
        
        $profilData = [
            'user_id' => $idUser,
            'perusahaan' => $this->request->getPost('perusahaan'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'telegram' => $this->request->getPost('telegram'),
            'alamat' => $this->request->getPost('alamat')
        ];

        try {
            $this->db->transStart();

            $user->fill($userData);

            if ($users->save($user)) {                
                $hakAkses = $this->request->getPost('akses');
                $user->syncGroups($hakAkses);

                if (! $this->userProfilModel->update($profilId, $profilData)) {
                    return $this->response->setJSON(['success'  => false, 'messages' => $this->userProfilModel->errors()]);
                }

                $response = ['success'  => true, 'messages' => lang("App.update-success")];
            } else {
                $response = ['success'  => false, 'messages' => lang("App.update-error")];
            }

            $this->db->transComplete();

            cache()->delete('statistik_user_list');

            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Gagal simpan transaksi: ' . $e->getMessage());

            return $this->response->setJSON([
                'success'  => false,
                'messages' => 'Terjadi kesalahan saat merubah data user.'
            ]);
        }
    }

    // DELETE FROM auth_identities WHERE user_id = 1 AND type != 'email_password';
}
