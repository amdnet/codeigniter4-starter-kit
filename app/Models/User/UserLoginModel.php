<?php

namespace App\Models\User;

use CodeIgniter\Model;

class UserLoginModel extends Model
{
	protected $table 		  	= 'user_login';
	protected $primaryKey 	  	= 'id';
	protected $returnType 	  	= 'object';
	protected $allowedFields    = [
        'login_id',
        'perangkat',
        'os',
        'browser',
        'brand',
        'model',
        'negara',
        'wilayah',
        'distrik',
        'zona_waktu',
        'isp'
    ];
	protected $useTimestamps  	= false;
}
