<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use App\Models\User\UserProfilModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Dapatkan provider user Shield (default UserModel)
        $users = auth()->getProvider();

        // Membuat user baru
        $user = new User([
            'username' => 'admin satu',
            'email'    => 'admin@mail.com',
            'password' => 'cirebon321', // plain text, Shield akan hash otomatis
        ]);

        // Simpan user ke database
        $users->save($user);
        $userId = $users->getInsertID();

        // Ambil user yang baru saja disimpan dengan ID
        $user = $users->findById($userId);

        // Menambahkan user ke group 'admin'
        $user->addGroup('admin');

        // Menambahkan user id ke profil
        $userProfilModel = new UserProfilModel();

        $dataProfil = [
            'user_id' => $userId,
            // kolom lain jika ada
        ];

        $userProfilModel->insert($dataProfil);
    }
}
// php spark db:seed UserSeeder