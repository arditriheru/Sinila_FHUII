<?php

class mUserDosen extends CI_Model
{

    /*
|--------------------------------------------------------------------------
|
| Model public
|
|--------------------------------------------------------------------------
*/

    public function switchLang($lang)
    {
        if ($lang == 'en') {
            $this->db->select('id_multi_bahasa, english AS translate');
        } else {
            $this->db->select('id_multi_bahasa, indonesia AS translate');
        }

        $this->db->from('multi_bahasa');
        return $this->db->get();
    }

    public function getData($table)
    {
        return $this->db->get($table);
    }

    public function insertData($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function insert_batch($table, $data)
    {
        $this->db->insert_batch($table, $data);
        if ($this->db->affected_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateData($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
    }

    public function update_batch($table, $data, $where)
    {
        $this->db->update_batch($table, $data, $where);
    }

    public function deleteData($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function selectData($table, $column, $where, $orderby)
    {
        $this->db->select($column);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($orderby);
        return $this->db->get();
    }

    function countData($table, $where)
    {
        $this->db->where($where);
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    function periodeAktif()
    {
        $query = $this->db->query("
        SELECT semester.nama_semester, thn_akademik.thn_akademik,
            CASE
            WHEN semester.nama_semester='1' THEN 'Ganjil'
            WHEN semester.nama_semester='2' THEN 'Genap'
            END nm_semester
            FROM thn_akademik 
            JOIN semester
            ON thn_akademik.id_thn_akademik = semester.id_thn_akademik
            WHERE semester.id_semester IN
            (
            SELECT MAX(id_semester)
            FROM semester
            WHERE aktif=1
            )
            AND semester.aktif=1
        ");
        return $query;
    }

    function dataIndex($where, $orderby)
    {
        $query = $this->db->select('*')
            ->from('jadwal')
            ->join('dosen', 'jadwal.id_dosen = dosen.id_dosen')
            ->join('matakuliah', 'jadwal.id_matakuliah = matakuliah.id_matakuliah')
            ->join('absensi', 'jadwal.id_matakuliah = absensi.id_matakuliah', 'left')
            ->join('mahasiswa', 'absensi.id_mahasiswa = mahasiswa.id_mahasiswa')
            ->join('semester', 'jadwal.id_semester = semester.id_semester')
            ->where($where)
            ->order_by($orderby)
            ->get();
        return $query;
    }

    function dataMatkul($where)
    {
        $query = $this->db->select('matakuliah.*, jadwal.kelas')
            ->from('jadwal')
            ->join('matakuliah', 'jadwal.id_matakuliah = matakuliah.id_matakuliah')
            ->join('semester', 'jadwal.id_semester = semester.id_semester')
            ->join('thn_akademik', 'semester.id_thn_akademik = thn_akademik.id_thn_akademik')
            ->where($where)
            ->group_by('jadwal.id_matakuliah, jadwal.kelas')
            ->get();
        return $query;
    }

    function dataAbsensi($where)
    {
        $query = $this->db->select('*')
            ->from('jadwal')
            ->join('matakuliah', 'jadwal.id_matakuliah = matakuliah.id_matakuliah')
            ->join('absensi', 'jadwal.id_matakuliah = absensi.id_matakuliah', 'left')
            ->join('mahasiswa', 'absensi.id_mahasiswa = mahasiswa.id_mahasiswa')
            ->join('semester', 'jadwal.id_semester = semester.id_semester')
            ->join('thn_akademik', 'semester.id_thn_akademik = thn_akademik.id_thn_akademik')
            ->where($where)
            ->order_by('mahasiswa.nama_mahasiswa')
            ->get();
        return $query;
    }

    function dataSemester($where, $orderby)
    {
        $query = $this->db->select("*,
        CASE
		WHEN semester.nama_semester='1' THEN 'Ganjil'
		WHEN semester.nama_semester='2' THEN 'Genap'
		END nm_semester
        ")
            ->from('semester')
            ->join('thn_akademik', 'semester.id_thn_akademik=thn_akademik.id_thn_akademik')
            ->where($where)
            ->order_by($orderby)
            ->get();
        return $query;
    }
}
