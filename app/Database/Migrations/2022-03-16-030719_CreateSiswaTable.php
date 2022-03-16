<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSiswaTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_siswa' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'nama' => ['type' => 'VARCHAR', 'constraint' => 100],
			'id_kelas' => ['type' => 'INT', 'constraint' => 11],
			'jenkel' => ['type' => 'ENUM', 'constraint' => ['L', 'P']],
			'alamat' => ['type' => 'VARCHAR', 'constraint' => 100]
		]);

		$this->forge->addKey('id_siswa', true);
		$this->forge->createTable('siswa', true);
	}

	public function down()
	{
		$this->forge->dropTable('siswa', true);
	}
}
