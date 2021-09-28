<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
	protected $table = 'users';
	protected $db, $builder;
	protected $allowedFields = ['id_user', 'username', 'fullname'];

	public function __construct()
	{
		$this->db      = \Config\Database::connect();
		$this->builder = $this->db->table('users');
	}

	public function getDataUser()
	{
		$this->builder = $this->db->table('users');
		$this->builder->select('id_user, username, fullname, level');
		$query = $this->builder->get()->getResult();

		return $query;
	}

	public function deleteUser($id)
	{
		$this->builder = $this->db->table('users');
		$this->builder->where('id_user', $id);
		$this->builder->delete();

		return $this->db->affectedRows();
	}

	public function getDataGuru($id)
	{
		$this->builder = $this->db->table('users');
		$this->builder->select('users.id_user, username, fullname, level, guru.nama, guru.id_guru, kelas.kelas');
		$this->builder->join('user_guru_group', 'user_guru_group.id_user = users.id_user');
		$this->builder->join('guru', 'guru.id_guru = user_guru_group.id_guru');
		$this->builder->join('kelas', 'kelas.id_guru = guru.id_guru');
		$this->builder->where('users.id_user', $id);
		$query = $this->builder->get()->getResult()[0];

		return $query;
	}

	public function getKelas()
	{
		$this->builder = $this->db->table('kelas');
		$this->builder->select('id_kelas, kelas, id_guru');
		$query = $this->builder->get()->getResult();

		return $query;
	}

	public function changeLevel($id, $level)
	{
		$this->builder = $this->db->table('users');
		$this->builder->where('id_user', $id);
		$this->builder->update(['level' => $level]);

		return $this->db->affectedRows();
	}
}
