<?php

namespace App\Models;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $db, $builder;
    protected $allowedFields = ['tanggal', 'id_siswa', 'nama_siswa', 'semester', 'absen', 'id_user', 'username', 'fullname', 'password_hash', 'salt', 'level'];

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }

    public function getDataAdmin($username)
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('id_user, username, fullname');
        $this->builder->where('username', $username);
        $query = $this->builder->get()->getResult()[0];

        return $query;
    }

    public function saveAbsen($data, $tanggal, $smt)
    {
        $this->builder = $this->db->table('absensi');
        $this->save([
            'tanggal' => $tanggal,
            'id_siswa' => $data['id'],
            'nama_siswa' => $data['nama'],
            'absen' => $data['absen'],
            'semester' => $smt
        ]);

        return $this->db->affectedRows();
    }

    public function getDataGuru($username)
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('guru.id_guru, guru.nama, guru.jenkel, kelas.kelas, guru.alamat');
        $this->builder->join('user_guru_group', 'user_guru_group.id_user = users.id_user');
        $this->builder->join('guru', 'user_guru_group.id_guru = guru.id_guru');
        $this->builder->join('kelas', 'kelas.id_guru = guru.id_guru');
        $this->builder->where('username', $username);
        $query = $this->builder->get()->getResult()[0];

        return $query;
    }

    public function getDataSiswa()
    {
        $this->builder = $this->db->table('siswa');
        $this->builder->select('id_siswa, nama, kelas, jenkel, alamat');
        $this->builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
        $query = $this->builder->get();

        return $query;
    }

    public function getSiswabyKelas($kelas)
    {
        $this->builder = $this->db->table('siswa');
        $this->builder->select('id_siswa, nama, kelas, jenkel, alamat');
        $this->builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
        $this->builder->where('kelas', $kelas);
        $query = $this->builder->get();

        return $query;
    }

    public function getDataKelasbyName($kelas)
    {
        $this->builder = $this->db->table('kelas');
        $this->builder->select('id_kelas, kelas, guru.nama as nama_guru');
        $this->builder->join('guru', 'kelas.id_guru = guru.id_guru');
        $this->builder->where('kelas', $kelas);
        $query = $this->builder->get();

        return $query;
    }

    public function getTotalHadir($id, $smt = '')
    {
        $this->builder = $this->db->table('absensi');
        $this->builder->selectCount('absen', 'h');
        $this->builder->where('absen', 'h');
        $this->builder->where('id_siswa', $id);
        $this->builder->like('semester', $smt);

        $query = $this->builder->get();
        $query = $query->getResult()[0]->h;

        return $query;
    }

    public function getTotalIjin($id, $smt = '')
    {
        $this->builder = $this->db->table('absensi');
        $this->builder->selectCount('absen', 'i');
        $this->builder->where('absen', 'i');
        $this->builder->where('id_siswa', $id);
        $this->builder->like('semester', $smt);

        $query = $this->builder->get();
        $query = $query->getResult()[0]->i;

        return $query;
    }

    public function getTotalSakit($id, $smt = '')
    {
        $this->builder = $this->db->table('absensi');
        $this->builder->selectCount('absen', 's');
        $this->builder->where('absen', 's');
        $this->builder->where('id_siswa', $id);
        $this->builder->like('semester', $smt);

        $query = $this->builder->get();
        $query = $query->getResult()[0]->s;

        return $query;
    }

    public function getTotalAlpa($id, $smt = '')
    {
        $this->builder = $this->db->table('absensi');
        $this->builder->selectCount('absen', 'a');
        $this->builder->where('absen', 'a');
        $this->builder->where('id_siswa', $id);
        $this->builder->like('semester', $smt);

        $query = $this->builder->get();
        $query = $query->getResult()[0]->a;

        return $query;
    }

    public function search($keyword, $kelas, $tglawal = '', $tglakhir = '')
    {
        $this->builder = $this->db->table('siswa');
        $this->builder->select('siswa.id_siswa, siswa.nama, semester, tanggal, absen');
        $this->builder->join('absensi', 'absensi.id_siswa = siswa.id_siswa');
        $this->builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
        $this->builder->like('nama', $keyword);
        $this->builder->like('tanggal', $tglawal);
        $this->builder->like('tanggal', $tglakhir);
        $this->builder->where('kelas', $kelas);
        $this->builder->orderBy('tanggal', 'DESC');
        $this->builder->orderBy('siswa.nama', 'ASC');

        $query = $this->builder->get();

        return $query;
    }

    public function livesearch($keyword, $kelas, $tglawal, $tglakhir)
    {
        $this->builder = $this->db->table('siswa');
        $this->builder->select('siswa.id_siswa, siswa.nama, semester, tanggal, absen');
        $this->builder->join('absensi', 'absensi.id_siswa = siswa.id_siswa');
        $this->builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
        $this->builder->like('nama', $keyword);
        $this->builder->where('tanggal >=', $tglawal);
        $this->builder->where('tanggal <=', $tglakhir);
        $this->builder->where('kelas', $kelas);
        $this->builder->orderBy('tanggal', 'DESC');
        $this->builder->orderBy('siswa.nama', 'ASC');

        $query = $this->builder->get();

        return $query;
    }

    public function getTglDist($keyword, $kelas, $tglawal = '', $tglakhir = '')
    {
        $this->builder = $this->db->table('absensi');
        $this->builder->select('tanggal');
        $this->builder->join('siswa', 'siswa.id_siswa = absensi.id_siswa');
        $this->builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
        $this->builder->like('nama', $keyword);
        $this->builder->like('tanggal', $tglawal);
        $this->builder->like('tanggal', $tglakhir);
        $this->builder->where('kelas', $kelas);
        $this->builder->distinct('tanggal');
        $this->builder->orderBy('tanggal', 'DESC');

        $query = $this->builder->get();
        $query = $query->getResult();

        return $query;
    }

    public function getTglDistLive($keyword, $kelas, $tglawal, $tglakhir)
    {
        $this->builder = $this->db->table('absensi');
        $this->builder->select('tanggal');
        $this->builder->join('siswa', 'siswa.id_siswa = absensi.id_siswa');
        $this->builder->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
        $this->builder->like('nama', $keyword);
        $this->builder->where('tanggal >=', $tglawal);
        $this->builder->where('tanggal <=', $tglakhir);
        $this->builder->where('kelas', $kelas);
        $this->builder->distinct('tanggal');
        $this->builder->orderBy('tanggal', 'DESC');

        $query = $this->builder->get();
        $query = $query->getResult();

        return $query;
    }

    public function getDataUser($username)
    {
        $this->builder = $this->db->table('users');
        $this->builder->select('username, fullname, guru.alamat, guru.id_guru');
        $this->builder->join('user_guru_group', 'user_guru_group.id_user = users.id_user');
        $this->builder->join('guru', 'guru.id_guru = user_guru_group.id_guru');
        $this->builder->where('username', $username);
        $query = $this->builder->get()->getResult()[0];

        return $query;
    }

    public function saveprofile($data)
    {
        $this->builder = $this->db->table('users');
        $this->builder->set('users.fullname', $data['fullname']);
        $this->builder->set('users.username', $data['username']);
        $this->builder->where('username', $data['username']);
        unset($data['username']);
        $this->builder->update();

        return $this->db->affectedRows();
    }

    public function savealamat($alamat, $id)
    {
        $this->builder = $this->db->table('guru');
        $this->builder->where('id_guru', $id);
        $this->builder->update(['alamat' => $alamat]);

        return $this->db->affectedRows();
    }
}
