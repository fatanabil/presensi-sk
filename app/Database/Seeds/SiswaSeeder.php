<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiswaSeeder extends Seeder
{
	public function run()
	{
		$faker = \Faker\Factory::create('id_ID');

		for ($i = 0; $i < 20; $i++) {
			$gender = $faker->randomElement(['male', 'female']);
			$data = [
				'nama' => $faker->name($gender),
				'id_kelas' => $faker->randomElement([1, 2, 3]),
				'jenkel' => $gender == 'male' ? 'L' : 'P',
				'alamat' => $faker->address()
			];

			$this->db->table('siswa')->insert($data);
		}
	}
}
