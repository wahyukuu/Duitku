<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Aset extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_aset' => [
                'type'           => 'INT',
                'constraint'     => 8,
                'auto_increment' => true,
            ],
            'nama_aset' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'jenis_aset' => [
                'type' => 'VARCHAR',
                'constraint' => '128',
            ],
            'cara_perolehan' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'tahun_perolehan' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '256',
            ],
            'detail' => [
                'type'       => 'TEXT',
            ],
            'nilai_perolehan' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
            ],
            'nilai_sekarang' => [
                'type'       => 'VARCHAR',
                'constraint' => '64',
            ],
        ]);
        $this->forge->addKey('id_aset', true);
        $this->forge->createTable('aset');
    }

    public function down()
    {
        $this->forge->dropTable('aset');
    }
}
