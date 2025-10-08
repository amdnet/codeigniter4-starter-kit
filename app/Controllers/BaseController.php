<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\I18n\Time;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = ['url'];
    protected $validation;
    protected $db;
    protected $session;
    // protected $profil;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = \Config\Services::session();
        // $this->request = \Config\Services::request();
        // $this->validation = \Config\Services::validation();
        $this->session = service('session');
        $this->validation = service('validation');
        $this->db = \Config\Database::connect();

        // Set locale dari JSON
        // $this->request->setLocale(panel_setting('App_defaultLocale'));

        // Set timezone dari JSON
        // date_default_timezone_set(panel_setting('App_appTimezone', config('App')->appTimezone));
        // date_default_timezone_set(config('App')->appTimezone);
        // $this->updateUserSessionActivity();


        // if (auth()->loggedIn()) {
        //     $user = auth()->user();
        //     $profilModel = new \App\Models\User\ProfilModel();
        //     $profil = $profilModel->getProfil($user->id);
        //     \Config\Services::renderer()->setVar('profil', $profil);
        // }
    }


    // private function updateUserSessionActivity()
    // {
    //     // Pastikan pengguna sudah login
    //     if (auth()->loggedIn()) {
    //         $shieldSessionId = session('remember');

    //         if ($shieldSessionId) {
    //             $db = db_connect();
    //             $db->table('user_sessions')
    //                 ->where('shield_session_id', $shieldSessionId)
    //                 ->update(['last_active' => Time::now('Asia/Jakarta', 'en_US')]);
    //         }
    //     }
    // }
}
