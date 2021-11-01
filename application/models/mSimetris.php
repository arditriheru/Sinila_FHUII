<?php

class mSimetris extends CI_Model
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

	function autofill($id)
	{
		$this->db->select('*');
		$this->db->from('mahasiswa');
		$this->db->where(array('id_mahasiswa' => $id));
		return $this->db->get();
	}

	public function insertData($table, $data)
	{
		$this->db->insert($table, $data);
	}

	public function insert_batch($data)
	{
		$this->db->insert_batch('mhs_ijazah', $data);
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

	public function deleteData($table, $where)
	{
		$this->db->where($where);
		$this->db->delete($table);
	}

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

	function countData($table, $where)
	{
		$this->db->where($where);
		$query = $this->db->get($table);
		return $query->num_rows();
	}

	function selectData($table, $column, $where, $orderby)
	{
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderby);
		return $this->db->get();
	}

	function cariNamaMhs($table, $keyword)
	{
		$this->db->like($keyword);
		$this->db->order_by('nama_mhs', 'ASC');
		$query = $this->db->get($table);
		return $query;
	}

	function getMax($table, $column)
	{
		$this->db->select_max($column);
		$query = $this->db->get($table);
		return $query;
	}

	function dataDokter($select, $table, $where, $orderby)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderby);
		return $this->db->get();
	}

	/*
|--------------------------------------------------------------------------
|
| Model Tugas Akhir
|
|--------------------------------------------------------------------------
*/

	function selectJudul($where)
	{
		$this->db->select_max('id_ta_judul');
		$this->db->from('ta_judul');
		$this->db->where($where);
		return $this->db->get();
	}

	function dataTugasAkhir($where)
	{
		$query = $this->db->select('*, dosen1.nama_dosen AS nm_pembimbing1, dosen2.nama_dosen AS nm_pembimbing2, dosen3.nama_dosen AS nm_reviewer1, dosen4.nama_dosen AS nm_reviewer2,
		dosen1.id_dosen AS id_dosen_pembimbing1, dosen2.id_dosen AS id_dosen_pembimbing2, dosen3.id_dosen AS id_dosen_reviewer1, dosen4.id_dosen AS id_dosen_reviewer2')
			->select_max('ta_det_status.id_ta_det_status')
			->from('ta_det_status')
			->join('ta_det_nama_status', 'ta_det_status.id_ta_det_nama_status = ta_det_nama_status.id_ta_det_nama_status')
			->join('ta_status', 'ta_status.id_tugas_akhir = ta_det_status.id_tugas_akhir')
			->join('tugas_akhir', 'tugas_akhir.id_tugas_akhir = ta_status.id_tugas_akhir')
			->join('mahasiswa', 'tugas_akhir.id_mahasiswa = mahasiswa.id_mahasiswa')
			->join('departemen', 'tugas_akhir.id_departemen = departemen.id_departemen')
			->join('ta_judul', 'tugas_akhir.id_ta_judul = ta_judul.id_ta_judul')
			->join('ta_kategori', 'tugas_akhir.id_ta_kategori = ta_kategori.id_ta_kategori')
			->join('dosen AS dosen1', 'tugas_akhir.pembimbing1 = dosen1.id_dosen')
			->join('dosen AS dosen2', 'tugas_akhir.pembimbing2 = dosen2.id_dosen')
			->join('dosen AS dosen3', 'tugas_akhir.reviewer1 = dosen3.id_dosen')
			->join('dosen AS dosen4', 'tugas_akhir.reviewer2 = dosen4.id_dosen')
			->where($where)
			->group_bY('ta_det_status.id_tugas_akhir')
			->order_by('tugas_akhir.id_tugas_akhir ASC')
			->get();
		return $query;
	}

	function dataTugasAkhir2($where)
	{
		$query = $this->db->select('*, dosen1.nama_dosen AS nm_pembimbing1, dosen2.nama_dosen AS nm_pembimbing2, dosen3.nama_dosen AS nm_reviewer1, dosen4.nama_dosen AS nm_reviewer2,
		dosen1.id_dosen AS id_dosen_pembimbing1, dosen2.id_dosen AS id_dosen_pembimbing2, dosen3.id_dosen AS id_dosen_reviewer1, dosen4.id_dosen AS id_dosen_reviewer2')
			->select_max('ta_det_status.id_ta_det_status')
			->from('ta_det_status')
			->join('ta_det_nama_status', 'ta_det_status.id_ta_det_nama_status = ta_det_nama_status.id_ta_det_nama_status')
			->join('ta_status', 'ta_status.id_tugas_akhir = ta_det_status.id_tugas_akhir')
			->join('tugas_akhir', 'tugas_akhir.id_tugas_akhir = ta_status.id_tugas_akhir')
			->join('mahasiswa', 'tugas_akhir.id_mahasiswa = mahasiswa.id_mahasiswa')
			->join('departemen', 'tugas_akhir.id_departemen = departemen.id_departemen')
			->join('ta_judul', 'tugas_akhir.id_ta_judul = ta_judul.id_ta_judul')
			->join('ta_kategori', 'tugas_akhir.id_ta_kategori = ta_kategori.id_ta_kategori')
			->join('dosen AS dosen1', 'tugas_akhir.pembimbing1 = dosen1.id_dosen')
			->join('dosen AS dosen2', 'tugas_akhir.pembimbing2 = dosen2.id_dosen')
			->join('dosen AS dosen3', 'tugas_akhir.reviewer1 = dosen3.id_dosen')
			->join('dosen AS dosen4', 'tugas_akhir.reviewer2 = dosen4.id_dosen')
			->where_in($where)
			->group_bY('ta_det_status.id_tugas_akhir')
			->order_by('tugas_akhir.id_tugas_akhir ASC')
			->get();
		return $query;
	}

	// function dataTugasAkhir($where)
	// {
	// 	$query = $this->db->query("
	// 	SELECT *, dosen1.nama_dosen AS nm_pembimbing1, dosen2.nama_dosen AS nm_pembimbing2, dosen3.nama_dosen AS nm_reviewer1, dosen4.nama_dosen AS nm_reviewer2,
	// 	dosen1.id_dosen AS id_dosen_pembimbing1, dosen2.id_dosen AS id_dosen_pembimbing2, dosen3.id_dosen AS id_dosen_reviewer1, dosen4.id_dosen AS id_dosen_reviewer2
	// 	FROM ta_det_status
	// 	JOIN ta_det_nama_status
	// 	ON ta_det_status.id_ta_det_nama_status = ta_det_nama_status.id_ta_det_nama_status
	// 	JOIN ta_status
	// 	ON ta_status.id_tugas_akhir = ta_det_status.id_tugas_akhir
	// 	JOIN tugas_akhir
	// 	ON tugas_akhir.id_tugas_akhir = ta_status.id_tugas_akhir
	// 	JOIN mahasiswa
	// 	ON tugas_akhir.id_mahasiswa = mahasiswa.id_mahasiswa
	// 	JOIN departemen
	// 	ON tugas_akhir.id_departemen = departemen.id_departemen
	// 	JOIN ta_judul
	// 	ON tugas_akhir.id_ta_judul = ta_judul.id_ta_judul
	// 	JOIN ta_kategori
	// 	ON tugas_akhir.id_ta_kategori = ta_kategori.id_ta_kategori
	// 	JOIN dosen AS dosen1
	// 	ON tugas_akhir.pembimbing1 = dosen1.id_dosen
	// 	JOIN dosen AS dosen2
	// 	ON tugas_akhir.pembimbing2 = dosen2.id_dosen
	// 	JOIN dosen AS dosen3
	// 	ON tugas_akhir.reviewer1 = dosen3.id_dosen
	// 	JOIN dosen AS dosen4
	// 	ON tugas_akhir.reviewer2 = dosen4.id_dosen
	// 	WHERE id_ta_det_status
	// 	IN (SELECT MAX(ta_det_status.id_ta_det_status) FROM ta_det_status GROUP BY ta_det_status.id_tugas_akhir)
	// 	AND $where
	// 	ORDER BY tugas_akhir.id_tugas_akhir ASC
	// 	");
	// 	return $query;
	// }

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

	public function dataDetailTugasAkhir($where)
	{
		$this->db->select('*');
		$this->db->from('ta_det_status');
		$this->db->join('ta_det_nama_status', 'ta_det_status.id_ta_det_nama_status=ta_det_nama_status.id_ta_det_nama_status');
		$this->db->join('tugas_akhir', 'ta_det_status.id_tugas_akhir=tugas_akhir.id_tugas_akhir');
		$this->db->where($where);
		$this->db->order_by('ta_det_status.id_ta_det_status ASC');
		return $this->db->get();
	}

	public function dataDosen($where)
	{
		$this->db->select('*');
		$this->db->from('dosen');
		$this->db->join('departemen', 'dosen.id_departemen=departemen.id_departemen');
		$this->db->where($where);
		$this->db->order_by('dosen.nama_dosen ASC');
		return $this->db->get();
	}

	public function dataDepartemen()
	{
		$this->db->select('*');
		$this->db->from('departemen');
		$this->db->where('id_departemen !=1');
		$this->db->order_by('nama_departemen ASC');
		return $this->db->get();
	}
}
