<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_kelas' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment'],
			'kelas' => ['type' => 'VARCHAR', 'constraint' => 20, ],
			'id_guru' => ['type' => 'INT', 'constraint' => 11],
		]);

		$this->forge->addKey('id_kelas', true);
		$this->forge->createTable('kelas', true);
	}

	public function down()
	{
		$this->forge->dropTable('kelas', true);
	}
}
