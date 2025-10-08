<?php

namespace App\Controllers\Auth;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Models\UserModel;
use App\Libraries\EmailLibrari;

class MagicLink extends Controller
{
    /**
     * Menangani permintaan untuk mengirim Magic Link.
     */
    public function sendMagicLink()
    {
        // --- Langkah 1: Panggil Logic Shield untuk mengirim link ---
        $emailAddress = $this->request->getPost('email');
        // $users = auth()->getProvider();
        // $user = $users->findByCredentials(['email' => $emailAddress]);
        $user = model(UserModel::class)->where('email', $emailAddress)->first();
        // $user = model('UserModel')->where('email', $emailAddress)->first();

        if ($user === null) {
            return redirect()->back()->with('error', lang('Auth.badAttempt'));
        }

        // Generate token dan simpan di database
        $token = $user->generateLoginToken();
        if (! $token || ! $token->secret) {
            log_message('error', 'Gagal generate token untuk user ID: ' . $user->id);
            return redirect()->back()->with('error', 'Gagal membuat magic link.');
        }

        // --- Langkah 2: Kirim Email menggunakan EmailSender kustom ---
        // Buat Magic Link URL
        $magicLinkUrl = route_to('magic-link-login') . '?token=' . $token->secret . '&email=' . rawurlencode($user->email);

        $subject = lang('Auth.magicLinkSubject');
        $message = view('Auth/Emails/magic_link_message', ['magicLink' => $magicLinkUrl]); // Asumsi Anda punya view ini
        $to      = $user->email;

        $emailLibrari = new EmailLibrari();

        if ($emailLibrari->sendEmail($to, $subject, $message)) {
            return redirect()->back()->with('success', lang('Auth.magicLinkSent'));
        } else {
            // Gagal kirim email: Log error dan berikan pesan yang sesuai
            log_message('error', 'Gagal mengirim magic link ke ' . $to . '. Debugger: ' . service('email')->printDebugger(['headers']));
            return redirect()->back()->with('error', lang('Auth.errorSendingEmail'));
        }
    }
}
