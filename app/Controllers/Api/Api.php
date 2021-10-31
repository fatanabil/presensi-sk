<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Controllers\User;

class Api extends ResourceController
{
	protected $userModel, $user;
	protected $format = 'json';

	use ResponseTrait;
	function __construct()
	{
		$this->userModel = new UserModel();
		$this->user = new User();
	}

	public function index()
	{
		$data = $this->userModel->getDataSiswa();
		$data = $data->getResult();

		return $this->respond($data, 200);
	}

	public function show($kelas = null)
	{
		$data = $this->userModel->getSiswabyKelas($kelas);
		$data = $data->getResult();

		if ($data) {
			return $this->respond($data, 200);
		} else {
			return $this->failNotFound('Data not found with kelas ' . $kelas);
		}
	}
}
