<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

use function PHPUnit\Framework\isEmpty;

class Admin extends BaseController
{
	protected $adminModel;

	public function __construct()
	{
		$this->session = session();
		$this->adminModel = new AdminModel();
	}

	public function index()
	{
		if (!$this->session->has('isLogin')) {
			return redirect()->to('/auth/login');
		}

		if ($this->session->get('level') !== 'admin') {
			return redirect()->to('/user/index');
		}

		$data['title'] = 'User Lists';

		$data['users'] = $this->adminModel->getDataUser();

		return view('admin/index', $data);
	}

	public function deleteUser($id)
	{
		if ($this->adminModel->deleteUser($id) > 0) {
			$this->session->setFlashdata('del-b', 'Data berhasil dihapus');

			return redirect()->to('/userlists');
		} else {
			$this->session->setFlashdata('del-g', 'Data gagal dihapus');

			return redirect()->to('/userlists');
		}
	}

	public function editUser($id)
	{
		$data['title'] = 'Edit User';
		$data['user'] = $this->adminModel->getDataGuru($id);
		$data['guru'] = $this->adminModel->getIdGuru();

		return view('admin/edit', $data);
	}

	public function save()
	{
		$data = $this->request->getPost();

		if ($this->adminModel->updateUser($data['id'], $data['level']) > 0 && $this->adminModel->insertIdUserGuru($data['id'], $data['id-nama']) > 0) {
			$this->session->setFlashdata('edit-b', 'Data Berhasil diubah');

			return redirect()->to(base_url() . '/userlists');
		} else {
			$this->session->setFlashdata('edit-g', 'Data gagal diubah');

			return redirect()->to(base_url() . '/userlists');
		}
	}

	public function dataguru()
	{
		$data['guru'] = $this->adminModel->getDataGuruAll();
		$data['kelas'] = $this->adminModel->getKelas();

		return view('admin/guru', $data);
	}

	public function addDataGuru()
	{
		$data = $this->request->getPost();
		$data = $this->flipDiagonally($data);

		d($data);

		foreach ($data as $dt) {
			$cek = $this->adminModel->saveDataGuru($dt);
		}

		if ($cek > 0) {
			$this->session->setFlashdata('guru-b', 'Data Guru berhasil ditambah');
		} else {
			$this->session->setFlashdata('guru-g', 'Data Guru gagal ditambah');
		}

		return redirect()->to('admin/dataguru');
	}

	public function editDataGuru($id)
	{
		$guru = $this->adminModel->getDataGuruAll();
		$data['kelas'] = $this->adminModel->getKelas();

		foreach ($guru as $gr) {
			if ($gr->id_guru == $id) {
				$data['guru'] = $gr;
			}
		}

		return view('admin/guru-edit', $data);
	}

	public function updateDataGuru($id)
	{
		$data = $this->request->getPost();

		if (isset($data)) {
			$data['id_guru'] = $id;
			$cek = $this->adminModel->updateDataGuru($data);
		}

		if ($cek > 0) {
			$this->session->setFlashdata('up-guru-b', 'Data Guru berhasil diupdate');
		} else {
			$this->session->setFlashdata('up-guru-g', 'Data Guru gagal diupdate');
		}

		return redirect()->to('admin/dataguru');
	}

	public function delDataGuru($id)
	{
		$cek = $this->adminModel->delDataGuru($id);

		if ($cek > 0) {
			$this->session->setFlashData('del-guru-b', 'Data guru berhasil dihapus');
		} else {
			$this->session->setFlashData('del-guru-g', 'Data guru gagal dihapus');
		}

		return redirect()->to('admin/dataguru');
	}

	function flipDiagonally($arr)
	{
		$out = array();
		foreach ($arr as $key => $subarr) {
			foreach ($subarr as $subkey => $subvalue) {
				$out[$subkey][$key] = $subvalue;
			}
		}

		return $out;
	}

	public function datakelas()
	{
		$data['kelas'] = $this->adminModel->getKelas();
		$data['guru'] = $this->adminModel->getGuru();

		foreach ($data['kelas'] as $dt) {
			$dt->jumlah = $this->adminModel->countSiswa($dt->id_kelas);
		}

		return view('admin/kelas', $data);
	}

	public function adddatakelas()
	{
		$data = $this->request->getPost();
		$data = $this->flipDiagonally($data);

		foreach ($data as $dt) {
			$cek = $this->adminModel->saveDataKelas($dt);
		}

		if ($cek > 0) {
			$this->session->setFlashData('kelas-b', 'Data kelas berhasil ditambahkan');
		} else {
			$this->session->setFlashData('kelas-g', 'Data kelas gagal ditambahkan');
		}

		return redirect()->to('admin/datakelas');
	}


	public function editKelas($id)
	{
		$kelas = $this->adminModel->getKelas();
		$data['guru'] = $this->adminModel->getGuru();

		foreach ($kelas as $kl) {
			if ($kl->id_kelas == $id) {
				$data['kelas'] = $kl;
			}
		}

		return view('admin/kelas-edit', $data);
	}

	public function updateKelas($id)
	{
		$data = $this->request->getPost();
		$data['id_kelas'] = $id;

		$cek = $this->adminModel->updatekelas($data);

		if ($cek > 0) {
			$this->session->setFlashData('up-kelas-b', 'Data kelas berhasil diupdate');
		} else {
			$this->session->setFlashData('up-kelas-g', 'Data kelas gagal diupdate');
		}

		return redirect()->to('admin/datakelas');
	}

	public function delKelas($id)
	{
		$cek = $this->adminModel->delKelas($id);

		if ($cek > 0) {
			$this->session->setFlashData('del-kelas-b', 'Data kelas berhasil dihapus');
		} else {
			$this->session->setFlashData('del-kelas-g', 'Data kelas gagal dihapus');
		}

		return redirect()->to('admin/datakelas');
	}
}
