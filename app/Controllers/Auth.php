<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
	protected $userModel;

	public function __construct()
	{
		$this->userModel = new UserModel();
		$this->validation = \Config\Services::validation();
		$this->session = session();
	}

	public function login()
	{
		$data['title'] = 'Login';

		return view('auth/login', $data);
	}

	public function register()
	{
		$data['title'] = 'Register';

		return view('auth/register', $data);
	}

	public function validRegister()
	{
		$data = $this->request->getPost();

		$this->validation->run($data);

		$error = $this->validation->getErrors();

		if ($error) {
			$this->session->setFlashdata('error', $error);
			return redirect()->to(base_url() . '/register');
		}

		if ($data['password'] != $data['repeat-password']) {
			session()->setFlashdata('rep', 'Password tidak cocok');

			return redirect()->to(base_url() . '/register');
		}

		$salt = uniqid('', true);

		$pass = md5($data['password'] . $salt);

		$this->userModel->save([
			'username' => $data['username'],
			'salt' => $salt,
			'password_hash' => $pass,
			'level' => 'user'
		]);

		$this->session->setFlashdata('login', 'Anda berhasil mendaftar, silahkan hubungi Admin untuk melakukan aktivasi');

		return redirect()->to(base_url() . '/login');
	}

	public function validLogin()
	{
		$data = $this->request->getPost();

		$user = $this->userModel->builder('users')->where('username', $data['username'])->get()->getResultArray();

		if ($user) {
			$user = $user[0];
			if ($user['password_hash'] != md5($data['password'] . $user['salt'])) {
				$this->session->setFlashdata('password', 'Password salah !');

				$error = 'Password slah';

				d($error);

				return redirect()->to(base_url() . '/login');
			} else {
				$sessLogin = [
					'isLogin' => true,
					'username' => $user['username'],
					'level' => $user['level']
				];

				$this->session->set($sessLogin);

				if ($user['level'] == 'user') {
					return redirect()->to(base_url());
				} else {
					return redirect()->to(base_url() . '/userlists');
				}
			}
		} else {
			$this->session->setFlashdata('username', 'Username tidak ditemukan');

			return redirect()->to(base_url() . '/login');
		}
	}

	public function logout()
	{
		$this->session->destroy();

		return redirect()->to(base_url() . '/login');
	}
}
