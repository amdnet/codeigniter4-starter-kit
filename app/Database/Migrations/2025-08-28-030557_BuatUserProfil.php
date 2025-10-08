<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatUserProfil extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'perusahaan' => ['type' => 'varchar', 'constraint' => 30, 'null' => true],
            'whatsapp' => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'telegram' => ['type' => 'varchar', 'constraint' => 15, 'null' => true],
            'alamat' => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'foto' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'dibuat datetime default current_timestamp',
            'dirubah datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'NO ACTION', 'CASCADE');
        $this->forge->createTable('user_profil');
    }

    public function down()
    {
        if ($this->db->DBDriver !== 'SQLite3') {
            $this->forge->dropForeignKey('user_profil', 'user_profil_user_id_foreign');
        }

        $this->forge->dropTable('user_profil');
    }
}

// php spark migrate --all
// php spark migrate:rollback -all
// php spark migrate:refresh -all
// php spark migrate:status