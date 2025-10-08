<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table 		  	= 'users';
	protected $primaryKey 	  	= 'id';
	protected $returnType 	  	= 'object';
	protected $allowedFields  	= ['username', 'status', 'active'];
	protected $useTimestamps  	= true;
	protected $createdField   	= 'created_at';
	protected $updatedField   	= 'updated_at';
	protected $deletedField		= 'deleted_at';

	protected $validationRules = [
		'username' => 'required|min_length[3]|max_length[30]|regex_match[/\A[a-zA-Z0-9\.]+\z/]', // Nama user
		'active' => 'required|integer', // Aktivasi
	];

	protected $validationMessages = [
		'username' => [
			'required' => 'Nama user wajib diisi.!',
			'min_length' => 'Nama user minimal 3 karakter.!',
			'max_length' => 'Nama user maksimal 30 karakter.!',
			'regex_match' => 'Nama user hanya boleh berisi huruf, angka, dan titik.!',
		],
		'active' => [
			'required' => 'Aktivasi wajib diisi.!',
			'integer' => 'Aktivasi harus berupa angka.!'
		]
	];

	/**
	 * Menampilkan data tabel user-list.
	 * @see app\Controllers\Profil.php -> tabel()
	 * @return object
	 */
	public function tabelUserList()
	{
		return $this
			->select('users.id iduser, users.username, users.active, 
				aid.last_used_at, aid.secret email, aid.created_at, aid.updated_at, agu.group')
			->join('auth_identities aid', 'aid.user_id = users.id AND aid.type = "email_password"', 'left')
			->join('auth_groups_users agu', 'agu.user_id = users.id', 'left')
			->get()->getResult();
	}

	/**
	 * Menampilkan data ajax modal edit.
	 * @see app\Controllers\Profil.php -> getId()
	 * @return object
	 */
	public function getId($id)
	{
		return $this
			->select('users.id iduser, users.username, users.active, aid.secret email, agu.group, 
				upf.id idprofil, upf.perusahaan, upf.whatsapp, upf.telegram, upf.alamat')
			->join('auth_identities aid', 'aid.user_id = users.id')
			->join('auth_groups_users agu', 'agu.user_id = users.id', 'left')
			->join('user_profil upf', 'upf.user_id = users.id', 'left')
			->where('users.id', $id)
			->first();
	}

	/**
	 * Menampilkan data profil user.
	 * @see app\Controllers\Profil.php -> index()
	 * @return object
	 */
	public function getProfil($id)
	{
		return $this
			->select('users.username, aid.secret email, aid.last_used_at, aid.created_at,
				upf.id id_profil, upf.perusahaan, upf.whatsapp, upf.telegram, upf.alamat, upf.foto')
			->join('auth_identities aid', 'aid.user_id = users.id')
			->join('user_profil upf', 'upf.user_id = users.id')
			->where('users.id', $id)
			->first();
	}

}
