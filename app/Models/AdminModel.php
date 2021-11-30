<?php

namespace App\Models;

use CodeIgniter\Model;
use phpDocumentor\Reflection\Types\Null_;

class AdminModel extends Model
{
	protected $table = 'users';
	protected $db, $builder;
	protected $allowedFields = ['id_user', 'username', 'fullname', 'nama', 'jenkel', 'alamat', 'id_guru', 'kelas'];

	public function __construct()
	{
		$this->db      = \Config\Database::connect();
		$this->builder = $this->db->table('users');
	}

	public function getDataUser()
	{
		$this->builder = $this->db->table('users');
		$this->builder->select('users.id_user, username, fullname, level, user_guru_group.id_guru as aktif');
		$this->builder->join('user_guru_group', 'user_guru_group.id_user = users.id_user', 'left');
		$this->builder->orderBy('level', 'ASC');
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
		$this->builder->select('users.id_user, username, fullname, level, guru.nama, guru.id_guru');
		$this->builder->join('user_guru_group', 'user_guru_group.id_user = users.id_user', 'left');
		$this->builder->join('guru', 'guru.id_guru = user_guru_group.id_guru', 'left');
		$this->builder->where('users.id_user', $id);
		$query = $this->builder->get()->getResult()[0];

		return $query;
	}

	public function getIdGuru()
	{
		$this->builder = $this->db->table('guru');
		$this->builder->select('id_guru, nama');
		$query = $this->builder->get()->getResult();

		return $query;
	}

	public function getDataGuruAll()
	{
		$this->builder = $this->db->table('users');
		$this->builder->select('users.id_user, username, guru.nama, guru.id_guru, guru.jenkel, guru.alamat, kelas.kelas');
		$this->builder->join('user_guru_group', 'user_guru_group.id_user = users.id_user');
		$this->builder->join('guru', 'guru.id_guru = user_guru_group.id_guru', 'right');
		$this->builder->join('kelas', 'kelas.id_guru = guru.id_guru', 'left');
		$this->builder->orderBy('kelas.id_kelas', 'ASC');
		$query = $this->builder->get()->getResult();

		return $query;
	}

	public function getKelas()
	{
		$this->builder = $this->db->table('kelas');
		$this->builder->select('id_kelas, kelas, id_guru');
		$this->builder->orderBy('id_kelas', 'ASC');
		$query = $this->builder->get()->getResult();

		return $query;
	}

	public function updateUser($id, $level)
	{
		$this->builder = $this->db->table('users');
		$this->builder->where('id_user', $id);
		$this->builder->update(['level' => $level]);

		return $this->db->affectedRows();
	}

	public function insertIdUserGuru($idUser, $idGuru)
	{
		$this->builder = $this->db->table('user_guru_group');
		$this->builder->where('id_user', $idUser);
		$this->builder->update(['id_guru' => $idGuru]);

		return $this->db->affectedRows();
	}

	public function saveDataGuru($data)
	{
		$this->builder = $this->db->table('guru');
		$this->save([
			'nama' => $data['nama-guru'],
			'jenkel' => $data['jenkel'],
			'alamat' => $data['alamat-guru']
		]);
		$idguru = $this->getInsertID();
		$this->saveKelasGuru($data, $idguru);

		return $this->db->affectedRows();
	}

	public function saveKelasGuru($data, $id)
	{
		$this->builder = $this->db->table('kelas');
		$this->builder->where('kelas', $data['kelas']);
		$this->builder->update([
			'id_guru' => $id
		]);
	}
}
