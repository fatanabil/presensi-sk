<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_user' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'username' => ['type' => 'VARCHAR', 'constraint' => 100],
			'fullname' => ['type' => 'VARCHAR', 'constraint' => 100],
			'password_hash' => ['type' => 'VARCHAR', 'constraint' => 100],
			'salt' => ['type' => 'VARCHAR', 'constraint' => 100],
			'level' => ['type' => 'ENUM', 'constraint' => ['admin', 'user']],
		]);

		$this->forge->addKey('id_user', true);
		$this->forge->createTable('users', true);
	}

	public function down()
	{
		$this->forge->dropTable('users', true);
	}
}
