<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use FPDF;

class Pdf extends BaseController
{
	protected $db, $builder, $userModel;
	protected $kelas, $semester;

	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->builder = $this->db->table('absensi');
		$this->userModel = new UserModel();
	}

	public function index($kelas, $semester)
	{
		$this->kelas = $kelas;
		$this->semester = $semester;

		$smt = ucfirst($semester);

		if ($this->semester == 'all') {
			$this->semester = '';
			$smt = 'Ganjil dan Genap';
		}

		$kelas = $this->userModel->getDataKelasbyName($this->kelas);
		$kelas = $kelas->getResult();
		$tanggal = date('d-M-Y');
		// d($kelas);

		$siswa = $this->userModel->getSiswabyKelas($this->kelas);
		$siswa = $siswa->getResult();

		foreach ($siswa as $dt) :
			$dt->hadir = $this->userModel->getTotalHadir($dt->id_siswa, $this->semester);
			$dt->ijin = $this->userModel->getTotalIjin($dt->id_siswa, $this->semester);
			$dt->sakit = $this->userModel->getTotalSakit($dt->id_siswa, $this->semester);
			$dt->alpa = $this->userModel->getTotalAlpa($dt->id_siswa, $this->semester);
			$dt->total = $dt->hadir + $dt->ijin + $dt->sakit + $dt->alpa;
		endforeach;

		// d($siswa);

		$namaFile = 'Rekap Absen Kelas ' . $this->kelas . ' ' . $smt . '.pdf';

		$pdf = new FPDF('L', 'mm', 'A4');
		$pdf->AddPage();

		// Header
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(0, 7, 'REKAP ABSENSI', 0, 1, 'C');
		$pdf->Ln(10);

		//Identitas
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(20, 10, 'Kelas', 0, 0, 'L');
		$pdf->Cell(5, 10, ':', 0, 0, 'L');
		$pdf->Cell(120, 10, $this->kelas, 0, 0, 'L');
		$pdf->Cell(20, 10, 'Tanggal', 0, 0, 'L');
		$pdf->Cell(5, 10, ':', 0, 0, 'L');
		$pdf->Cell(50, 10, $tanggal, 0, 0, 'L');
		$pdf->Ln(7);
		$pdf->Cell(20, 10, 'Guru', 0, 0, 'L');
		$pdf->Cell(5, 10, ':', 0, 0, 'L');
		$pdf->Cell(120, 10, $kelas[0]->nama_guru, 0, 0, 'L');
		$pdf->Ln(7);
		$pdf->Cell(20, 10, 'Semester', 0, 0, 'L');
		$pdf->Cell(5, 10, ':', 0, 0, 'L');
		$pdf->Cell(120, 10, $smt, 0, 0, 'L');
		$pdf->Ln(15);

		//tabel absensi
		//header
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(10, 10, 'No.', 1, 0, 'C');
		$pdf->Cell(100, 10, 'Nama', 1, 0, 'C');
		$pdf->Cell(30, 10, 'Hadir', 1, 0, 'C');
		$pdf->Cell(30, 10, 'Ijin', 1, 0, 'C');
		$pdf->Cell(30, 10, 'Sakit', 1, 0, 'C');
		$pdf->Cell(30, 10, 'Alpa', 1, 0, 'C');
		$pdf->Cell(30, 10, 'Total', 1, 0, 'C');
		$pdf->Ln();

		$pdf->SetFont('Arial', '', 12);
		$i = 1;
		foreach ($siswa as $dt) {
			$pdf->Cell(10, 10, $i, 1, 0, 'C');
			$pdf->Cell(100, 10, $dt->nama, 1, 0, 'L');
			$pdf->Cell(30, 10, $dt->hadir, 1, 0, 'C');
			$pdf->Cell(30, 10, $dt->ijin, 1, 0, 'C');
			$pdf->Cell(30, 10, $dt->sakit, 1, 0, 'C');
			$pdf->Cell(30, 10, $dt->alpa, 1, 0, 'C');
			$pdf->Cell(30, 10, $dt->total, 1, 0, 'C');
			$pdf->Ln();
			$i++;
		}

		$pdf->Output('D', $namaFile);
	}
}
