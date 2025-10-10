<?php

if (!function_exists('format_wa')) {
    /**
     * Mengonversi nomor lokal (08...) menjadi format internasional (628...).
     *
     * @param string|null $nomor Nomor telepon mentah, misal 08123456789.
     * @return string|null Nomor siap untuk wa.me (628123456789) atau null jika kosong.
     */
    function format_wa(?string $nomor): ?string
    {
        if (empty($nomor)) {
            return null;
        }

        // Hapus karakter non-digit
        $nomor = preg_replace('/\D/', '', $nomor);

        // Jika diawali dengan 0 → ubah ke 62
        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        }

        // Jika sudah 62... biarkan
        return $nomor;
    }
}

if (!function_exists('link_wa')) {
    /**
     * Menghasilkan tautan WhatsApp universal (bisa buka di web/app).
     *
     * @param string|null $nomor Nomor telepon mentah.
     * @param string|null $pesan Pesan default (opsional).
     * @return string|null URL WhatsApp yang valid, atau null jika kosong.
     */
    function link_wa(?string $nomor, ?string $pesan = null): ?string
    {
        $nomor = format_wa($nomor);
        if (!$nomor) {
            return null;
        }

        $url = 'https://wa.me/' . $nomor;
        if ($pesan) {
            $url .= '?text=' . urlencode($pesan);
        }

        return $url;
    }
}

if (!function_exists('link_telp')) {
    /**
     * Menghasilkan link telpon (klik langsung buka dialer).
     *
     * @param string|null $nomor Nomor telepon mentah.
     * @return string|null Link telpon valid atau null jika kosong.
     */
    function link_telp(?string $nomor): ?string
    {
        if (empty($nomor)) {
            return null;
        }

        // Hapus karakter non-digit
        $nomor = preg_replace('/\D/', '', $nomor);
        return 'tel:' . $nomor;
    }
}

if (!function_exists('link_telegram')) {
    /**
     * Menghasilkan tautan Telegram (bisa buka di web/app).
     *
     * @param string|null $username Username Telegram tanpa @.
     * @return string|null URL Telegram valid, atau null jika kosong.
     */
    function link_telegram(?string $username): ?string
    {
        if (empty($username)) {
            return null;
        }

        $username = ltrim($username, '@');
        return 'https://t.me/' . $username;
    }
}