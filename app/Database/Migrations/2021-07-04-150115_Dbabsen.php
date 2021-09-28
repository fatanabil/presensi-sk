<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dbabsen extends Migration
{
	public function up()
	{
		// membuat table guru
		$this->forge->addField([
			'id_guru' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'nama'	=> ['type' => 'varchar', 'constraint' => 100],
			'jenkel' => ['type' => 'ENUM("L", "P")'],
			'alamat' => ['type' => 'varchar', 'constraint' => 100]
		]);

		$this->forge->addKey('id_guru', true);
		$this->forge->createTable('guru', true);

		// membuat tabel kelas
		$this->forge->addField([
			'id_kelas' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'kelas' => ['type' => 'ENUM("V A", "V B", "V C")'],
			'id_guru' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0]
		]);

		$this->forge->addKey('id_kelas', true);
		$this->forge->addForeignKey('id_guru', 'guru', 'id_guru', FALSE, 'CASCADE');
		$this->forge->createTable('kelas', true);

		// membuat tabel siswa
		$this->forge->addField([
			'id_siswa' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'nama' => ['type' => 'varchar', 'constraint' => 100],
			'id_kelas' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
			'jenkel' => ['type' => 'ENUM("L", "P")'],
			'alamat' => ['type' => 'varchar', 'constraint' => 100]
		]);

		$this->forge->addKey('id_siswa', true);
		$this->forge->addForeignKey('id_kelas', 'kelas', 'id_kelas', FALSE, 'CASCADE');
		$this->forge->createTable('siswa', true);

		// membuat tabel absensi
		$this->forge->addField([
			'id_absensi' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
			'tanggal' => ['type' => 'date'],
			'id_siswa' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
			'nama_siswa' => ['type' => 'varchar', 'constraint' => 100],
			'semester' => ['type' => 'ENUM("ganjil", "genap")'],
			'absen' => ['type' => 'ENUM("h", "i", "s", "a")']
		]);

		$this->forge->addKey('id_absensi', true);
		$this->forge->addForeignKey('id_siswa', 'siswa', 'id_siswa', FALSE, 'CASCADE');
		$this->forge->createTable('absensi', true);
	}

	public function down()
	{
		if ($this->db->DBDriver != 'SQLite3') {
			$this->forge->dropForeignKey('kelas', 'kelas_guru_foreign');
			$this->forge->dropForeignKey('siswa', 'siswa_kelas_foreign');
			$this->forge->dropForeignKey('absensi', 'absensi_siswa_foreign');
		}
		$this->forge->dropTable('guru');
		$this->forge->dropTable('siswa');
		$this->forge->dropTable('kelas');
		$this->forge->dropTable('absensi');
	}
}
