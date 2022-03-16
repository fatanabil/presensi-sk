<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuruTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_guru' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
			'jenkel' => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
			'alamat' => ['type' => 'VARCHAR', 'constraint' => 100]
		]);

		$this->forge->addKey('id_guru', true);
		$this->forge->createTable('guru', true);
	}

	public function down()
	{
		$this->forge->dropTable('guru', true);
	}
}
