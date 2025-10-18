<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\MagicLinkController as ShieldMagicLink;
use App\Libraries\EmailLibrari;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Authentication\Authenticators\Session;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\I18n\Time;

class MagicLink extends ShieldMagicLink
{
    public function loginAction()
    {
        if (! setting('Auth.allowMagicLinkLogins')) {
            return redirect()->route('login')->with('error', lang('Auth.magicLinkDisabled'));
        }

        // Validasi email
        $rules = $this->getValidationRules();
        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->route('magic-link')->with('errors', $this->validator->getErrors());
        }

        // Cari user
        $email = $this->request->getPost('email');
        $user  = $this->provider->findByCredentials(['email' => $email]);

        if ($user === null) {
            return redirect()->route('magic-link')->with('error', lang('Auth.invalidEmail', [$email]));
        }

        /** @var UserIdentityModel $identityModel */
        $identityModel = model(UserIdentityModel::class);

        // Hapus magic link lama
        $identityModel->deleteIdentitiesByType($user, Session::ID_TYPE_MAGIC_LINK);

        // Generate token
        helper('text');
        $token = random_string('crypto', 20);

        $identityModel->insert([
            'user_id' => $user->id,
            'type'    => Session::ID_TYPE_MAGIC_LINK,
            'secret'  => $token,
            'expires' => Time::now()->addSeconds(setting('Auth.magicLinkLifetime')),
        ]);

        /** @var IncomingRequest $request */
        $request   = service('request');
        $ipAddress = $request->getIPAddress();
        $userAgent = (string) $request->getUserAgent();
        $date      = Time::now()->toDateTimeString();

        // === Custom Email via EmailLibrari ===
        $emailLibrari = new EmailLibrari();
        $view   = $this->view(
            setting('Auth.views')['magic-link-email'],
            [
                'token'     => $token,
                'user'      => $user,
                'ipAddress' => $ipAddress,
                'userAgent' => $userAgent,
                'date'      => $date,
            ],
            ['debug' => false]
        );

        if (! $emailLibrari->kirimEmail($user->email, lang('Auth.magicLinkSubject'), $view)) {
            return redirect()->route('magic-link')->with('error', lang('Auth.unableSendEmailToUser', [$user->email]));
        }
        // === End Custom Email ===

        // Sisanya tetap pakai bawaan Shield
        return $this->displayMessage();
    }
}
