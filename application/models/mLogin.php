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

    public function userDep($where)
    {
        $this->db->select('*');
        $this->db->from('ta_user_departemen');
        $this->db->join('departemen', 'ta_user_departemen.id_departemen=departemen.id_departemen');
        $this->db->where($where);
        return $this->db->get();
    }

    public function userMhs($where)
    {
        $this->db->select('*');
        $this->db->from('mahasiswa');
        $this->db->where($where);
        return $this->db->get();
    }

    public function userDosen($where)
    {
        $this->db->select('*');
        $this->db->from('dosen');
        $this->db->where($where);
        return $this->db->get();
    }

    public function userInstansi($where)
    {
        $this->db->select('*');
        $this->db->from('magang_instansi_pic');
        $this->db->join('magang_instansi', 'magang_instansi_pic.id_magang_instansi=magang_instansi.id_magang_instansi');
        $this->db->where($where);
        return $this->db->get();
    }
}
