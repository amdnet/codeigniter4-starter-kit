<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatAuthSesi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => false],
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => false],
            'timestamp timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'data'       => ['type' => 'BLOB', 'null' => false],
            'user_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'remember_id'=> ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'perangkat'  => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'os'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'browser'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('timestamp');
        $this->forge->createTable('auth_sesi');
    }

    public function down()
    {
        $this->forge->dropTable('auth_sesi');
    }
}