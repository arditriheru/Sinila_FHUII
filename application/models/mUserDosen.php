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
        SELECT penilaian_semester.nama_semester, penilaian_thn_akademik.thn_akademik,
            CASE
            WHEN penilaian_semester.nama_semester='1' THEN 'Ganjil'
            WHEN penilaian_semester.nama_semester='2' THEN 'Genap'
            END nm_semester
            FROM penilaian_thn_akademik 
            JOIN penilaian_semester
            ON penilaian_thn_akademik.id_penilaian_thn_akademik = penilaian_semester.id_penilaian_thn_akademik
            WHERE penilaian_semester.id_penilaian_semester IN
            (
            SELECT MAX(id_penilaian_semester)
            FROM penilaian_semester
            WHERE aktif=1
            )
            AND penilaian_semester.aktif=1
        ");
        return $query;
    }

    function dataIndex($where, $orderby)
    {
        $query = $this->db->select('penilaian_jadwal.kelas, penilaian_dosen.*, penilaian_matakuliah.*, penilaian_mahasiswa.*')
            ->from('penilaian_jadwal')
            ->join('penilaian_dosen', 'penilaian_jadwal.id_penilaian_dosen = penilaian_dosen.id_penilaian_dosen')
            ->join('penilaian_matakuliah', 'penilaian_jadwal.id_penilaian_matakuliah = penilaian_matakuliah.id_penilaian_matakuliah')
            ->join('penilaian_absensi', 'penilaian_jadwal.id_penilaian_matakuliah = penilaian_absensi.id_penilaian_matakuliah', 'left')
            ->join('penilaian_mahasiswa', 'penilaian_absensi.id_penilaian_mahasiswa = penilaian_mahasiswa.id_penilaian_mahasiswa')
            ->join('penilaian_semester', 'penilaian_jadwal.id_penilaian_semester = penilaian_semester.id_penilaian_semester')
            ->where($where)
            ->order_by($orderby)
            ->get();
        return $query;
    }

    function dataMatkul($where)
    {
        $query = $this->db->select('penilaian_matakuliah.*')
            ->from('penilaian_jadwal')
            ->join('penilaian_matakuliah', 'penilaian_jadwal.id_penilaian_matakuliah = penilaian_matakuliah.id_penilaian_matakuliah')
            ->join('penilaian_semester', 'penilaian_jadwal.id_penilaian_semester = penilaian_semester.id_penilaian_semester')
            ->join('penilaian_thn_akademik', 'penilaian_semester.id_penilaian_thn_akademik = penilaian_thn_akademik.id_penilaian_thn_akademik')
            ->where($where)
            ->group_by('penilaian_jadwal.id_penilaian_matakuliah')
            ->get();
        return $query;
    }

    function dataAbsensi($where)
    {
        $query = $this->db->select('penilaian_matakuliah.*, penilaian_mahasiswa.*')
            ->from('penilaian_jadwal')
            ->join('penilaian_matakuliah', 'penilaian_jadwal.id_penilaian_matakuliah = penilaian_matakuliah.id_penilaian_matakuliah')
            ->join('penilaian_absensi', 'penilaian_jadwal.id_penilaian_matakuliah = penilaian_absensi.id_penilaian_matakuliah', 'left')
            ->join('penilaian_mahasiswa', 'penilaian_absensi.id_penilaian_mahasiswa = penilaian_mahasiswa.id_penilaian_mahasiswa')
            ->join('penilaian_semester', 'penilaian_jadwal.id_penilaian_semester = penilaian_semester.id_penilaian_semester')
            ->join('penilaian_thn_akademik', 'penilaian_semester.id_penilaian_thn_akademik = penilaian_thn_akademik.id_penilaian_thn_akademik')
            ->where($where)
            ->group_by('penilaian_absensi.id_penilaian_mahasiswa')
            ->order_by('penilaian_mahasiswa.nama_mahasiswa')
            ->get();
        return $query;
    }
}
