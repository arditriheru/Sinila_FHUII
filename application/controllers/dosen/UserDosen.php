<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load library phpspreadsheet
require('./vendor/excel/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class UserDosen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('nilai_dosen_login') != '1') {

            $this->session->set_flashdata('alert', '<div class="alert alert-danger alert-dismissable">
        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        		<p>Anda belum login!</p>
        		</div>');
            redirect('login');
        }

        $this->load->model("mUserDosen");
        $this->load->helper(array('url', 'download'));
        $this->load->library('form_validation', 'excel');
    }

    public function index()
    {
        $lang = $this->mUserDosen->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Dashboard";

        $periodeAktif = $this->mUserDosen->periodeAktif();

        if ($periodeAktif->num_rows() > 0) {
            $data['dataPeriodeAktif']   = $this->mUserDosen->periodeAktif()->row();
        } else {
            $data['dataPeriodeAktif']   = 'Kosong';
        }

        $id_dosen = $this->session->userdata('nilai_id_dosen');

        $data['countMhs'] = $this->mUserDosen->dataIndex(
            array(
                'semester.aktif'              => 1,
                'jadwal.id_dosen'   => $id_dosen,
            ),
            'mahasiswa.nama_mahasiswa ASC'
        )->num_rows();

        $data['countMkl'] = $this->mUserDosen->dataMatkul(
            array(
                'semester.aktif'              => 1,
                'jadwal.id_dosen'   => $id_dosen,
            ),
            'mahasiswa.nama_mahasiswa ASC'
        )->num_rows();

        $data['dataIndex'] = $this->mUserDosen->dataMatkul(
            array(
                'semester.id_semester'  => $periodeAktif->row()->nama_semester,
                'thn_akademik.thn_akademik'       => $periodeAktif->row()->thn_akademik,
                'jadwal.id_dosen'       => $id_dosen,
            )
        )->result();

        $data['dataThnAkad']    = $this->db->query('SELECT * FROM thn_akademik ORDER BY id_thn_akademik DESC LIMIT 10')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('dosen/vDashboard', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataDetail()
    {
        $lang = $this->mUserDosen->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Data Detail";

        $id_dosen = $this->session->userdata('nilai_id_dosen');

        $matakuliah = $this->input->get('matakuliah');
        $kelas = $this->input->get('kelas');

        $data['dataAbsensi']  = $this->mUserDosen->dataAbsensi(
            array(
                'absensi.id_matakuliah' => $matakuliah,
                'jadwal.kelas'                    => $kelas,
                'jadwal.id_dosen'       => $id_dosen,
            )
        )->result();

        $this->load->view('templates/header', $data);
        $this->load->view('dosen/vDataDetail', $data);
        $this->load->view('templates/footer', $data);
    }

    public function dataFilter()
    {
        $lang = $this->mUserDosen->switchLang($this->session->userdata('nilai_bahasa'))->result();

        foreach ($lang as $d) {
            $data['lan_' . $d->id_multi_bahasa] = $d->translate;
        }

        $data['title']      = getDateIndo();
        $data['subtitle']   = "Data Filter";

        $id_dosen = $this->session->userdata('nilai_id_dosen');

        $data['dataMatkul'] = $this->mUserDosen->dataMatkul(
            array(
                'semester.id_semester'  => $this->input->get('semester'),
                'thn_akademik.thn_akademik'       => $this->input->get('thn_akademik'),
                'jadwal.id_dosen'       => $id_dosen,
            )
        )->result();

        $matakuliah = $this->input->get('matakuliah');
        $kelas = $this->input->get('kelas');

        if (isset($matakuliah)) {
            $data['dataAbsensi']  = $this->mUserDosen->dataAbsensi(
                array(
                    'absensi.id_matakuliah' => $matakuliah,
                    'jadwal.kelas'                    => $kelas,
                    'jadwal.id_dosen'       => $id_dosen,
                )
            )->result();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('dosen/vDataFilter', $data);
        $this->load->view('templates/footer', $data);
    }

    // input bobot nilai
    public function tambahBobotNilai()
    {
        $data = array(
            'id_jadwal' => $this->input->post('id_jadwal'),
            'uts'       => $this->input->post('uts'),
            'uas'       => $this->input->post('uas'),
            'tugas'     => $this->input->post('tugas'),
        );

        if (!$this->mUserDosen->insertData('bobot_nilai', $data)) {
            $this->session->set_flashdata('success', 'Berhasil upload data');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('error', 'Gagal upload data');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    // Input nilai
    public function inputNilai()
    {
        $id_absensi = $this->input->post('id_absensi');

        $data   = array();
        $data = array();
        foreach ($id_absensi as $d => $val) {
            $data[] = array(
                "id_absensi"  => $_POST['id_absensi'][$d],
                "uts"                   => $_POST['uts'][$d],
                "uas"                   => $_POST['uas'][$d],
            );
        }

        if (!$this->mUserDosen->update_batch('absensi', $data, 'id_absensi')) {

            $this->session->set_flashdata('success', 'Berhasil memperbarui nilai');
            redirect($_SERVER['HTTP_REFERER']);
        } else {

            $this->session->set_flashdata('error', 'Gagal memperbarui nilai');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    // Import excel nilai
    public function uploadNilai()
    {
        $upload_file    = $_FILES['upload_file']['name'];
        $extension      = pathinfo($upload_file, PATHINFO_EXTENSION);

        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet    = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata      = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount     = count($sheetdata);

        if ($sheetcount > 1) {
            $data   = array();

            for ($i = 1; $i < $sheetcount; $i++) {
                $id_mahasiswa     = $sheetdata[$i][0];
                $id_matakuliah    = $sheetdata[$i][1];
                $uts                        = $sheetdata[$i][2];
                $uas                        = $sheetdata[$i][3];
                $id_semester      = $this->input->post('id_semester');

                $data[] = array(
                    'id_mahasiswa'        => $id_mahasiswa,
                    'id_matakuliah'       => $id_matakuliah,
                    'uts'                           => $uts,
                    'uas'                           => $uas,
                );
            }

            if (!$this->mUserDosen->update_batch('absensi', $data, 'id_mahasiswa')) {
                $this->session->set_flashdata('success', 'Berhasil upload data');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('error', 'Gagal upload data');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
}
