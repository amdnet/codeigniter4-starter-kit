<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\EmailLibrari; // Import class Library yang sudah dibuat

class Email extends Controller
{
    public function tesKirimEmail()
    {
        // 1. Ambil inputan atau data yang diperlukan
        $penerima = $this->request->getPost('penerimaEmail'); 
        $judul    = "Tes Pengiriman Email CI4 Dinamis";
        $pesan    = "Halo, ini adalah pesan tes dari CodeIgniter 4 menggunakan konfigurasi SMTP dari **database**!";

        // 2. Gunakan Service Class kustom Anda
        $emailLibrari = new EmailLibrari();
        
        if ($emailLibrari->sendEmail($penerima, $judul, $pesan)) {
            return redirect()->back()->with('success', 'Email berhasil dikirim menggunakan pengaturan DB!');
        } else {
            // Jika gagal, Anda bisa ambil debugger untuk melihat masalahnya:
            // $debug = Services::email()->printDebugger(['headers']); 
            return redirect()->back()->with('error', 'Email gagal dikirim. Cek log atau debugger.');
        }
    }
}