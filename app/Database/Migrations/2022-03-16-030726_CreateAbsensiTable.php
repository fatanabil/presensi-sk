<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_absensi' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'tanggal' => ['type' => 'DATE'],
			'id_siswa' => ['type' => 'INT', 'constraint' => 11],
			'nama_siswa' => ['type' => 'VARCHAR', 'constraint' => 100],
			'semester' => ['type' => 'ENUM', 'constraint' => ['ganjil', 'genap']],
			'absen' => ['type' => 'ENUM', 'constraint' => ['h', 'i', 's', 'a']],
		]);

		$this->forge->addKey('id_absensi', true);
		$this->forge->createTable('absensi', true);
	}

	public function down()
	{
		$this->forge->dropTable('absensi', true);
	}
}
