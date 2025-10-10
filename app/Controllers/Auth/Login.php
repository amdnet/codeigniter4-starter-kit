<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;
use App\Libraries\AuthLoginsLastIdLibrari;
use App\Libraries\UserLoginLibrari;

class Login extends ShieldLogin
{
    public function loginAction(): RedirectResponse
    {
        $result = parent::loginAction();

        if ($result instanceof RedirectResponse) {
            $errorText = trim(session('error') ?? '');
            $errorInfo = $errorText === '' ? null : $errorText;
            $errorTipe = $errorInfo === null ? null : $this->parseErrorTipe($errorText);

            $authLogId = AuthLoginsLastIdLibrari::getId();
            if ($authLogId) {
                (new UserLoginLibrari())->logInfoLogin($authLogId, $errorTipe, $errorInfo);
                AuthLoginsLastIdLibrari::reset();
            }
        }

        return $result;
    }

    private function parseErrorTipe(string $errorText): string
    {
        $lower = mb_strtolower($errorText, 'UTF-8');

        if (str_contains($lower, 'kredensial')) {
            return 'Salah email';
        }

        if (str_contains($lower, 'kata sandi')) {
            return 'Salah password';
        }

        if (str_contains($lower, 'terlalu banyak') || str_contains($lower, 'coba lagi nanti')) {
            return 'Terlalu banyak percobaan';
        }

        return 'Kesalahan tidak diketahui';
    }
}

