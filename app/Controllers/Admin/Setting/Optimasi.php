<?php

namespace App\Controllers\Admin\Setting;

use App\Controllers\BaseController;

class Optimasi extends BaseController
{

    public function index()
    {
        $data = [
            'pageTitle' => 'Optimasi',
            'navigasi' => '<a href="/admin/setting">Setting</a> &nbsp;',
        ];
        return view('admin/setting/optimasi', $data);
    }

    private function getFolderSize($path)
    {
        $size = 0;
        foreach (glob($path . '*') as $file) {
            if (is_file($file) && basename($file) !== 'index.html') {
                $size += filesize($file);
            }
        }
        return round($size / 1048576, 2); // Convert to MB
    }

    private function formatWaktuRelatif($timestamp)
    {
        if (!$timestamp || !is_numeric($timestamp)) return 'Tidak diketahui';

        $selisih = time() - $timestamp;

        if ($selisih < 3600) {
            $menit = floor($selisih / 60);
            return "{$menit} menit lalu";
            // return 'Baru saja';
        } elseif ($selisih < 86400) {
            $jam = floor($selisih / 3600);
            return "{$jam} jam lalu";
        } elseif ($selisih < 2592000) {
            $hari = floor($selisih / 86400);
            return "{$hari} hari lalu";
        } else {
            $bulan = floor($selisih / 2592000);
            return "{$bulan} bulan lalu";
        }
    }

    public function getInfo()
    {
        $logPath = WRITEPATH . 'logs/';
        $logFile = array_diff(scandir($logPath), ['.', '..', 'index.html']);
        $logCount = count($logFile);

        $debugPath = WRITEPATH . 'debugbar/';
        $debugFile = array_diff(scandir($debugPath), ['.', '..', 'index.html']);
        $debugCount = count($debugFile);

        $logSize = $this->getFolderSize($logPath);
        $debugSize = $this->getFolderSize($debugPath);

        $tables = $this->db->listTables();
        $tableCount = count($tables);

        $logFlag = WRITEPATH . 'flag/file_log.flag';
        $logClear = is_file($logFlag) ? (int) file_get_contents($logFlag) : null;
        $logTime = $logClear ? $this->formatWaktuRelatif($logClear) : 'Belum pernah';

        $debugFlag = WRITEPATH . 'flag/file_debug.flag';
        $debugClear = is_file($debugFlag) ? (int) file_get_contents($debugFlag) : null;
        $debugTime = $debugClear ? $this->formatWaktuRelatif($debugClear) : 'Belum pernah';

        $dbOptimasiFlag = WRITEPATH . 'flag/db_optimasi.flag';
        $dbOptimasiClear = is_file($dbOptimasiFlag) ? (int) file_get_contents($dbOptimasiFlag) : null;
        $dbOptimasiTime = $dbOptimasiClear ? $this->formatWaktuRelatif($dbOptimasiClear) : 'Belum pernah';

        $dbAnalisisFlag = WRITEPATH . 'flag/db_analisis.flag';
        $dbAnalisisClear = is_file($dbAnalisisFlag) ? (int) file_get_contents($dbAnalisisFlag) : null;
        $dbAnalisisTime = $dbAnalisisClear ? $this->formatWaktuRelatif($dbAnalisisClear) : 'Belum pernah';

        // $dbRebuildFlag = WRITEPATH . 'flag/db_rebuild.flag';
        // $dbRebuildClear = is_file($dbRebuildFlag) ? (int) file_get_contents($dbRebuildFlag) : null;
        // $dbRebuildTime = $dbRebuildClear ? $this->formatWaktuRelatif($dbRebuildClear) : 'Belum pernah';

        return $this->response->setJSON([
            'logCount' => (float) $logCount,
            'logSize' => $logSize,
            'logTime' => (string) $logTime,
            'debugCount' => (float) $debugCount,
            'debugSize' => $debugSize,
            'debugTime' => (string) $debugTime,
            'tableCount' => (float) $tableCount,
            'dbOptimasiTime' => (string) $dbOptimasiTime,
            'dbAnalisisTime' => (string) $dbAnalisisTime
            // 'dbRebuildTime' => (string) $dbRebuildTime,
        ]);
    }

    public function hapusLog()
    {
        $files = glob(WRITEPATH . 'logs/*');

        $logFiles = array_filter($files, function ($file) {
            return is_file($file) && basename($file) !== 'index.html';
        });

        $deletedCount = 0;
        foreach ($logFiles as $file) {
            if (@unlink($file)) {
                $deletedCount++;
            }
        }

        file_put_contents(WRITEPATH . 'flag/file_log.flag', time());

        return $this->response->setJSON([
            'success' => true,
            'messages' => "Pembersihan selesai. <br> {$deletedCount} file log dihapus."
        ]);
    }

    public function hapusDebug()
    {
        $files = glob(WRITEPATH . 'debugbar/*');

        $deletedCount = 0;
        foreach ($files as $file) {
            if (is_file($file)) {
                if (@unlink($file)) {
                    $deletedCount++;
                }
            }
        }

        file_put_contents(WRITEPATH . 'flag/file_debug.flag', time());

        return $this->response->setJSON([
            'success' => true,
            'messages' => "DebugBar dibersihkan. <br> {$deletedCount} file dihapus."
        ]);
    }

    public function dbOptimasi()
    {
        $tables = $this->db->listTables();
        $count = 0;

        foreach ($tables as $table) {
            if ($this->db->query("OPTIMIZE TABLE `{$table}`")) {
                $count++;
            }
        }

        file_put_contents(WRITEPATH . 'flag/db_optimasi.flag', time());

        return $this->response->setJSON([
            'success' => true,
            'messages' => "Optimasi {$count} tabel selesai."
        ]);
    }

    public function dbAnalisis()
    {
        $tables = $this->db->listTables();
        $count = 0;

        foreach ($tables as $table) {
            if ($this->db->query("ANALYZE TABLE `{$table}`")) {
                $count++;
            }
        }

        file_put_contents(WRITEPATH . 'flag/db_analisis.flag', time());

        return $this->response->setJSON([
            'success' => true,
            'messages' => "Analisis {$count} tabel selesai."
        ]);
    }

    private function dbTabelGenerate(): array
    {
        $status = $this->db->query('SHOW TABLE STATUS')->getResultArray();
        $result = [];
        $no = 1;

        foreach ($status as $row) {
            $rowCount = $this->db->query("SELECT COUNT(*) AS total FROM {$row['Name']}")->getRow()->total;

            $result[] = [
                'no' => $no++,
                'tabel'    => $row['Name'],
                'baris'    => (int) $rowCount,
                'tipe'     => $row['Engine'],
                'kelompok' => $row['Collation'],
                'ukuran'   => round(($row['Data_length'] + $row['Index_length']) / 1024, 2),
                'overhead' => round($row['Data_free'] / 1024, 2),
                'dirubah' => date('Y-m-d H:i:s')
            ];
        }

        $jsonPath = WRITEPATH . 'json/db_tabel.json';
        file_put_contents($jsonPath, json_encode(['data' => $result], JSON_PRETTY_PRINT));

        return $result;
    }

    public function dbTabel()
    {
        $jsonPath = WRITEPATH . 'json/db_tabel.json';

        if (is_file($jsonPath)) {
            $json = file_get_contents($jsonPath);
            try {
                return $this->response->setJSON(json_decode($json, true));
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'messages' => 'Gagal memproses file JSON: ' . $e->getMessage()
                ]);
            }
        }

        $result = $this->dbTabelGenerate();
        return $this->response->setJSON(['data' => $result]);
    }

    public function dbRefresh()
    {
        try {
            $this->dbTabelGenerate();

            file_put_contents(WRITEPATH . 'flag/db_refresh.flag', time());

            return $this->response->setJSON([
                'success' => true,
                'messages' => 'Cache berhasil di generate ulang.'
            ]);
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'success' => false,
                'messages' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
