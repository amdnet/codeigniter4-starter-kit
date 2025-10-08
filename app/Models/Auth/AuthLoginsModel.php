<?php

namespace App\Models\Auth;

use CodeIgniter\Model;

class AuthLoginsModel extends Model
{
	protected $table 		  	= 'auth_logins';
	protected $primaryKey 	  	= 'id';
	protected $returnType 	  	= 'object';
	protected $allowedFields  	= ['ip_address', 'user_agent', 'id_type', 'identifier', 'user_id', 'date', 'success'];
	protected $useTimestamps  	= false;

	public function tabel()
    {
        return $this
            ->select('auth_logins.id AS auth_login_id, ip_address, user_agent, id_type, identifier, user_id, date, success,
                user_login.id AS user_login_id, user_login.*, 
                users.username')
            ->join('user_login', 'user_login.login_id = auth_logins.id', 'left')
            ->join('users', 'users.id = auth_logins.user_id', 'left')
            ->findAll();
    }

    public function getProfil($userId)
    {
        return $this
            ->select('auth_logins.*, user_login.*')
            ->join('user_login', 'user_login.login_id = auth_logins.id', 'left')
            ->where('user_id', $userId)
            ->first();
    }

    public function cekNull()
    {
        return $this->select('id')->limit(1)->get()->getRow();
    }
}