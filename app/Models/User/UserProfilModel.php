<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserProfilModel extends Model
{
    protected $table = 'user_profil';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['user_id', 'perusahaan', 'whatsapp', 'telegram', 'alamat', 'foto'];
    protected $useTimestamps = false;
    protected $createdField = 'dibuat';
    protected $updatedField = 'dirubah';

    protected $validationRules = [
        // 'user_id' => ['label' => 'Id User', 'rules' => 'required|integer'],
        'perusahaan' => ['label' => 'Perusahaan', 'rules' => 'permit_empty|min_length[5]|max_length[30]'],
        'whatsapp' => ['label' => 'Whatsapp', 'rules' => 'permit_empty|integer|min_length[8]|max_length[15]'],
        'telegram' => ['label' => 'Telegram', 'rules' => 'permit_empty|integer|min_length[8]|max_length[15]'],
        'alamat' => ['label' => 'Alamat', 'rules' => 'permit_empty|min_length[10]|max_length[100]'],
        // 'foto' => ['label' => 'Foto Profil', 'rules' => 'permit_empty|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]']
    ];

    protected $validationMessages   = [
        'user_id' => [
            'required' => '{field} tidak ditemukan.',
            'integer' => '{field} harus berupa angka.'
        ],
        'perusahaan' => [
            'max_length' => '{field} minimal 5 karakter.',
            'max_length' => '{field} maksimal 30 karakter.'
        ],
        'whatsapp' => [
            'integer' => '{field} harus berupa angka.',
            'min_length' => '{field} minimal 8 karakter.',
            'max_length' => '{field} maksimal 15 karakter.'
        ],
        'telegram' => [
            'integer' => '{field} harus berupa angka.',
            'min_length' => '{field} minimal 8 karakter.',
            'max_length' => '{field} maksimal 15 karakter.'
        ],
        'alamat' => [
            'min_length' => '{field} minimal 10 karakter.',
            'max_length' => '{field} maksimal 100 karakter.'
        ],
        'foto' => [
            'max_size' => '{field} maksimal 2MB.',
            'is_image' => '{field} harus berupa gambar.',
            'mime_in' => '{field} harus berekstensi jpg, jpeg, atau png.'
        ]
    ];

    public function validasiSimpan()
    {
        $rules = $this->validationRules;
        $rules['user_id'] = ['label' => 'Id User', 'rules' => 'required|integer'];
        return $rules;
    }

    // public function getProfil($userId)
    // {
    //     return $this
    //         ->select('id, perusahaan, whatsapp, telegram, alamat, foto')
    //         ->where('user_id', $userId)
    //         ->first();
    // }

    /**
     * @see app\Controllers\Profil.php
     */
    public function getFoto($id)
    {
        return $this->select('foto')->where('id', $id)->get()->getRow('foto');
    }
}