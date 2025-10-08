<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User\UserModel;
use App\Models\User\UserProfilModel;
use App\Models\Auth\AuthSesiModel;
use CodeIgniter\I18n\Time;

class Profil extends BaseController
{
    protected $userModel;
    protected $userProfilModel;
    protected $authSesiModel;

    public function __construct()
    {
        // helper('crb_form');
        $this->userModel = new UserModel();
        $this->userProfilModel = new UserProfilModel();
        $this->authSesiModel = new AuthSesiModel();
    }

    public function index()
    {
        $encrypter = service('encrypter');
        $encoded = $this->request->getGet('id');

        if ($encoded) {
            $decoded = base64_decode($encoded);
            $userId = $encrypter->decrypt($decoded);
        } else {
            $userId = auth()->id();
        }

        $user = $this->userModel->getProfil($userId);

        if (!$user->id_profil) {
            return redirect()->to('/')->with('error', 'Id user profil tidak ditemukan.');
        }

        $foto = is_null($user->foto) ? 'crb-profil.png' : $user->foto;

        if (auth()->id() === $userId) {
            $tabPane = 'tab-pane fade';
        } else {
            $tabPane = 'tab-pane fade show active';
        }

        $data = [
            'url' => 'profil',
            'pageTitle' => 'Profil',
            'navigasi' => '',
            'userId' => $userId,
            'user' => $user,
            'foto' => $foto,
            'tabPane' => $tabPane
        ];
        return view('profil', $data);
    }

    public function getPerangkat()
    {
        $userId = auth()->id();
        $sesi = $this->authSesiModel->getProfil($userId, 8);
        $sesiId = session_name() . ':' . session_id();
        $now = Time::now()->getTimestamp();
        $sesiExpire = config('Session')->expiration;

        foreach ($sesi as &$s) {
            $s->ip_publik = ($s->ip_address === '::1') ? '127.0.0.1' : $s->ip_address;

            if ($s->perangkat === 'Robot') {
                $s->device = 'bi-robot mr-2';
            } elseif ($s->perangkat === 'Tablet') {
                $s->device = 'bi-tablet mb-1';
            } elseif ($s->perangkat === 'Mobile') {
                $s->device = 'bi-phone ml-n2 mb-1';
            } else {
                $s->device = 'bi-laptop mr-2';
            }

            $s->remember = is_null($s->remember_id) ? 'bi-toggle-off' : 'bi-toggle-on';

            // Jika waktu server = app\Config\App.php -> appTimezone
            $lastActivity = strtotime($s->timestamp);

            // Jika waktu server ≠ app\Config\App.php -> appTimezone
            // $utcTime = Time::parse($s->timestamp, 'UTC');
            // $localTime = $utcTime->setTimezone('Asia/Jakarta');
            // $lastActivity = $localTime->getTimestamp();

            $isExpired = ($lastActivity + $sesiExpire) <= $now;

            if ($s->id === $sesiId && !$isExpired) {
                $s->warna = 'text-success';
                $s->ikon = 'bi-caret-right-fill';
                $s->status = '<span class="lencana bg-success">Perangkat aktif</span>';
            } elseif (!$isExpired) {
                // $timeAgo = $localTime->humanize();
                $timeAgo = Time::createFromTimestamp($lastActivity)->humanize();
                $timeAgo = str_replace('"', '', $timeAgo);
                $s->warna = 'text-secondary';
                $s->ikon = 'bi-caret-right';
                $s->status = '<span class="lencana bg-secondary">Aktif ' . $timeAgo . '</span>';
            } else {
                // $timeAgo = $localTime->humanize();
                $timeAgo = Time::createFromTimestamp($lastActivity)->humanize();
                $timeAgo = str_replace('"', '', $timeAgo);
                $s->ikon = 'bi-caret-right';
                $s->warna = 'text-secondary';
                $s->status = '<span class="lencana bg-secondary">Berakhir ' . $timeAgo . '</span>';
            }
        }

        $data = [
            'sessions' => $sesi, // Data perangkat untuk halaman saat ini
            'pager'    => $this->authSesiModel->pager->links('default', 'bootstrap4_full'), // HTML untuk link paginasi
            'total'    => $this->authSesiModel->pager->getTotal() // Total semua perangkat (untuk logika tombol)
        ];

        return $this->response->setJSON($data);
    }

    public function logoutPerangkatLain()
    {
        $userId = auth()->id();
        $sesiId = session_name() . ':' . session_id();

        $sesiNonAktif = $this->authSesiModel->getSesiNonAktif($userId, $sesiId);
        $authSesiModel = model('Auth/AuthSesiModel');

        try {
            foreach ($sesiNonAktif as $sesi) {
                $rememberId = $sesi->remember_id ?? null;

                if ($rememberId) {
                    $tokenModel = model('Auth/AuthRememberTokenModel');
                    $token = $tokenModel->find($rememberId);

                    if ($token) {
                        $tokenModel->delete($rememberId); // sesi ikut terhapus via CASCADE
                    } else {
                        $authSesiModel->hapusSesi($sesi->id); // fallback jika token sudah tidak ada
                    }
                } else {
                    $authSesiModel->hapusSesi($sesi->id);
                }
            }
            $response = ['status'  => 'success', 'messages' => 'Berhasil logout dari perangkat lain.'];
        } catch (\Throwable $th) {
            log_message('error', 'logoutPerangkatLain: ' . $th->getMessage());
            $response = ['status'  => 'error', 'messages' => 'Info: ' . $th->getMessage()];
        }
        return $this->response->setJSON($response);
    }

    public function updateFoto()
    {
        $idUser = $this->request->getPost('id_user');

        if (auth()->id() !== (int)$idUser) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Hanya pemilik ID yang dapat merubah data.']);
        }

        $idProfil = $this->request->getPost('id_profil');
        $file = $this->request->getFile('foto_profil');

        if (!$this->validate([
            'foto_profil' => [
                'label' => 'File gambar',
                'rules' => 'uploaded[foto_profil]|is_image[foto_profil]|mime_in[foto_profil,image/jpg,image/jpeg,image/png]|max_size[foto_profil,1024]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file gambar untuk diunggah.',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Format gambar harus .jpg, .jpeg atau .png',
                    'max_size' => 'Ukuran gambar maksimal 1 MB.'
                ]
            ],
        ])) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $lokasi = FCPATH . 'upload/profil/';
        if (!is_dir($lokasi)) {
            mkdir($lokasi, 0777, true);
        }

        $ext      = $file->getExtension();
        $fileBaru = 'foto-profil_' . $idProfil . '.' . $ext;
        $fileLama = $this->userProfilModel->getFoto($idProfil) ?? null;

        if ($fileLama && file_exists($lokasi . $fileLama)) {
            unlink($lokasi . $fileLama);
        }

        $file->move($lokasi, $fileBaru, true);
        $sukses = $this->userProfilModel->update($idProfil, ['foto' => $fileBaru]);

        session()->setFlashdata($sukses ? 'sukses' : 'error', lang($sukses ? "App.update-success" : "App.update-error"));
        return redirect()->back();
    }

    public function updateAkun()
    {
        $response = [];
        $idUser = $this->request->getPost('id_user');

        if (auth()->id() !== (int)$idUser) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Hanya pemilik ID yang dapat merubah data.']);
        }

        $users = auth()->getProvider();
        $user = $users->findById($idUser);

        if (!$user) {
            return $this->response->setJSON(['success'  => false, 'messages' => 'ID User tidak ditemukan.']);
        }

        $userData = [
            'username' => $this->request->getPost('username'),
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

        if (! $this->validateData($data, $rules)) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        try {
            $user->fill($userData);

            if ($users->save($user)) {
                $response = ['success'  => true, 'messages' => lang("App.update-success")];
            } else {
                $response = ['success'  => false, 'messages' => lang("App.update-error")];
            }

            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            log_message('error', 'Gagal simpan profil/update-akun: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => 'Terjadi kesalahan saat merubah data user.']);
        }
    }

    public function updateInfo()
    {
        // if (!auth()->user()->can('klien.edit')) {
        //     return $this->response->setJSON(['success'  => false, 'messages' => 'Anda tidak memiliki izin untuk mengedit user.']);
        // }
        $response = [];
        $idUser = $this->request->getPost('id_user');
        $idProfil = $this->request->getPost('id_profil');

        if (!$idUser || !$idProfil) {
            return $this->response->setJSON(['success'  => false, 'messages' => 'ID user profil tidak ditemukan.']);
        }

        if (auth()->id() !== (int)$idUser) {
            return $this->response->setJSON(['success' => false, 'messages' => 'Hanya pemilik ID yang dapat merubah data.']);
        }

        $data = [
            'user_id' => $idUser,
            'perusahaan' => $this->request->getPost('perusahaan'),
            'whatsapp' => trim($this->request->getPost('whatsapp')),
            'telegram' => trim($this->request->getPost('telegram')),
            'alamat' => $this->request->getPost('alamat')
        ];

        $validasi = $this->userProfilModel->validationRules;
        $data = $this->request->getPost(array_keys($validasi));

        if (! $this->validateData($data, $validasi)) {
            return $this->response->setJSON(['success'  => false, 'messages' => $this->validation->getErrors()]);
        }

        try {
            if ($this->userProfilModel->update($idProfil, $data)) {
                $response = ['success'  => true, 'messages' => lang("App.update-success")];
            } else {
                $response = ['success'  => false, 'messages' => lang("App.update-error")];
            }

            return $this->response->setJSON($response);
        } catch (\Exception $e) {
            log_message('error', 'Gagal simpan profil/update-info: ' . $e->getMessage());
            return $this->response->setJSON(['success'  => false, 'messages' => 'Terjadi kesalahan saat merubah data.']);
        }
    }
}
