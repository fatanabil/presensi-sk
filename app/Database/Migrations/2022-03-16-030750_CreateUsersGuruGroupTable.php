<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersGuruGroupTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_guru' => ['type' => 'INT', 'constraint' => 11],
			'id_user' => ['type' => 'INT', 'constraint' => 11],
		]);
		$this->forge->createTable('user_guru_group', true);
	}

	public function down()
	{
		$this->forge->dropTable('user_guru_group', true);
	}
}
