<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class AbsensiAPI extends ResourceController
{
	protected $userModel;

	use ResponseTrait;
	function __construct()
	{
		$this->userModel = new UserModel();
	}

	public function index($name = null, $kelas = null)
	{
		$data = $this->userModel->searchAPI($name, $kelas);
		$data = $data->getResult();

		return $this->respond($data, 200);
	}
}
