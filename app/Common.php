<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

// use CodeIgniter\I18n\Time;

// if (! function_exists('humanizeId')) {
//     /**
//      * Fungsi untuk mengubah timestamp atau Time instance menjadi format "waktu yang lalu" dalam bahasa Indonesia.
//      *
//      * @param int|Time $waktu Timestamp (int) atau instance Time
//      * @return string
//      */
//     function humanizeId($waktu)
//     {
//         if (empty($waktu)) return 'Tidak diketahui';

//         if (is_string($waktu)) {
//             $waktu = new Time($waktu, 'Asia/Jakarta');
//         } elseif (is_numeric($waktu)) {
//             $waktu = Time::createFromTimestamp((int) $waktu, 'Asia/Jakarta');
//         }

//         $now = Time::now()->getTimestamp();
//         $stamp = $waktu->getTimestamp();
//         $diff = $now - $stamp;

//         // Validasi ekstrem
//         if ($diff < 0 || $stamp < 1000000000 || $stamp > 4294967295) {
//             return $waktu->toLocalizedString('MMMM yyyy');
//         }

//         if ($diff < 60) return $diff . ' detik yang lalu';
//         if ($diff < 3600) return floor($diff / 60) . ' menit yang lalu';
//         if ($diff < 86400) return floor($diff / 3600) . ' jam yang lalu';
//         if ($diff < 604800) return floor($diff / 86400) . ' hari yang lalu';
//         if ($diff < 2419200) return floor($diff / 604800) . ' minggu yang lalu';
//         if ($diff < 29030400) return floor($diff / 2419200) . ' bulan yang lalu';

//         return $waktu->toLocalizedString('MMMM yyyy');
//     }
// }
// humanizeId('2025-10-01 00:36:41'); // string → otomatis diubah
// humanizeId(4294967295);            // timestamp → langsung diproses
// humanizeId(new Time('2025-10-01')); // objek Time → langsung dipakai
