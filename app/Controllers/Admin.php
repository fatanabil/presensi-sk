<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;

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

		return view('admin/edit', $data);
	}

	public function save()
	{
		$data = $this->request->getPost();
		if ($this->adminModel->changeLevel($data['id'], $data['level']) > 0) {
			$this->session->setFlashdata('edit-b', 'Data Berhasil diubah');

			return redirect()->to(base_url() . '/userlists');
		} else {
			$this->session->setFlashdata('edit-g', 'Data gagal diubah');

			return redirect()->to(base_url() . '/userlists');
		}
	}
}
