<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatUserLogin extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'login_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],

            // Kolom Device
            'perangkat' => ['type' => 'varchar', 'constraint' => 20, 'null' => true], // Dekstop, Mobile
            'os' => ['type' => 'varchar', 'constraint' => 100, 'null' => true], // Windows 10 64-bit
            'browser' => ['type' => 'varchar', 'constraint' => 100, 'null' => true], // Firefox 142.0 64-bit
            'brand' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'model' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],

            // Kolom GeoIP
            'negara' => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'wilayah' => ['type' => 'varchar', 'constraint' => 100, 'null' => true], // provinsi
            'distrik' => ['type' => 'varchar', 'constraint' => 100, 'null' => true], // kota, kabupaten
            'zona_waktu' => ['type' => 'varchar', 'constraint' => 50, 'null' => true],
            'isp' => ['type' => 'varchar', 'constraint' => 150, 'null' => true] // isp provider
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('login_id', 'auth_logins', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('user_login');
    }

    public function down()
    {
        if ($this->db->DBDriver !== 'SQLite3') {
            $this->forge->dropForeignKey('user_login', 'user_login_login_id_foreign');
        }

        $this->forge->dropTable('user_login');
    }
}
