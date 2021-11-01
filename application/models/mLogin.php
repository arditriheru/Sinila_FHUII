<?php

class mLogin extends CI_Model
{

    /*
|--------------------------------------------------------------------------
|
| Model public
|
|--------------------------------------------------------------------------
*/

    public function login($select, $from, $where)
    {
        $query = $this->db->select($select)
            ->where($where)
            ->limit('1')
            ->get($from);

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function userDosen($where)
    {
        $this->db->select('*');
        $this->db->from('penilaian_dosen');
        $this->db->where($where);
        return $this->db->get();
    }

    public function userMhs($where)
    {
        $this->db->select('*');
        $this->db->from('penilaian_mahasiswa');
        $this->db->where($where);
        return $this->db->get();
    }
}
