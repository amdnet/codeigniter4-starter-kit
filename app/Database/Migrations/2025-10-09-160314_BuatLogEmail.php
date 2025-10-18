<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatLogEmail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'admin' => ['type' => 'varchar', 'constraint' => 50], // Nama user admin atau sistem
            'email' => ['type' => 'varchar', 'constraint' => 100], // User email penerima
            'judul' => ['type' => 'varchar', 'constraint' => 255], // Judul email
            'status' => ['type' => 'varchar', 'constraint' => 10], // Gagal, Berhasil
            'render' => ['type' => 'float', 'constraint' => '8,2'], // Waktu proses render kirim email (contoh = 1.58) detik
            'error' => ['type' => 'text', 'null' => true], // Informasi error $e->getMessage()
            'dibuat' => ['type' => 'datetime', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('admin');
        $this->forge->addKey('email');
        $this->forge->addKey('status');
        $this->forge->createTable('log_email', true);
    }

    public function down()
    {
        $this->forge->dropTable('log_email');
    }
}
