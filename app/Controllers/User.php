<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $db, $builder, $userModel, $username, $user, $nmkelas;

    protected $smt = '';

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->userModel = new UserModel;
        $this->session = session();

        if ($this->session->has('isLogin')) {
            if ($this->session->get('level') == 'user') {
                $this->username = $this->session->get('username');

                // check user is activated?
                $this->user = $this->userModel->getDataGuru($this->username);
                if (!$this->user == 0) {
                    $this->user = $this->userModel->getDataGuru($this->username);

                    $this->nmkelas = $this->user->kelas;
                } else {
                    $this->session->setFlashData('not-activated', 'Akun anda belum diaktivasi, Silakan hubungi Admin untuk aktivasi');
                    redirect()->to(base_url() . '/login');
                }
            } else {
                $username = $this->session->get('username');
                $this->user = $this->userModel->getDataAdmin($username);
            }
        }
    }

    public function index()
    {
        if (!$this->session->has('isLogin')) {
            return redirect()->to(base_url() . '/login');
        }

        if ($this->user) {
            $data['title'] = 'My Profile';
            $data['user'] = $this->user;

            return view('user/index', $data);
        } else {
            return redirect()->to(base_url() . '/login');
        }
    }

    public function absensi()
    {

        $data['title'] = 'Absensi';

        $kelas = $this->userModel->getDataKelasbyName($this->nmkelas);
        $data['kelas'] = $kelas->getResult()[0];

        $siswa = $this->userModel->getSiswabyKelas($this->nmkelas);
        $data['siswa'] = $siswa->getResult();

        return view('user/absensi', $data);
    }

    public function save()
    {
        $data = $this->request->getVar();

        $tanggal = date('d-m-Y');
        $newDate = date('Y-m-d', strtotime($tanggal));

        if ($data['semester']) {
            $smt = $data['semester'];
            unset($data['semester']);
        }


        foreach ($data as $dt => $dtvalue) :
            $cek = $this->userModel->saveAbsen($dtvalue, $newDate, $smt);
        endforeach;

        if ($cek > 0) {
            $this->session->setFlashdata('pesan', 'Data berhasil ditambah');
        } else {
            $this->session->setFlashdata('pesan-g', 'Data gagal ditambah');
        }

        return redirect()->to('user/absensi');
    }

    public function rekap()
    {
        $data['title'] = 'Rekap Absen';

        $kelas = $this->userModel->getDataKelasbyName($this->nmkelas);
        $data['kelas'] = $kelas->getResult()[0];

        $siswa = $this->userModel->getSiswabyKelas($this->nmkelas);
        $data['siswa'] = $siswa->getResult();

        foreach ($data['siswa'] as $dt) :
            $dt->hadir = $this->userModel->getTotalHadir($dt->id_siswa);
            $dt->ijin = $this->userModel->getTotalIjin($dt->id_siswa);
            $dt->sakit = $this->userModel->getTotalSakit($dt->id_siswa);
            $dt->alpa = $this->userModel->getTotalAlpa($dt->id_siswa);
            $dt->total = $dt->hadir + $dt->ijin + $dt->sakit + $dt->alpa;
        endforeach;

        return view('user/rekap', $data);
    }

    public function cari()
    {
        $data['title'] = 'Cari Data Absen';
        $keyword = '';
        $tglAwal = date('Y-m-d', strtotime(''));
        $tglAkhir = date('Y-m-d', strtotime('2200-01-01'));

        $dt = $this->request->getPost();

        if (isset($_POST['keyword']) or isset($_POST['tanggal-awal']) or isset($_POST['tanggal-akhir'])) {
            $keyword = $dt['keyword'];
            $tglAwal = $dt['tanggal-awal'];
            $tglAkhir = $dt['tanggal-akhir'];
        }

        if ($tglAwal != '' or $tglAkhir != '') {
            $absen = $this->userModel->livesearch($keyword, $this->nmkelas, $tglAwal, $tglAkhir);
            $data['absen'] = $absen->getResult();

            $data['tanggal'] = $this->userModel->getTglDistLive($keyword, $this->nmkelas, $tglAwal, $tglAkhir);
        } else {
            $absen = $this->userModel->search($keyword, $this->nmkelas, $tglAwal, $tglAkhir);
            $data['absen'] = $absen->getResult();

            $data['tanggal'] = $this->userModel->getTglDist($keyword, $this->nmkelas, $tglAwal, $tglAkhir);
        }

        return view('user/cari', $data);
    }

    public function livesearchsmt()
    {
        if ($this->request->getPost('semester')) {
            $this->smt = $this->request->getPost('semester');
            if ($this->smt == 'all') {
                $this->smt = '';
            }
        }

        $siswa = $this->userModel->getSiswabyKelas($this->nmkelas);
        $data['siswa'] = $siswa->getResult();

        foreach ($data['siswa'] as $dt) :
            $dt->hadir = $this->userModel->getTotalHadir($dt->id_siswa, $this->smt);
            $dt->ijin = $this->userModel->getTotalIjin($dt->id_siswa, $this->smt);
            $dt->sakit = $this->userModel->getTotalSakit($dt->id_siswa, $this->smt);
            $dt->alpa = $this->userModel->getTotalAlpa($dt->id_siswa, $this->smt);
            $dt->total = $dt->hadir + $dt->ijin + $dt->sakit + $dt->alpa;
            $dt->smt = $this->smt;
        endforeach;

        if ($data['siswa'] > 0) {
            $i = 1;
            foreach ($data['siswa'] as $dt => $dtVal) {
                echo '
                    <tr>
                        <td>' . $i . '</td>
                        <td>' . $dtVal->nama . '</td>
                        <td style="text-align: center;">' . $dtVal->hadir . '</td>
                        <td style="text-align: center;">' . $dtVal->ijin . '</td>
                        <td style="text-align: center;">' . $dtVal->sakit . '</td>
                        <td style="text-align: center;">' . $dtVal->alpa . '</td>
                        <td style="text-align: center;">' . $dtVal->total . '</td>
                    </tr>
                ';
                $i++;
            }
        } else {
            echo '
                <tr>
                    <td colspan="10"><b>Data Tidak Ditemukan</b></td>
                </tr>
            ';
        }

        return $data['siswa'][0]->smt = $this->smt;
    }

    public function livesearchsis()
    {
        $nama = $this->request->getPost('nama');
        $tglAwal = $this->request->getPost('tglAwal');
        $tglAkhir = $this->request->getPost('tglAkhir');

        if (isset($nama)) {
            if ($tglAwal != '' and $tglAkhir != '') {

                $absen = $this->userModel->livesearch($nama, $this->nmkelas, $tglAwal, $tglAkhir);
                $data['absen'] = $absen->getResult();

                $data['tanggal'] = $this->userModel->getTglDistLive($nama, $this->nmkelas, $tglAwal, $tglAkhir);
            } else {
                $absen = $this->userModel->search($nama, $this->nmkelas, $tglAwal, $tglAkhir);
                $data['absen'] = $absen->getResult();

                $data['tanggal'] = $this->userModel->getTglDist($nama, $this->nmkelas, $tglAwal, $tglAkhir);
            }
        } else if ($nama = '' and $tglAwal != '' and $tglAkhir != '') {
            $nama = '';

            $absen = $this->userModel->livesearch($nama, $this->nmkelas, $tglAwal, $tglAkhir);
            $data['absen'] = $absen->getResult();

            $data['tanggal'] = $this->userModel->getTglDistLive($nama, $this->nmkelas, $tglAwal, $tglAkhir);
        } else {
            $nama = '';
            $tglAwal = '';
            $tglAkhir = '';

            $absen = $this->userModel->search($nama, $this->nmkelas, $tglAwal, $tglAkhir);
            $data['absen'] = $absen->getResult();

            $data['tanggal'] = $this->userModel->getTglDist($nama, $this->nmkelas, $tglAwal, $tglAkhir);
        }

        if (!empty($data['absen'])) {
            $i = 1;
            foreach ($data['tanggal'] as $tgl) {
                if ($tgl->tanggal) {
                    $currtgl = date('d-M-Y', strtotime($tgl->tanggal));
                    echo '
                        <tr>
                            <td colspan="10" style="text-align: center;"><b>' . $currtgl . '</b></td>
                        </tr>';
                }
                foreach ($data['absen'] as $dt) {
                    if ($dt->tanggal == $tgl->tanggal) {
                        switch ($dt->absen) {
                            case 'i':
                                $dtabs = 'Ijin';
                                break;
                            case 's':
                                $dtabs = 'Sakit';
                                break;
                            case 'a':
                                $dtabs = 'Alpa';
                                break;
                            default:
                                $dtabs = 'Hadir';
                                break;
                        }
                        echo '
                                <tr>
                                    <td>' . $i . '</td>
                                    <td>' . $dt->nama . '</td>
                                    <td>' . $dt->tanggal = date('d-M-Y', strtotime($dt->tanggal)) . '</td>
                                    <td>' . $dt->semester . '</td>
                                    <td>' . $dtabs . '</td>
                                </tr>
                                ';
                        $i++;
                    }
                }
            }
        } else {
            echo '
                    <tr>
                        <td colspan="10" style="text-align: center;"><b>Data tidak ditemukan</b></td>
                    </tr>
            ';
        }
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';

        $username = $this->session->get('username');

        if ($this->session->get('level') == 'admin') {
            $data['diri'] = $this->userModel->getDataAdmin($username);
        } else {
            $data['diri'] = $this->userModel->getDataUser($username);
        }

        return view('user/edit', $data);
    }

    public function saveprofile()
    {
        $data['username'] = $this->request->getPost('username');
        $data['fullname'] = $this->request->getPost('nama');
        $data['alamat'] = $this->request->getPost('alamat');
        $data['id_guru'] = $this->request->getPost('id');

        $savep = $this->userModel->saveprofile($data);
        $savea = $this->userModel->savealamat($data['alamat'], $data['id_guru']);

        if ($savep > 0 || $savea > 0) {
            $this->session->setFlashdata('save-b', 'Data berhasil disimpan');

            return redirect()->to('user/edit');
        } else {
            $this->session->setFlashdata('save-g', 'Data gagal disimpan');

            return redirect()->to('user/edit');
        }
    }

    public function siswa()
    {
        $siswa = $this->userModel->getSiswabyKelas($this->nmkelas);
        $data['siswa'] = $siswa->getResult();

        return view('user/siswa', $data);
    }

    public function adddatasiswa()
    {
        $data = $this->request->getPost();
        $data = $this->flipDiagonally($data);

        foreach ($data as $dt) {
            $cek = $this->userModel->addDataSiswa($dt);
        }

        if ($cek > 0) {
            $this->session->setFlashData('siswa-b', 'Data siswa berhasil ditambahkan');
        } else {
            $this->session->setFlashData('siswa-g', 'Data siswa gagal ditambahkan');
        }

        return redirect()->to('/siswa');
    }

    public function deleteSiswa($id)
    {
        $cek = $this->userModel->delDataSiswa($id);

        if ($cek > 0) {
            $this->session->setFlashData('del-siswa-b', 'Data siswa berhasil dihapus');
        } else {
            $this->session->setFlashData('del-siswa-g', 'Data siswa gagal dihapus');
        }

        return redirect()->to('/siswa');
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
}
